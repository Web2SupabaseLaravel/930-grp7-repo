<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }     
     
    public function index()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin','staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return User::where('role','patient')->get();
    }

    public function show($id)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin','staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $patient = User::where('role','patient')->findOrFail($id);
        return response()->json($patient);
    }
    
    
    public function update(Request $request, $id)
    {
        $auth = auth()->user();

        if ($auth->role === 'patient' && $auth->id != $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if ($auth->role !== 'patient' && !in_array($auth->role, ['admin','staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $patient = User::where('role','patient')->findOrFail($id);

        $data = $request->validate([
            'name'            => 'sometimes|string|max:255',
            'email'           => ['sometimes','email', Rule::unique('users','email')->ignore($patient->id)],
            'phone'           => 'sometimes|nullable|string|max:20',
            'insurance_info'  => 'sometimes|nullable|string',
        ]);

        $patient->update($data);
        return response()->json($patient);
    }
 
    public function myAppointments()
    {
        $user = auth()->user();
        if ($user->role !== 'patient') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $user->appointments()->with(['practitioner','service'])->get();
    }
}
