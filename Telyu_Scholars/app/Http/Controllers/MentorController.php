<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index()
    {
        $mentors = Mentor::all();
        return view('admin.mentors.index', compact('mentors'));
    }

    public function create()
    {
        return view('admin.mentors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'platform' => 'required|string',
            'location' => 'required|string',
            'working_days' => 'required|string',
            'time_schedule' => 'required|string',
            'specialty' => 'required|string',
            'profile_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('mentors', 'public');
            $validated['profile_image'] = $path;
        }

        Mentor::create($validated);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor successfully added.');
    }

    public function edit($id)
    {
        $mentor = Mentor::findOrFail($id);
        return view('admin.mentors.edit', compact('mentor'));
    }

    public function update(Request $request, $id)
    {
        $mentor = Mentor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'platform' => 'required|string',
            'location' => 'required|string',
            'working_days' => 'required|string',
            'time_schedule' => 'required|string',
            'specialty' => 'required|string',
            'profile_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('mentors', 'public');
            $validated['profile_image'] = $path;
        }

        $mentor->update($validated);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor settings updated successfully.');
    }

    public function destroy($id)
    {
        $mentor = Mentor::findOrFail($id);
        $mentor->delete();

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor row deleted successfully.');
    }
}