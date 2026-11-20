<?php

declare(strict_types=1);

namespace App\Support\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case ADMINISTRATOR = 'administrator'; // Backwards compatibility alias
    case WOMEN = 'women';
    case UMUM = 'umum';
    case KOMUNITAS = 'komunitas';
    case PROFESIONAL = 'profesional';
    case FIELD_SALES = 'field-sales';     // Backwards compatibility alias
    case B2B_CLIENT = 'b2b-client';       // Backwards compatibility alias
    case CUSTOMER = 'customer';           // Backwards compatibility alias

    public function label(): string
    {
        return match ($this) {
            self::ADMIN, self::ADMINISTRATOR => 'Admin',
            self::WOMEN => 'Women',
            self::UMUM => 'Umum',
            self::KOMUNITAS, self::B2B_CLIENT => 'Komunitas',
            self::PROFESIONAL => 'Profesional',
            self::FIELD_SALES => 'Field Sales',
            self::CUSTOMER => 'Pelari Umum',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::ADMIN, self::ADMINISTRATOR => 'black',
            self::WOMEN => 'rose',
            self::UMUM, self::CUSTOMER => 'concrete',
            self::KOMUNITAS, self::B2B_CLIENT => 'volt',
            self::PROFESIONAL => 'blaze',
            self::FIELD_SALES => 'volt',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::ADMIN, self::ADMINISTRATOR => 'admin.dashboard',
            self::FIELD_SALES => 'sales.dashboard',
            self::B2B_CLIENT => 'portal.dashboard',
            self::WOMEN, self::UMUM, self::KOMUNITAS, self::PROFESIONAL, self::CUSTOMER => 'customer.dashboard',
        };
    }
}
