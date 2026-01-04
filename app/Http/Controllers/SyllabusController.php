<?php
// app/Http/Controllers/SyllabusController.php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Syllabus::with(['class', 'section', 'createdBy']);

        // Filter by class
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by section
        if ($request->has('section_id') && $request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        // Filter by academic year
        if ($request->has('academic_year') && $request->academic_year) {
            $query->where('academic_year', $request->academic_year);
        }

        $syllabus = $query->latest()->paginate(20);
        $classes = Course::all();
        $sections = Section::all();

        // Get unique academic years
        $academicYears = Syllabus::select('academic_year')->distinct()->pluck('academic_year');

        return view('syllabus.index', compact('syllabus', 'classes', 'sections', 'academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Course::all();
         $sections = Section::all();
        $currentYear = date('Y');
        $academicYears = [
            $currentYear - 1 . '-' . $currentYear,
            $currentYear . '-' . ($currentYear + 1),
            $currentYear + 1 . '-' . ($currentYear + 2)
        ];

        return view('syllabus.create', compact('classes', 'academicYears','sections'));
    }

    /**
     * Get sections based on class
     */
    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)->get();
        return response()->json($sections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:courses,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'syllabus_file' => 'required|file|mimes:pdf,doc,docx,txt,ppt,pptx,xls,xlsx|max:10240', // 10MB
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('syllabus_file')) {
                $file = $request->file('syllabus_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('syllabus', $fileName, 'public');
                
                $syllabus = Syllabus::create([
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => $filePath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'academic_year' => $request->academic_year,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'created_by' => Auth::id(),
                ]);

                return redirect()->route('syllabus.index')->with('success', 'Syllabus uploaded successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading syllabus: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Syllabus $syllabus)
    {
        return view('syllabus.show', compact('syllabus'));
    }

    /**
     * Download the syllabus file.
     */
    public function download(Syllabus $syllabus)
    {
        if (Storage::disk('public')->exists($syllabus->file_path)) {
            return Storage::disk('public')->download($syllabus->file_path, $syllabus->file_name);
        }

        return redirect()->back()->with('error', 'File not found!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $classes = Course::all();
        $syllabus= Syllabus::findorfail($id);
        $sections = Section::where('class_id', $syllabus->class_id)->get();
        $currentYear = date('Y');
        $academicYears = [
            $currentYear - 1 . '-' . $currentYear,
            $currentYear . '-' . ($currentYear + 1),
            $currentYear + 1 . '-' . ($currentYear + 2)
        ];

        return view('syllabus.edit', compact('syllabus', 'classes', 'sections', 'academicYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id )
    {  
        $syllabus= Syllabus::findorfail($id);
        $request->validate([
            'class_id' => 'required|exists:courses,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'syllabus_file' => 'nullable|file|mimes:pdf,doc,docx,txt,ppt,pptx,xls,xlsx|max:10240',
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        try {
            $data = [
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'title' => $request->title,
                'description' => $request->description,
                'academic_year' => $request->academic_year,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active ?? true,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('syllabus_file')) {
                // Delete old file
                if (Storage::disk('public')->exists($syllabus->file_path)) {
                    Storage::disk('public')->delete($syllabus->file_path);
                }

                $file = $request->file('syllabus_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('syllabus', $fileName, 'public');
                
                $data['file_path'] = $filePath;
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_size'] = $file->getSize();
                $data['file_type'] = $file->getClientOriginalExtension();
            }

            $syllabus->update($data);

            return redirect()->route('syllabus.index', compact('syllabus'))->with('success', 'Syllabus updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating syllabus: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Syllabus $syllabus)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($syllabus->file_path)) {
                Storage::disk('public')->delete($syllabus->file_path);
            }

            $syllabus->delete();

            return redirect()->route('syllabus.index')->with('success', 'Syllabus deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting syllabus: ' . $e->getMessage());
        }
    }

    /**
     * View syllabus file in browser
     */
    public function view(Syllabus $syllabus)
    {
        if (Storage::disk('public')->exists($syllabus->file_path)) {
            $filePath = Storage::disk('public')->path($syllabus->file_path);
            $fileType = Storage::disk('public')->mimeType($syllabus->file_path);
            
            return response()->file($filePath, [
                'Content-Type' => $fileType,
                'Content-Disposition' => 'inline; filename="' . $syllabus->file_name . '"'
            ]);
        }

        return redirect()->back()->with('error', 'File not found!');
    }


}