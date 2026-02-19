<?php

namespace App\Enums;

enum UserRoles: int
{
    case DOCTOR  = 0;
    case PATIENT = 1;
    case ADMIN   = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }

    public static function isDoctor(UserRoles $userRole): bool
    {
        return $userRole === self::DOCTOR;
    }

    public static function isAdmin(UserRoles $userRole): bool
    {
        return $userRole === self::ADMIN;
    }

    public static function isPatient(UserRoles $userRole): bool
    {
        return $userRole === self::PATIENT;
    }
}
