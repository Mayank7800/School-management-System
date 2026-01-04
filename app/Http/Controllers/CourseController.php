<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section; // ✅ import Section model

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('sections')->orderBy('id', 'asc')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

   // In your store method
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'short_name' => 'nullable|string|max:20',
        'class_type' => 'required|string',
        'status' => 'required|string|in:Active,Inactive',
        'description' => 'nullable|string|max:500',
        'sections' => 'required|array|min:1',
        'sections.*.name' => 'required|string|max:10',
        'sections.*.class_name' => 'required|string|max:100',
    ]);

    // Create course
    $course = Course::create($validated);

    // Create sections with class names
    foreach ($request->sections as $sectionData) {
        $course->sections()->create([
            'name' => $sectionData['name'],
            'class_name' => $sectionData['class_name'],
            'status' => 'Active'
        ]);
    }

    return redirect()->route('courses.index')->with('success', 'Course created successfully!');
}

// In your update method
public function update(Request $request, Course $course)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'short_name' => 'nullable|string|max:20',
        'class_type' => 'required|string',
        'status' => 'required|string|in:Active,Inactive',
        'description' => 'nullable|string|max:500',
        'sections' => 'required|array|min:1',
        'sections.*.name' => 'required|string|max:10',
        'sections.*.class_name' => 'required|string|max:100',
    ]);

    // Update course
    $course->update($validated);

    // Update or create sections
    $course->sections()->delete(); // Remove existing sections
    foreach ($request->sections as $sectionData) {
        $course->sections()->create([
            'name' => $sectionData['name'],
            'class_name' => $sectionData['class_name'],
            'status' => 'Active'
        ]);
    }

    return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
}

    public function show(Course $course)
    {
        $course->load('sections');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load('sections');
        return view('courses.edit', compact('course'));
    }

   

    public function destroy(Course $course)
    {
        $course->sections()->delete(); // ✅ delete related sections
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
