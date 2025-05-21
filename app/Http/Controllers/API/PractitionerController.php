<?php
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Practitioner;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
    public function index()
    {
        return Practitioner::with('services')->get();
    }

  public function store(Request $request)
{
    if (Gate::denies('manage-practitioners')) {
        abort(403, 'Unauthorized');
    }

    $data = $request->validate([
        'name'           => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'qualifications' => 'nullable|string',
        'email'          => 'required|email|unique:practitioners',
        'phone'          => 'nullable|string|max:20',
        'working_hours'  => 'nullable|string',
        'services'       => 'array',             
        'services.*'     => 'exists:services,id',
    ]);

    $pr = Practitioner::create($data);
    if (!empty($data['services'])) {
        $pr->services()->sync($data['services']);
    }
    return response()->json($pr->load('services'), 201);
}


    public function show($id)
    {
        return Practitioner::with('services')->findOrFail($id);
    }

public function update(Request $request, $id)
{
    if (Gate::denies('manage-practitioners')) {
        abort(403, 'Unauthorized');
    }

    $pr = Practitioner::findOrFail($id);
    $data = $request->validate([
        'name'           => 'sometimes|string|max:255',
        'specialization' => 'sometimes|string|max:255',
        'qualifications' => 'nullable|string',
        'email'          => 'sometimes|email|unique:practitioners,email,'.$id,
        'phone'          => 'nullable|string|max:20',
        'working_hours'  => 'nullable|string',
        'services'       => 'array',
        'services.*'     => 'exists:services,id',
    ]);

    $pr->update($data);
    if (isset($data['services'])) {
        $pr->services()->sync($data['services']);
    }
    return response()->json($pr->load('services'));
}


public function destroy($id)
{
    if (Gate::denies('manage-practitioners')) {
        abort(403, 'Unauthorized');
    }

    Practitioner::findOrFail($id)->delete();
    return response()->json(['message'=>'Deleted successfully'], 204);
}

}
