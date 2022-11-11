<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function Index()
    {
        return view('student.index');
    }

    public function StudentAdd(Request $request)
    {
        $data = new Student;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('upload/student'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Student added successfully'
        ]);
    }
}