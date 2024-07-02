<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, IdConverter;

    protected $collection = 'users';

    public const ADMIN = 'admin';
    public const ACCOUNT_MANGER = 'account_manger';
    public const SALESMAN = 'salesman';
    public const STATUS = [self::ADMIN, self::ACCOUNT_MANGER, self::SALESMAN];


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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
