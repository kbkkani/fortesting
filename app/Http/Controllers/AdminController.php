<?php

namespace App\Http\Controllers;

use App\GroupCourse;
use App\Course;
use App\GroupMaster;
use App\Type;
use Dompdf\Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $layout = 'admin';

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateType(Request $request){
        $params = $request->all();
        try {
            foreach ($params['status'] as $key => $param) {
                Type::where('instance_id', $key)->update(['is_active' => $param]);
            }
        } catch (Exception $e) {
            return array("status" => "error");
        }

        return array("status" => "success");
    }

    public function createGroupCourses($id){
        try{
            if(!session()->get('group_session')){
                $groupData = GroupMaster::create(["title" => ""]);
                session()->put('group_session', $groupData->id);
                $groupDataId = $groupData->id;
            } else {
                $groupDataId = session()->get('group_session');
            }

            GroupCourse::create(["group_id" => $groupDataId, "course_id" => $id]);

            $course = new Course();
            $courseResults = $course->newQuery();
            $courseResults->where('id', $id );

            return array("status" => "success", "msg" => "Success", "results" => json_encode($courseResults->get()), "group_id" => $groupDataId);
        } catch (Exception $e) {
            return array("status" => "error" , "msg" => "Error Occurred");
        }

    }

    public function deleteGroupItem($id,$group_id){
        try{
            $groupCourse = new GroupCourse();
            $groupCourse->where("course_id",$id)
                ->orwhere("group_id",$group_id)
                ->get();

            $groupCourse->delete();
            return array("status" => "success" , "msg" => "Deleted");
        } catch (Exception $e) {
            return array("status" => "error" , "msg" => "Error Occurred");
        }
    }

    public function submitGroupForm(Request $request){
        try{
            $params = $request->all();
            if(session()->get('group_session')){
                $id = session()->get('group_session');
                $groupMaster = GroupMaster::find($id);
                $groupMaster->title = $params['title'];
                $groupMaster->save();
                session()->forget('group_session');
                return array("status" => "success" , "msg" => "Successfully Created");
            }

        } catch (Exception $e) {
            return array("status" => "error" , "msg" => "Error Occurred");
        }
    }


    public function allCorporateClients(){



    }


}
