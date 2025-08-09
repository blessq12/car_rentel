<?php

namespace App\Enums;

enum DealType: string
{
    case RENTAL_WITHOUT_DEPOSIT = 'rental_without_deposit';
    case RENTAL_WITH_DEPOSIT = 'rental_with_deposit';
    case RENT_TO_OWN = 'rent_to_own';

    public function label(): string
    {
        return match($this) {
            self::RENTAL_WITHOUT_DEPOSIT => 'Аренда без залога',
            self::RENTAL_WITH_DEPOSIT => 'Аренда с залогом',
            self::RENT_TO_OWN => 'Аренда под выкуп',
        };
    }
}
