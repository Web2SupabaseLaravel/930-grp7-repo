<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::with('practitioners')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
        ]);

        $svc = Service::create($data);
        return response()->json($svc, 201);
    }

    public function show($id)
    {
        return Service::with('practitioners')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $svc = Service::findOrFail($id);
        $data = $request->validate([
            'name'             => 'sometimes|string|max:100',
            'description'      => 'sometimes|string|max:255',
            'duration_minutes' => 'sometimes|integer|min:1',
            'price'            => 'sometimes|numeric|min:0',
        ]);

        $svc->update($data);
        return response()->json($svc);
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return response()->json(['message'=>'Deleted successfully'], 204);
    }
}
