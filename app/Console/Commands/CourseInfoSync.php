<?php

namespace App\Console\Commands;

use App\Course;
use App\Courseinfo;
use App\Type;
use Illuminate\Console\Command;

class CourseInfoSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courseinfo:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Course Info Sync';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $params = array();
        $today = date("d/m/Y");
        $next_mth = date('d/m/Y', strtotime("+60 days"));
        $params['startDate'] = $today;
        $params['endDate'] = $next_mth;
        $params['next10'] = true;
        $params['displayLength'] = "100000";

        Course::truncate();

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


//        if (isset($params) && $params['instanceID'] != "") {
//            $params['public'] = '0';
//        } else {
//            $params['public'] = '1';
//            unset($params['instanceID']);
//        }
//        $params['hideFull'] = '1';
//        $params['sortColumn'] = '8';
//        $params['type'] = "w";

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

            foreach ($courses as $courserow) {

                $sort_startdate = $courserow->STARTDATE;

                $sessions = $courserow->COMPLEXDATES;
                $session_list = array();
                foreach ($sessions as $key => $course_session) {
                    if ($key == 0) {
                        $startdate = date("Y-m-d", strtotime($course_session->DATE));
                    }
                    $session_list[] = date("D M d", strtotime($course_session->DATE)) . " " . date("h:ia", strtotime($course_session->STARTTIME)) . " to " . date("h:ia", strtotime($course_session->ENDTIME)) . "";
                }

                $session_tooltip = implode("<br/>", $session_list);

                $session = '<button type="button" class="btn btn-glow btn-sm session_btn" data-toggle="tooltip"  data-placement="right"  title="" data-original-title="' . $session_tooltip . '" data-html="true" ><i class="icon-calendar"></i> View</button> <div>' . $session_tooltip . '</div>';

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

                $launch_link = '<a href="/api/courses/details/' . $courserow->INSTANCEID . '/' . $courserow->TYPE . '" style="min-width:110px" data-toggle="modal" data-target="#course-modal" class="btn-glow primary enrolnow_btn"><i class="icon-share-alt"></i> Enrol Now</a>';

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
                    $courseData = new Course();
                    $courseData->instance_id = $courserow->INSTANCEID;
                    $courseData->start_date = $startdate;
                    $courseData->type = $courserow->NAME;
                    $courseData->timing = $session;
                    $courseData->location = $location_link;
                    $courseData->delivery_mothod = $delivery_type;
                    $courseData->price = $price;
                    $courseData->enrol_now = $launch_link;
                    $courseData->space_available = $courserow->PARTICIPANTVACANCY . ' of ' . $courserow->MAXPARTICIPANTS;
                    $courseData->save();
                }

            }
            $this->info('The course details were saved successfully!');
        }

        $coursesType = json_decode($this->curl_conn("courses?offset=0&displayLength=100&isActive=true", array()));

        if(count($coursesType) > 0){
            Type::truncate();

            foreach ($coursesType as $types) {
                $type = new Type();
                $type->type = $types->NAME;
                $type->code = $types->CODE;
                $type->delivery = $types->DELIVERY;
                $type->instance_id = $types->ID;
                $type->is_active = $types->ISACTIVE;
                $type->short_desc = $types->SHORTDESCRIPTION;
                $type->save();
                Course::where('type', $types->NAME)->update(['type_id' => $types->ID]);

        }
            $this->info('The course types were saved successfully!');
        }
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

    protected function getLocation($instanceID){
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
}
