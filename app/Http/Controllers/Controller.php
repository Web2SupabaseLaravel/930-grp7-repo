<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Appointment API - نظام حجز المواعيد",
 *     version="1.0.0",
 *     description="توثيق API لحجز المواعيد بين المرضى والممارسين والخدمات."
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


}
