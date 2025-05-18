<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Practitioner;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
   
    public function index()
    {
        $practitioners = Practitioner::all();
        return response()->json($practitioners);
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:practitioners,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
        ]);

        $practitioner = Practitioner::create($validated);

        return response()->json($practitioner, 201);
    }

    
    public function show($id)
    {
        $practitioner = Practitioner::findOrFail($id);
        return response()->json($practitioner);
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:practitioners,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
        ]);

        $practitioner->update($validated);

        return response()->json($practitioner);
    }

    
    public function destroy($id)
    {
        $practitioner = Practitioner::findOrFail($id);
        $practitioner->delete();

        return response()->json(['message' => 'Practitioner deleted successfully']);
    }
}

