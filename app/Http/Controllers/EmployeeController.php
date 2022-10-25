<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function store(Request $request)
    {
        // print_r($_POST);
        // print_r($_FILES);
        $file = $request->file('avatar');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . "." . $extension;
        $file->storeAs('public/images', $filename);

        $empData = [
            'first_name' => $request->input('fname'),
            'last_name' => $request->input('lname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'post' => $request->input('post'),
            'avatar' => $filename
        ];

        $emp = Employee::create($empData);
        if ($emp) {
            return response()->json([
                'status' => true,
                'message' => 'Employee Added Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Employee not added'
            ]);
        }
    }

    public function allEmp()
    {
        $empData = Employee::all();
        $output = '';
        if ($empData->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Post</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($empData as $emp) {
                $output .= '<tr>
                            <td>' . $emp->emp_id . '</td>
                            <td><img src="storage/images/' . $emp->avatar . '" width="50" height="50" alt="avatar" 
                            class="img-thumbnail rounded-circle" /></td>
                            <td>' . $emp->first_name . ' ' . $emp->last_name . '</td>
                            <td>' . $emp->email . '</td>
                            <td>' . $emp->post . '</td>
                            <td>' . $emp->phone . '</td>
                            <td>
                                <a href="#" id="' . $emp->emp_id . '" class="text-success mx-1 editIcon"
                                data-bs-toggle="modal" data-bs-target="#editEmployeeModal">
                                <i class="bi-pencil-square h4"></i></a>
                                <a href="#" id="' . $emp->emp_id . '" class="text-danger mx-1 deleteIcon">
                                <i class="bi-trash h4"></i>
                                </a>
                            </td>
                        </tr>';
            }
            $output .= '</tbody>
            </table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No Records Found</h1>';
        }
    }

    public function editEmp(Request $request)
    {
        $emp_id = $request->emp_id;
        $empData = Employee::where('emp_id', $emp_id)->first();
        return response()->json($empData);
    }

    public function updateEmp(Request $request)
    {
        $filename = '';
        $empData = Employee::where('emp_id', $request->emp_id)->first();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('public/images', $filename);
            if ($empData->avatar) {
                Storage::delete('public/images/' . $empData->avatar);
            }
        } else {
            $filename = $request->emp_avatar;
        }
        $empDetails = [
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'post' => $request->post,
            'phone' => $request->phone,
            'avatar' => $filename
        ];

        Employee::where('emp_id', $empData->emp_id)->update($empDetails);
        return response()->json([
            'status' => true,
            'message' => 'Employee Updated Successfully'
        ]);
    }

    public function deleteEmp(Request $request)
    {
        $emp_id = $request->emp_id;
        $empData = Employee::where('emp_id', $emp_id)->first();
        if (Storage::delete('public/images/' . $empData->avatar)) {
            Employee::where('emp_id', $empData->emp_id)->delete();
        }
    }
}