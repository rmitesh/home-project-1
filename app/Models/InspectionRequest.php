<?php

namespace App\Models;

use App\Enums\InspectionRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionRequest extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::creating(function (InspectionRequest $inspectionRequest) {
            $inspectionRequest->request_number = (string) str(static::max('request_number') + 1)->padLeft(6, 0);
            if (auth()->user()->hasRole(User::ROLE_BUYER)) {
                $inspectionRequest->requested_by = auth()->id();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'inspector_id',
        'requested_by',
        'request_number',
        'book_at',
        'notes',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => InspectionRequestStatus::class,
        ];
    }

    /* Relationships */

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
