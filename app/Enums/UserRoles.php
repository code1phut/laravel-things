<?php


namespace App\Enums;


class UserRoles
{
    public const USER = 'User';
    public const ADMIN = 'Admin';

    public static function all(): array
    {
        return [
            self::USER,
            self::ADMIN,
        ];
    }
}