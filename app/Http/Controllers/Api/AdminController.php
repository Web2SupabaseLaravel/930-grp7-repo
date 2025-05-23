<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Admin",
 *     description="Endpoints that allow admin & staff to manage patients"
 * )
 */
class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     tags={"Admin"},
     *     summary="List all patients",
     *     description="Returns every user whose role is patient.",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful list",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=5),
     *                     @OA\Property(property="first_name", type="string", example="Fatima"),
     *                     @OA\Property(property="last_name",  type="string", example="Qasim"),
     *                     @OA\Property(property="email", type="string", example="fatima@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index()
    {
        $patients = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->get();

        return response()->json([
            'status' => 'success',
            'data'   => $patients
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/patients/{id}",
     *     tags={"Admin"},
     *     summary="Update a patient's information",
     *     description="Admin or staff can update any patient’s basic info.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Patient ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Sara"),
     *             @OA\Property(property="last_name",  type="string", example="Yousef"),
     *             @OA\Property(property="email",      type="string", example="sara@mail.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient successfully updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="تم تعديل بيانات المريض من قبل المدير"),
     *             @OA\Property(property="data",
     *                 @OA\Property(property="id",   type="integer", example=5),
     *                 @OA\Property(property="first_name", type="string", example="Sara"),
     *                 @OA\Property(property="last_name",  type="string", example="Yousef"),
     *                 @OA\Property(property="email",      type="string", example="sara@mail.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient not found"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id)
    {
        $patient = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name'  => 'sometimes|string|max:255',
            'email'      => 'sometimes|email|unique:users,email,' . $patient->id,
        ]);

        $patient->update($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تعديل بيانات المريض من قبل المدير',
            'data'    => $patient
        ]);
    }
}
