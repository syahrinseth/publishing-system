<?php

namespace App\Models;

use App\QueryFilter;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
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
        'name',
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
    public function getPermissionsAttr()
    {
        return [  
            'users' => [
                'create' => $this->can('users.create'),
                'show' => $this->can('users.show'),
                'edit' => $this->can('users.edit'),
                'destroy' => $this->can('users.destroy')
            ],
            'manuscripts' => [
                'show' => $this->can('manuscripts.show'),
                'edit' => $this->can('manuscripts.edit'),
                'destroy' => $this->can('manuscripts.destroy'),
                'publish' => $this->can('manuscripts.publish'),
                'review' => $this->can('manuscripts.review'),
                'show_all' => $this->can('manuscripts.show_all'),
                'cover_letter' => $this->can('manuscripts.cover_letter'),
                'conflict_of_interest' => $this->can('manuscripts.conflict_of_interest'),
                'declaration_of_interest_statement' => $this->can('manuscripts.declaration_of_interest_statement'),
            ],
            'journals' => [
                'create' => $this->can('journals.create'),
                'show' => $this->can('journals.show'),
                'edit' => $this->can('journals.edit'),
                'destroy' => $this->can('journals.destroy'),
                'show_all' => $this->can('journals.show_all'),
            ],
            'settings' => [
                'show' => $this->can('settings.show'),
                'edit' => $this->can('settings.edit'),
                'destroy' => $this->can('settings.destroy')
            ],
            'dashboard' => [
                'show' => $this->can('dashboard.show'),
                'show_all' => $this->can('dashboard.show_all'),
                'show_reviewers_status' => $this->can('dashboard.show_reviewers_status'),
            ],
            'roles_and_permissions' => [
                'edit' => $this->can('roles_and_permissions.edit')
            ]
        ];
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
}
