<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectorLicense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'inspection_license',
        'driver_license',
        'driver_city_name',
        'tax_id',
    ];

    /* Relationships */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
