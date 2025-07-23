<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guard = 'admin'; //specify the guard for this model
    // This is useful if you have multiple user types and want to differentiate them.
    // For example, you might have 'admin', 'user', etc. in your config/auth.php
    // and you want to use this model with the 'admin' guard.
    // If you don't need multiple guards, you can remove this line.
    // If you do not specify a guard, it will use the default 'web' guard
    // defined in your config/auth.php file.
    // If you want to use this model with the 'admin' guard, you need to specify it here.
    // If you want to use this model with the 'web' guard, you can remove this line.
    
    protected $guarded = []; //all fields are fillable
    protected $guard_name = 'admin';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getPermissionGroups()
    {
        $permissionsGroup = DB::table('permissions')
            ->select('group_name')
            ->distinct()
            ->get();

        return $permissionsGroup;
    }
}
