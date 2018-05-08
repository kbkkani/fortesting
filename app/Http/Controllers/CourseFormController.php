<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\CourseForm;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Validator;

class CourseFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('course-form.index', ['user' => Auth::user()]);
    }

    public function getUsers()
    {
        $data=Course::all();


        return Datatables::of($data)
            ->addColumn('type-fl', function ($data) {
                if (isset($data->courseType->type)) {
                    if ($data->courseType->type == 1) {
                        return '<span class="label label-primary">Short form</span>';
                    } else {
                        return '<span class="label label-success">Long Form</span>';
                    }
                } else {
                    return '<span class="label label-default">N/A</span>';
                }
            })
            ->addColumn('form-s', function ($data) {
                $o1 = (isset($data->courseType->type) && $data->courseType->type == 1) ? 'selected' : '';
                $o2 = (isset($data->courseType->type) && $data->courseType->type == 2) ? 'selected' : '';

                $op3 = isset($data->courseType->type) ? '' : '<option>Select</option>';
                return '<select class="form-control slf" u-id="' . $data->id . '" >
                        ' . $op3 . '
                        <option value="1" ' . $o1 . ' >Short form</option>
                        <option value="2" ' . $o2 . '>Long form</option></select>';
            })
            ->make(true);
    }

    public function saveUserType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'type' => 'required|in:1,2',
        ]);

        if ($validator->passes()) {
            if (CourseForm::updateOrCreate(['course_id' => $request->only('course_id')], $request->all())) {
                return response()->json(['success' => 'Added new records.']);
            }
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
