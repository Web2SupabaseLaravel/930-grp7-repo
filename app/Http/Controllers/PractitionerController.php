<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use App\Models\Service;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
    public function index()
    {
        $practitioners = Practitioner::with('services')->get();
        return view('practitioners.index', compact('practitioners'));
    }

    public function create()
    {
        $services = Service::all();
        return view('practitioners.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|integer',
            'specialization' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'contact' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'services' => 'array',
        ]);

        $practitioner = Practitioner::create($data);
        $practitioner->services()->sync($request->services ?? []);

        return redirect()->route('practitioners.index')->with('success', 'Practitioner created successfully.');
    }

    public function show($id)
    {
        $practitioner = Practitioner::with('services')->findOrFail($id);
        return view('practitioners.show', compact('practitioner'));
    }

    public function edit($id)
    {
        $practitioner = Practitioner::with('services')->findOrFail($id);
        $services = Service::all();
        return view('practitioners.edit', compact('practitioner', 'services'));
    }

    public function update(Request $request, $id)
    {
        $practitioner = Practitioner::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'nullable|integer',
            'specialization' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'contact' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'services' => 'array',
        ]);

        $practitioner->update($data);
        $practitioner->services()->sync($request->services ?? []);

        return redirect()->route('practitioners.index')->with('success', 'Practitioner updated successfully.');
    }

    public function destroy($id)
    {
        $practitioner = Practitioner::findOrFail($id);
        $practitioner->services()->detach();
        $practitioner->delete();

        return redirect()->route('practitioners.index')->with('success', 'Practitioner deleted.');
    }
}
