<?php

namespace App\Http\Controllers;

use App\Api;
use App\Course;
use App\Courseinfo;
use App\Type;
use App\User;
use Auth;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use League\Flysystem\Exception;
use PhpSpec\Exception\Example\ErrorException;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::where('is_active', 1)->get();

        if(Auth::check()){
            $loggedIn = true;
            $user = Auth::user();
        } else {
            $loggedIn = false;
        }
        return view('home',['token' => csrf_token(),"types" => $type,"loggedIn" => $loggedIn]);
    }

    /*
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
    public function show(Request $request)
    {
        $data = $request->all();
        //$results = $this->courseDetails("courses?offset=0&displayLength=100");
        $articles = Cache::remember('articles', 22*60, function() {
            return $this->courseDetails("courses?offset=0&displayLength=100");
        });

        return $articles;
    }

    function searchDt(Request $paramsData){
        $data = array();
        $params = $paramsData->all();

        $courses = Cache::remember('articles', 22*60, function() use ($params) {

            if (isset($params) && $params['courseType'] != "") {
                $params['ID'] = $params['courseType'];
            }

            if (isset($params) && array_key_exists('venueName', $params) && $params['venueName'] != "") {
                $params['location'] = $params['venueName'];
            }

            if (isset($params) && array_key_exists('displayLength', $params) && $params['displayLength'] != "") {
                $params['displayLength'] = $params['displayLength'];
            } else {
                $params['displayLength'] = "100000";
            }

            if (isset($params) && $params['startDate'] != "") {
                //$params['startDate_min'] = $params['startDate'];
                $tmp = explode("/", $params['startDate']);
                $params['startDate_min'] = "$tmp[2]-$tmp[1]-$tmp[0]";
            } else {
                $params['startDate_min'] = date("Y-m-d");
            }


            if (isset($params) && $params['endDate'] != "") {
                $tmp2 = explode("/", $params['endDate']);
                $params['startDate_max'] = "$tmp2[2]-$tmp2[1]-$tmp2[0]";

            } else {
                $params['startDate_max'] = '2050-01-01';
            }
            $params['finishDate_min'] = date("Y-m-d");
            $params['finishDate_max'] = '2050-01-01';


            if (isset($params) && $params['instanceID'] != "") {
                $params['public'] = '0';
            } else {
                $params['public'] = '1';
                unset($params['instanceID']);
            }
            $params['hideFull'] = '1';
            $params['sortColumn'] = '8';
            $params['type'] = "w";

//            return json_decode($this->curl_conn("course/instance/search", $params));
//        });
            $courses = json_decode($this->curl_conn("course/instance/search", $params));
            if (sizeof($courses) == 0 && isset($params) && $params['instanceID'] != "") {

                foreach ($params as $key => $param) {
                    if ($param == "") {
                        unset($params[$key]);
                    }
                }
                $private = array();

                $private['type'] = "w";
                $private['instanceID'] = $params['instanceID'];
                $private['public'] = '0';

                if (isset($params) && $params['startDate'] != "") {
                    //$params['startDate_min'] = $params['startDate'];
                    $tmp = explode("/", $params['startDate']);
                    $private['startDate_min'] = "$tmp[2]-$tmp[1]-$tmp[0]";
                } else {
                    $private['startDate_min'] = date("Y-m-d");
                }


                if (isset($params) && $params['endDate'] != "") {
                    $tmp2 = explode("/", $params['endDate']);
                    $private['startDate_max'] = "$tmp2[2]-$tmp2[1]-$tmp2[0]";

                } else {
                    $private['startDate_max'] = '2050-01-01';
                }
                $private['finishDate_min'] = date("Y-m-d");
                $private['finishDate_max'] = '2050-01-01';

                $courses = json_decode($this->curl_conn("course/instance/search", $private));
            }

            if (count($courses) > 0) {

                if (isset($_SESSION['org'])) {
                    if ($_SESSION['org'] == "ymca") {
                        $params['name'] = "%(YMCA)%";
                        $params['public'] = '0';
                        $courses2 = json_decode($this->curl_conn("course/instance/search", $params));
                        if ($params['instanceID'] == "") {
                            $courses = array_merge($courses2, $courses);
                        }
                    }
                }

                if (isset($params['next10']) && $params['courseType'] == "") {
                    //$courses = array_slice($courses, 0, 10, true);
                }
                foreach ($courses as $courserow) {

                    $sort_startdate = $courserow->STARTDATE;

                    $sessions = $courserow->COMPLEXDATES;
                    $session_list = array();
                    foreach ($sessions as $key => $course_session) {
                        if ($key == 0) {
                            $startdate = '<a href="#" data-toggle="tooltip" title="" data-original-title="Instance ID: ' . $courserow->INSTANCEID . '">' . date("M d\, Y", strtotime($course_session->DATE)) . '</a>';
                        }
                        $session_list[] = date("D M d", strtotime($course_session->DATE)) . " " . date("h:ia", strtotime($course_session->STARTTIME)) . " to " . date("h:ia", strtotime($course_session->ENDTIME)) . "";
                    }

                    $session_tooltip = implode("<br/>", $session_list);

                    $session = '<button type="button" class="btn btn-glow btn-sm session_btn" data-toggle="tooltip"  data-placement="right"  title="" data-original-title="' . $session_tooltip . '" data-html="true" ><i class="icon-calendar"></i> View</button> <div class="session_detail" >' . $session_tooltip . '</div>';

                    switch ($courserow->TYPE) {
                        case "p":
                            $delivery_type = "Face-to-face only";
                            if (strpos($courserow->NAME, 'Blended') !== false) {
                                $delivery_type .= ' + Online training';
                            }
                            break;

                        case "w":
                            $instance_details = json_decode($this->curl_conn("course/instance/detail?instanceID=" . $courserow->INSTANCEID . "&type=w", array()));

                            if ($instance_details->LINKEDELEARNING != null) {
                                $delivery_type = "Face-to-face + Online training";
                            } else {
                                $delivery_type = "Face-to-face only";
                                if (strpos($courserow->NAME, 'Blended') !== false) {
                                    $delivery_type .= ' + Online training';
                                }
                            }

                            break;

                        case "el":
                            $delivery_type = 'Online only  <a href="#" class="info_sign" data-toggle="tooltip" title="" data-original-title="You will be required to complete online learning modules"><i class="icon-question-sign"></i> </a>';
                            break;

                        case "All":
                            $delivery_type = 'Online training + Face-to-face  <a href="#" class="info_sign" data-toggle="tooltip" title="" data-original-title="You will be required to complete online learning modules prior to face to face training"><i class="icon-question-sign"></i> </a>';
                            break;
                    }

                    if (array_key_exists('is_Loggedin', $params) && $params["is_Loggedin"]) {
                        //check category
                        $codecrs = $courserow->CODE;

                        switch ($codecrs) {
                            case "PLG":
                                $clink = "enrolment";
                                break;
                            case "PLG U":
                                $clink = "enrolment";
                                break;
                            case "BM":
                                $clink = "enrolment";
                                break;
                            case "BM ASSESS":
                                $clink = "enrolment";
                                break;
                            case "BM U":
                                $clink = "enrolment";
                                break;
                            case "CPR":
                                $clink = "enrolment";
                                break;
                            case "CPRBL":
                                $clink = "enrolment";
                                break;
                            case "CPR U":
                                $clink = "enrolment";
                                break;
                            case "FA BELS":
                                $clink = "enrolment";
                                break;
                            case "FA":
                                $clink = "enrolment";
                                break;
                            case "FA FLX":
                                $clink = "enrolment";
                                break;
                            case "PFABL":
                                $clink = "enrolment";
                                break;
                            case "FA U":
                                $clink = "enrolment";
                                break;
                            case "FA EDCARE":
                                $clink = "enrolment";
                                break;
                            case "AED":
                                $clink = "enrolment";
                                break;
                            case "AED U":
                                $clink = "enrolment";
                                break;
                            case "EAM":
                                $clink = "enrolment";
                                break;
                            case "EAM U":
                                $clink = "enrolment";
                                break;
                            case "ANA":
                                $clink = "enrolment";
                                break;
                            case "ANA U":
                                $clink = "enrolment";
                                break;
                            case "LSV - CSLSC":
                                $clink = "enrolment";
                                break;
                            case "LSV - CSLSC U":
                                $clink = "enrolment";
                                break;
                            case "WKS HR CPRU":
                                $clink = "enrolment";
                                break;
                            case "WKS HR U CPRU":
                                $clink = "enrolment";
                                break;
                            case "IWLSC":
                                $clink = "enrolment";
                                break;
                            case "CAAPSS":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTBM":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTBM U":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTPFA":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTPFA U":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTPLG":
                                $clink = "enrolmentminimum";
                                break;
                            case "INTPLG U":
                                $clink = "enrolmentminimum";
                                break;
                            case "WAWTR":
                                $clink = "enrolmentminimum";
                                break;
                            case "TECHWS":
                                $clink = "enrolmentminimum";
                                break;
                            case "C&I CPR":
                                $clink = "enrolmentminimum";
                                break;
                            case "FA4S":
                                $clink = "enrolmentminimum";
                                break;
                            case "WKS SM":
                                $clink = "enrolmentminimum";
                                break;
                            default:
                                $clink = "enrolment";
                        }

                        $launch_link = '<a href="' . $clink . '/course/' . $courserow->INSTANCEID . '" class="btn-glow primary " style="min-width:110px"><i class="icon-share-alt"></i> Enrol Now</a>  ';

                    } else {
                        $launch_link = '<a href="/api/courses/details/' . $courserow->INSTANCEID . '/' . $courserow->TYPE . '" style="min-width:110px" data-toggle="modal" data-target="#course-modal" class="btn-glow primary enrolnow_btn"><i class="icon-share-alt"></i> Enrol Now</a>';
                    }

                    if ($courserow->PUBLIC == "0") {
                        if (strpos($courserow->NAME, ("YMCA")) !== false) {
                            $price = '$' . $courserow->COST . '.00';
                        } else {
                            $price = "N/A";
                        }

                    } else {
                        $price = '$' . $courserow->COST . '.00';
                    }

                    //location
                    $location = $this->getLocation($courserow->INSTANCEID);
                    if ($location == "") {
                        $location_link = $courserow->LOCATION;
                    } else {
                        $location_link = '<span href="#" data-toggle="tooltip" title="" class="location_link" data-html="true" data-original-title="' . $location . '"> ' . $courserow->LOCATION . '</span>';
                    }

                    //end location
                    if ($courserow->PARTICIPANTVACANCY > 0) {
                        $data[] = array($startdate, $courserow->NAME, $session, $location_link, $delivery_type, $price, $courserow->PARTICIPANTVACANCY . ' of ' . $courserow->MAXPARTICIPANTS, $launch_link, $sort_startdate, $courserow->LOCATION);

                    }
                }
                return $data;
            }
        });
        return json_encode($courses);
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

    public function courseDetails($url){
        $results = json_decode($this->curl_conn($url, array()));
        $coursetypes = $results;
        $sorted_courses = array();

        foreach($coursetypes as $areaid => $coursetype){
            $result = json_decode($this->curl_conn("/course/detail?ID=$coursetype->ID&type=w", array()));
            if(!isset($result->COST)){
                continue;
            }
            $coursetype->COST = $result->COST;
            $coursetype->DESCRIPTION = $result->DESCRIPTION;

            if(strpos($coursetype->NAME, " Update")){
                $name = str_replace(" Update", "", $coursetype->NAME);
                $sorted_courses[$name]->ID = $coursetype->ID;
                $sorted_courses[$name]->COST  = $coursetype->COST;
            } else {
                if(!empty($coursetype->NAME)){
                    $sorted_courses[$coursetype->NAME] = $coursetype;
                }
            }
        }

        $valid_courses = array(
            "Anaphylaxis","Aquatic Technical Operations","Pool Bronze Medallion","CAA - Pool Safety Summit","Community Surf Life Saving Certificate","Defibrillation","Emergency Asthma Management","Pool Lifeguard","Provide Cardio Pulmonary Resuscitation","Provide First Aid","Provide First Aid Blended","Certificate IV in Training and Assessment (TAE40110)"
        );

        foreach($coursetypes as $areaid => $coursetype){
            if(in_array($coursetype->NAME, $valid_courses)) {
                $sorted_courses[$coursetype->NAME] = $coursetype;
            }

        }

        ksort($sorted_courses);

        return json_encode(array("status" => "success", "coursetypes" => $sorted_courses));
    }


    protected function curl_conn($url, $post_fields = array(), $axtoken = false){

        // Connection settings
//        AXL_API_Token = "D4E9A85F-C343-43A4-9586409C185B6ADF"
        $api_token    = "D4E9A85F-C343-43A4-9586409C185B6ADF";   // AXL_API_Token

        if(isset($axtoken) && $axtoken != ""){
            $ws_token = $axtoken;
            $token_type = "axtoken";
        } else {
            $token_type = "wstoken";
            $ws_token = "731D225A-2150-46FF-B7592205B2B79574";  // AXL_WS_Token
        }
        $api_url      = "https://admin.axcelerate.com.au/api/"; // AXL_API_URL;


        $options = array(
            CURLOPT_HTTPHEADER => array("apitoken: $api_token", "$token_type: $ws_token"),
            CURLOPT_HEADER => false,
            CURLOPT_URL => $api_url.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
        );

        // Check is POST Fields set
        $fields_string = "";
        if(count($post_fields) > 0) {

            $fields_string = "";
            foreach($post_fields as $key=>$value) {
                if($value != "") {
                    $fields_string .= $key.'='.$value.'&';
                }

            }
            rtrim($fields_string, '&');

            // CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token", "Accept: */*", "Content-Type: application/json;charset=utf-8", "Accept-Language: en-US,en;q=0.8"),
            $options =	array(
                CURLOPT_HTTPHEADER => array("apitoken: $api_token", "wstoken: $ws_token"),
                CURLOPT_HEADER =>  false,
                CURLOPT_URL => $api_url.$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => '',
                CURLOPT_POST => count($post_fields),
                CURLOPT_POSTFIELDS => $fields_string
            );

        }

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $response = curl_exec($feed);

        curl_close($feed);

        try {
            return $response;
        } catch (Exception $e){
            $date = date('d/m/Y H:i:s');
            $response = json_decode($response);
            error_log("date: $date, message: $response->ErrorMessage, method: $url \r\n", 3, ERROR_LOG_FILE);
            return json_encode(array("error" => "An issue has occurred, please try again. $response->ErrorMessage"));
        }

    }

    function getLocation($instanceID){
        //location

        $instance_details = json_decode($this->curl_conn("course/instance/detail?instanceID=".$instanceID."&type=w", array()));
        $venue_contactid = $instance_details->VENUECONTACTID;
        if($venue_contactid != ""){
            $venue_details = json_decode($this->curl_conn("venues/?CONTACTID=".$venue_contactid, array()));
            if($venue_details != array()){
                $venue_detail = $venue_details[0];
                $location = $venue_detail->NAME."<br/>".$venue_detail->SADDRESS1."<br/>";
                $add2 = $venue_detail->SADDRESS2;
                if($add2 != null || $add2 !=""){
                    $location .= $add2;
                }
                $location .= $venue_detail->SCITY.", ".$venue_detail->SSTATE." ".$venue_detail->SPOSTCODE;

            }else{
                $location ="";
            }


        }else{
            $location = "";
        }
        //end location

        return $location;
    }

    public function getAllCourses(Request $params){
        $data = $params->all();
        $courses = Course::all();

        return json_encode($courses);
    }

    public function searchCourses(Request $request){
        $course = new Course();
        $params = $request->all();



        $courseResults = $course->newQuery();
        if ($request->has('instanceID')) {
            $courseResults->where('instance_id', $request->input("instanceID"));
        }
        if ($request->has('startDate')) {
            $courseResults->where('start_date', '>',$request->input("startDate"));
        }
        if ($request->has('endDate')) {
            $courseResults->where('start_date', '<',$request->input("endDate"));
        }
        if ($request->has('courseType')) {
            $courseResults->where('type_id', $request->input("courseType"));
        }

        return json_encode($courseResults->get());
    }

    public function getAllCourseInfo(){
        $courseInfo = Courseinfo::all(array("name","cost","info_id","short_description","update_cost","type_id"));

        return json_encode($courseInfo);
    }
}
