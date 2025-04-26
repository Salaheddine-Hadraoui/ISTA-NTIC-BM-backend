<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    public function modules()
    {
        $modules = Module::all();
        return response()->json([
            'modules' => $modules
        ], 200);
    }
    public function index()
    {
        $courses = Course::with('module')->get();
        return response()->json([
            'courses' => $courses
        ], 200);
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|min:8',
                'course_pdf' => 'required|file|mimes:pdf|max:10240',
                'module_id' => 'required|exists:modules,id'
            ]);
        } catch (ValidationException $err) {
            return response()->json([
                'errors' => $err->errors(),
                'succes' => false
            ], 200);
        }

        if ($request->hasFile('course_pdf')) {
            $path = $request->file('course_pdf')->store('Courses', 'public');
            $data['course_pdf'] = $path;
        }
        $course = Course::create($data);
        $course->refresh();

        return response()->json([
            'course' => $course,
            'succes' => true
        ], 201);
    }


    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|min:8',
                'course_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'module_id' => 'required|exists:modules,id'
            ]);
        } catch (ValidationException $err) {
            return response()->json([
                'errors' => $err->errors(),
                'success' => false
            ], 200);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found.'
            ], 404);
        }

    
        if ($request->hasFile('course_pdf')) {
           
            if ($course->course_pdf) {
              
                Storage::disk('public')->delete($course->course_pdf);
            }

          
            $path = $request->file('course_pdf')->store('Courses', 'public');
            $data['course_pdf'] = $path;
        }

       
        $course->update($data);

        return response()->json([
            'course' => $course,
            'success' => true
        ], 200);
    }


    public function destroy($id)
    {

        $cours = Course::find($id);

        if (!$cours) {
            return response()->json([
                'success' => false,
                'message' => 'Cours introuvable.'
            ], 404);
        }

        $cours->delete();

        return response()->json([
            'success' => true,
            'cours' => $cours,
            'message' => 'Cours supprimé avec succès.'
        ], 200);
    }
}
