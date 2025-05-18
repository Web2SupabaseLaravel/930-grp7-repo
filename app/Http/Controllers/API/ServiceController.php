<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
   
    public function index()
    {
        return response()->json(Service::all(), 200);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'name' => 'required|string|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201);
    }

    
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service, 200);
    }

    
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'description' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:100',
            'duration_minutes' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0'
        ]);

        $service->update($validated);

        return response()->json($service, 200);
    }

    
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 204);
    }
}
