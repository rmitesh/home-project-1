<?php

namespace App\Enums;

use Filament\Support\Contracts;

enum InspectionRequestStatus: string implements Contracts\HasColor, Contracts\HasLabel
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case RESCHEDULED = 'rescheduled';
    
    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::RESCHEDULED => 'Rescheduled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'primary',
            self::ACCEPTED => 'success',
            self::REJECTED => 'danger',
            self::RESCHEDULED => 'info',
        };
    }
}
