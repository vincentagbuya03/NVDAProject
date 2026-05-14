<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DegreeController extends Controller
{
    public function index(): View
    {
        $degrees = Degree::orderBy('name')->get();

        return view('degree.index', compact('degrees'));
    }

    public function create(): View
    {
        return view('degree.adddegree');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:degrees,name'],
            'code' => ['required', 'string', 'max:50', 'unique:degrees,code'],
            'department' => ['required', 'string', 'max:50'],
        ]);

        $degree = Degree::create($validated);

        Log::info('Degree created', [
            'degree_id' => $degree->id,
            'name' => $degree->name,
            'actor_id' => auth()->id(),
        ]);

        return redirect()->route('degrees.index')->with('success', 'Degree added successfully.');
    }

    public function edit(Degree $degree): View
    {
        Log::info('Degree edit opened', [
            'degree_id' => $degree->id,
            'actor_id' => auth()->id(),
        ]);

        return view('degree.editdegree', compact('degree'));
    }

    public function update(Request $request, Degree $degree): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('degrees', 'name')->ignore($degree->id),
            ],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('degrees', 'code')->ignore($degree->id),
            ],
            'department' => [
                'required',
                'string',
                'max:50',
                Rule::unique('degrees', 'department')->ignore($degree->id),
            ],
        ]);

        $degree->update($validated);

        Log::info('Degree updated', [
            'degree_id' => $degree->id,
            'actor_id' => auth()->id(),
        ]);

        return redirect()->route('degrees.index')->with('success', 'Degree updated successfully.');
    }

    public function destroy(Request $request, Degree $degree)
    {
        $deletedDegreeId = $degree->id;

        $degree->delete();

        Log::info('Degree deleted', [
            'degree_id' => $deletedDegreeId,
            'actor_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Degree deleted successfully.'
            ]);
        }

        return redirect()->route('degrees.index')->with('success', 'Degree deleted successfully.');
    }
}