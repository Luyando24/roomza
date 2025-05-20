<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'business_type',
        'password',
        'business_name',
        'business_type',
        'business_registration_number',
        'business_address',
        'business_registration_document',
        'business_phone',
        'business_email',
        'business_website',
        'business_description',
        'business_logo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Check if user has a specific role.
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        if (in_array('admin', $roles) && $this->isAdmin()) {
            return true;
        }

        if (in_array('business', $roles) && $this->business_type === 'business') {
            return true;
        }

        if (in_array('personal', $roles) && $this->business_type !== 'business') {
            return true;
        }

        return false;
    }

    /**
     * Check if user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // You can implement your admin check logic here
        // For example, check if email is admin@example.com or if there's an is_admin column
        return $this->email === 'admin@example.com' || ($this->is_admin ?? false);
    }

    /**
     * Check if user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        // Admins have all permissions
        if ($this->isAdmin()) {
            return true;
        }

        // Business users have specific permissions
        if ($this->business_type === 'business') {
            $businessPermissions = [
                'view properties',
                'create properties',
                'edit properties',
                'delete properties',
            ];

            return in_array($permission, $businessPermissions);
        }

        // Personal users have limited permissions
        $personalPermissions = [
            'view properties',
        ];

        return in_array($permission, $personalPermissions);
    }
}



