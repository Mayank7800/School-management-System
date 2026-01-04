<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\StudentAdmission;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = Course::all();
        return view('attendance.create', compact('classes'));
    }

    public function getStudents($classId)
    {
        $students = StudentAdmission::where('class', $classId)->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        foreach ($request->student_ids as $studentId) {

            Attendance::create([
                'class_id' => $request->class_id,
                'student_id' => $studentId,
                'attendance_date' => now()->toDateString(),
                'status' => $request->status[$studentId],
                'remarks' => $request->remarks[$studentId] ?? null,
                'marked_by' => auth()->user()->name ?? 'Admin'
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance Saved Successfully');
    }

    public function attendanceIndex()
{
    $classes = Course::all();
    return view('attendance.index', compact('classes'));
}

public function getAttendanceByClass($classId)
{
    $attendance = Attendance::with('student')
        ->where('class_id', $classId)
        ->orderBy('attendance_date', 'desc')
        ->get();

    return response()->json($attendance);
}

}
