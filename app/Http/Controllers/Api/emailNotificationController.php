<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Email Notifications",
 *     description="API لإدارة إشعارات البريد الإلكتروني"
 * )
 */
class emailNotificationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/notifications",
     *     summary="جلب جميع الإشعارات مع المستخدمين",
     *     tags={"Email Notifications"},
     *     @OA\Response(
     *         response=200,
     *         description="قائمة الإشعارات"
     *     )
     * )
     */
    public function index()
    {
        return Notification::with('user')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/notifications",
     *     summary="إنشاء إشعار جديد",
     *     tags={"Email Notifications"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "type", "message"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="type", type="string", example="reminder"),
     *             @OA\Property(property="message", type="string", example="موعدك غداً الساعة 10"),
     *             @OA\Property(property="sent_at", type="string", format="date-time", example="2025-05-21 10:00:00")
     *         )
     *     ),
     *     @OA\Response(response=201, description="تم إنشاء الإشعار"),
     *     @OA\Response(response=422, description="خطأ في التحقق من البيانات")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'message' => 'required|string',
            'sent_at' => 'nullable|date',
        ]);

        $notification = Notification::create($data);

        \Mail::to($notification->user->email)
            ->send(new \App\Mail\NotificationEmail($notification));

        return response()->json($notification, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/notifications/{id}",
     *     summary="عرض إشعار محدد",
     *     tags={"Email Notifications"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="رقم الإشعار",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="تم العثور على الإشعار"),
     *     @OA\Response(response=404, description="لم يتم العثور على الإشعار")
     * )
     */
    public function show(string $id)
    {
        $notification = Notification::with('user')->findOrFail($id);
        return $notification;
    }

    /**
     * @OA\Delete(
     *     path="/api/notifications/{id}",
     *     summary="حذف إشعار",
     *     tags={"Email Notifications"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="رقم الإشعار",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="تم الحذف بنجاح"),
     *     @OA\Response(response=404, description="لم يتم العثور على الإشعار")
     * )
     */
    public function destroy(string $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json(null, 204);
    }
}
