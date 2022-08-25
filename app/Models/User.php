<?php

namespace App\Models;

use App\QueryFilter;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    use HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected static $logAttributes = ["name", 'email', 'address_1', 'address_2', 'postcode', 'city', 'state', 'fax_no', 'website_url', 'about', 'photo', 'country'];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scoped Filter method.
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Get manuscript reviewed
     * 
     * @return Collection
     */
    public function manuscriptReviewed()
    {
        return Manuscript::leftJoin('manuscript_members', 'manuscripts.id', '=', 'manuscript_members.manuscript_id')->where('manuscript_members.user_id', $this->id)->where('manuscript_members.role', 'reviewer')->where('manuscript_members.reviewed', '!=', null)->get();
    }
    
    /**
     * Get user permissions attribute
     * 
     * @return array
     */
    public function roleBasedPermissions()
    {
        $roles = Role::all();
        $permissions = collect();
        $data = collect();
        foreach ($roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }
        $modules = $permissions->map(function($q) {
            $exp = explode('.', $q->name);
            return ['module' => $exp[0], "permission" => $exp[1]];
        })->unique()->groupBy('module');
        foreach ($modules as $key => $permissions) {
            $listOfCan = collect();
            foreach ($permissions as $permission) {
                $listOfCan->prepend($this->can("{$permission['module']}.{$permission['permission']}"), $permission['permission']);
            }
            $data = $data->merge([
                $key => $listOfCan
            ]);
        }
        return $data->toArray();
    }

    public static function getTotalReviewersReviewedManuscripts()
    {
        $reviewers = User::whereHas('roles', function($q) {
            $q->where('name', 'Reviewer');
        })->get();
        $total = 0;
        foreach($reviewers as $reviewer) {
            $total += $reviewer->manuscriptReviewed()->count();
        }
        return $total;
    }

    /**
     * @param array
     * @param mix
     * @param mix
     * 
     * @return void
     */
    public static function mailTo($users, $mailableClass, $object)
    {
        foreach ($users as $user) {
            Mail::to($user)->queue(new $mailableClass($object, $user));
        }
    }
}
