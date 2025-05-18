<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'name' => 'required|string',
            'duration_minutes' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $service = Service::create($validated);
        return response()->json($service, 201);
    }

    public function show($id)
    {
        return Service::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'description' => 'sometimes|string',
            'name' => 'sometimes|string',
            'duration_minutes' => 'sometimes|integer',
            'price' => 'sometimes|numeric'
        ]);

        $service->update($validated);
        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(null, 204);
    }
}
