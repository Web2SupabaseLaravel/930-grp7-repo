<?php


namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string',
            'duration_minutes' => 'required|integer',
            'price' => 'required|integer',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string',
            'duration_minutes' => 'required|integer',
            'price' => 'required|integer',
        ]);

        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Service updated!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted!');
    }
}
