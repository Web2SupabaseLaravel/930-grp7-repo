<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     title="Booking",
 *     description="Model يمثل الحجز",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="service", type="string", example="فحص طبي"),
 *     @OA\Property(property="appointment", type="string", format="date-time", example="2025-06-01T10:00:00"),
 *     @OA\Property(property="notes", type="string", example="يرجى الحضور قبل الموعد بـ 15 دقيقة"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class  EmailNotification extends Model
{
    protected $fillable = ['user_id', 'service', 'appointment', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

