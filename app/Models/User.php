<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
     * Get user permissions attribute
     * 
     * @return array
     */
    public function getPermissionsAttr()
    {
        return [  
            'users' => [
                'show' => $this->can('users.show'),
                'edit' => $this->can('users.edit'),
                'destroy' => $this->can('users.destroy')
            ],
            'manuscripts' => [
                'show' => $this->can('manuscripts.show'),
                'edit' => $this->can('manuscripts.edit'),
                'destroy' => $this->can('manuscripts.destroy')
            ],
            'journals' => [
                'show' => $this->can('journals.show'),
                'edit' => $this->can('journals.edit'),
                'destroy' => $this->can('journals.destroy')
            ],
            'settings' => [
                'show' => $this->can('settings.show'),
                'edit' => $this->can('settings.edit'),
                'destroy' => $this->can('settings.destroy')
            ],
            'dashboard' => [
                'show' => $this->can('dashboard.show'),
                'show_all' => $this->can('dashboard.show all'),
            ]
        ];
    }
}
