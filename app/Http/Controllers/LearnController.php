<?php

namespace App\Http\Controllers;

use App\Code;
use App\Course;
use App\Courseinfo;
use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Type;
use App\CodeLog;
use PDF;

class LearnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $layout = 'mylearning';
    protected $userSession;

    public function __construct()
    {
        if(Session::get('user_details')){
            $this->userSession = Session::get('user_details');
        } else {
            $this->userSession = "";
        }
    }

    public function index()
    {
        return $this->userSession;
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

    /**
     * To do List
     */

    public function createTodo(){

    }

    public function courses($instanceId) {
        $user = Auth::user();
        $user_details = Session::get('user_details');
        $countries = Common::countries();
        $languages = Common::languages();
        $disabilityType = Common::disabilityType();
        $schools = Common::schools();
        $education = Common::education();
        $indigenous = array(1=>"Yes, Aboriginal",2=>"Yes, Torres Strait Islander",3=>"No",4=>"I would prefer not to disclose this information");
        return view('wizard',["user" => $user,"instanceID" => $instanceId,"user_details" => $user_details,
            "indigenous" => $indigenous,"countries" => $countries,"languages" => $languages,
            "disabilityType" => $disabilityType, "schools" => $schools, "educations" => $education]);
    }

    public function enrolInstanceDetails(Request $params){
        $params = $params->all();
        if (array_key_exists("endDate",$params) && $params['endDate'] != "") {
            $tmp2 = explode("/", $params['endDate']);
            $params['startDate_max'] = "$tmp2[2]-$tmp2[1]-$tmp2[0]";

        } else {
            $params['startDate_max'] = '2050-01-01';
        }
        $params['finishDate_min'] = date("Y-m-d");
        $params['finishDate_max'] = '2050-01-01';
        $params['type'] = "w";
        $courses = json_decode(Common::curl_conn("course/instance/search", $params));
        $courserow = (count($courses) > 0)?$courses[0]:"";
        if($courserow == "") {
            $params["public"]= 0;
            foreach($params as $key => $param) {
                if($param == "") {
                    unset($params[$key]);
                }
            }
            $private = array();
            $private['instanceID'] = $params['instanceID'];
            $private['public'] = '0';

            if(array_key_exists("startDate",$params) && $params['startDate'] != ""){
                //$params['startDate_min'] = $params['startDate'];
                $tmp  = explode("/",$params['startDate']);
                $private['startDate_min'] = "$tmp[2]-$tmp[1]-$tmp[0]";
            } else {
                $private['startDate_min'] = date("Y-m-d");
            }


            if (array_key_exists("endDate",$params) && $params['endDate'] != "") {
                $tmp2 = explode("/", $params['endDate']);
                $private['startDate_max'] = "$tmp2[2]-$tmp2[1]-$tmp2[0]";

            } else {
                $private['startDate_max'] = '2050-01-01';
            }
            $private['finishDate_min'] = date("Y-m-d");
            $private['finishDate_max'] = '2050-01-01';


            $courses = json_decode(Common::curl_conn("course/instance/search", $private));
            $courserow = (count($courses) >0)?$courses[0]:"";
        }

        if(!empty($courserow) && $courserow->PARTICIPANTVACANCY <= 0){
            $response = array("status" => "error", "message" => "The following course no longer has available spots for enrolment. Please use the Contact Us link on the top right of the screen to reach us", "response" => $courserow);
        } else {
            $user_details = Session::get("user_details");
            $user = Common::curl_conn("/contact/enrolments/".$user_details['CONTACTID']."?type=w", array());
            $enrolments = json_decode($user);
            $user_instanceID = array();
            foreach($enrolments as $enrolment){
                $user_instanceID[] = $enrolment->INSTANCEID;
            }

            if(in_array($params['instanceID'], $user_instanceID)){
                $response = array("status" => "error", "message" => "You are already enrolled into this course. Please use the Contact Us link on the top right of the screen to reach us");
            } else {

                //location
                $course_types = json_decode(Common::curl_conn("courses?displayLength=100", array()));
                foreach($course_types as $coursetype){
                    if($coursetype->ID == $courserow->ID){
                        $short_description = $coursetype->SHORTDESCRIPTION;
                    }
                }
                $location=$this->getLocation($params['instanceID']);
                if($location==""){
                    $location=$courserow->LOCATION;
                }
                //end location

                $coursedetails = json_decode(Common::curl_conn("course/detail?ID=$courserow->ID&type=$courserow->TYPE", array()));
                $originalDate = $courserow->STARTDATE;
                $start_date = date("d/m/Y", strtotime($originalDate));
                $pre_req = $this->get_string_between($coursedetails->OUTLINE, "*#", "*#");


                $response = array("status" => "success", "details" => $courserow,"location"=>$location,"name"=>$coursedetails->NAME,"pre_req" => $pre_req, "start_date"=>$start_date, "description" => $short_description);
            }
        }
        return json_encode($response);
    }

    public function getLocation($instanceID){
        //location

        $instance_details = json_decode(Common::curl_conn("course/instance/detail?instanceID=".$instanceID."&type=w", array()));
        $venue_contactid = $instance_details->VENUECONTACTID;
        if($venue_contactid != ""){
            $venue_details = json_decode(Common::curl_conn("venues/?CONTACTID=".$venue_contactid, array()));
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

    public function locations($params, $axtoken){
        $results = json_decode(Common::curl_conn("venues", $params, $axtoken));
        $locations = array();
        foreach($results as $location) {
            $locations[] = array(
                "name" => $location->NAME,
                "address" => $location->SADDRESS1,
                "city" => $location->SCITY,
                "state"	=> $location->SSTATE,
                "postcode" => $location->SPOSTCODE
            );
        }
        return json_encode(array("status" => "success", "locations" => $locations, "axtoken" => $axtoken));
    }

    public function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

    public function createEnrol(Request $request){

        $params = $request->all();
        //check age below 18
        if ($params['emstat'] == "Y"){
            $connection = Database::Connect();
            $check_codea = $connection->prepare("INSERT INTO emergencycontact(Emfname,Emsname,Emrelation,	Emcontno,Emsig,Eminst,EmContact) VALUES (?, ?, ?,?,?,?,?)");
            $check_codea->execute(array($params['fcn'],$params['fsn'],$params['EmergencyContactRelation'],$params['EmergencyContactPhone'],$params['outputa'],$params['instanceID'],$params['contactID']));
        }

        // Update contact

        $user = Common::curl_conn("/contact/enrolments/".$params['contactID']."?type=w", array());
        $enrolments = json_decode($user);

        $params['title'] = str_replace(" ", '', $params['title']);
        unset($params['work']);
        Common::curl_conn_put("contact/$params[contactID]", $params);
        $user_instanceID = array();
        foreach($enrolments as $enrolment){
            $user_instanceID[] = $enrolment->INSTANCEID;
        }

        if(in_array($params['instanceID'], $user_instanceID)){
            $response = array("status" => "error", "message" => "You are already enrolled into this course. Please use the Contact Us link on the top right of the screen to reach us");

        }
        // Course checks
        //$instance_params = array("instanceID" => $params['instanceID'], "type" => $params['type']);
        $instance_details = json_decode(Common::curl_conn("course/instance/detail?instanceID=".$params['instanceID']."&type=w", array()));
        //$response = array("status" => "error", "instance_details"=>json_encode($instance_details));

        if($instance_details->PARTICIPANTS >= $instance_details->MAXPARTICIPANTS){
            return json_encode(array("status" => "error", "message" => "This course has exceeded it's maximum spots. Please use the Contact Us link on the top right of the screen to reach us","instance_details"=>json_encode($instance_details)));
            exit; die();
        }

        // If course is public
        if($params['public'] != "false" || strpos($instance_details->NAME,'(YMCA)') !== false  || strpos($instance_details->NAME,'YMCA') !== false ){

            // Check payment type
            if($params['payment_option'] == "techone"){
                $code_params = array();
                $code_params['contactID'] = $params['contactID'];
                $code_params['instanceID'] = $params['instanceID'];
                $code_params['couponcode'] = $params['couponcode'];
                $check_code = $this->validateCode($code_params);

                if($check_code->status == "error"){
                    $response = array("status" => "error", "message" => $check_code->message);
                } else {
                    // Add to code log
                    $code_log = new CodeLog();
                    $code_log->couponcode = $code_params['couponcode'];
                    $code_log->customer_ref = $check_code->code_text;
                    $code_log->contact_fname = $params['givenName'];
                    $code_log->contact_lname = $params['surname'];
                    $code_log->enrolmentid = '2323232';
                    $code_log->instanceid = $params['instanceID'];
                    $code_log->contactid = $params['contactID'];
                    $code_log->expires = $check_code->expires;
                    $code_log->price = $params['paymentAmount'];

                    $invoiceid = $code_log->id;

                    $new_value = $check_code->max_value + 1;

                    Code::where('code', $code_params['couponcode'])->update(['max_value' => $new_value]);

                    $enrol_params =
                        array(
                            "contactID" => $params['contactID'],
                            "instanceID" => $params['instanceID'],
                            "type" => $params['type'],
                            "payerID" => $check_code->payerID,
                            /* "invoiceID" =>  $code_params['couponcode'], */
                            "PONumber" =>  $code_params['couponcode'],
                            "lockInvoiceItems" => '0',
                            "generateInvoice" => '0'
                        );
                    $enrol_list=array();
                    $enrol_list[]= $enrol_params;
                }
            } else if ($params['payment_option'] == "creditcard"){
                $payment = Common::curl_conn("payment", $params);
                $payments = json_decode($payment);

                if(array_key_exists("STATUS",$payments) && $payments->STATUS != true){
                    $response = array("status" => "error", "message" => "A payment error occurred: $payments->MESSAGES  $payments->DETAILS" ,"payments"=>$payments);
                } else {

                    $enrol_params = array(
                        "contactID" => $params['contactID'],
                        "instanceID" => $params['instanceID'],
                        "type" => $params['type'],
                        "payerID" => $params['contactID'],
                        "invoiceID" => $payments->INVOICEID,
                        "PONumber" => $payments->INVOICENO,
                        "generateInvoice" => true
                    );

                    $enrol_list=array();
                    $enrol_list[]= $enrol_params;
                }
            }

        } else {

            $enrol_params = array(
                "contactID" => $params['contactID'],
                "instanceID" => $params['instanceID'],
                "type" => $params['type'],
                "generateInvoice" => '0'
            );

            $enrol_list=array();
            $enrol_list[]= $enrol_params;

        }

        foreach($enrol_list as $instance){
            $enrolment = Common::curl_conn("course/enrol", $instance);
            $enrolments = json_decode($enrolment);

            if(array_key_exists("ERROR",$enrolments) && $enrolments->ERROR == true){
                $response = array("status" => "error", "message" => "An enrolment error occurred: $enrolments->MESSAGES","enrol_list"=>$enrol_list);
            } else {
                if(isset($invoiceid)){
                    CodeLog::where('id', $invoiceid)->update(['invoiceid' => $enrolments->INVOICEID]);
                }
                $response = array("status" => "success", "message" => "Enrolment completed successfully, please go to my training by clicking <a href='/mylearning#1current_reg'>here</a>","result"=> $instance);
            }
        }

        return json_encode($response);
    }

    function validateCode($params){

        $code = Code::where('code',$params['couponcode']);

        // check if code exists
        if($code) {
            // check if expired code
            if(strtotime($code->expiry_date) < time()){
                $response = array("status" => "error", "message" => "Code has expired");
            } else {

                if($code->max_enrolments == $code->max_value && $code->max_value > 0) {
                    $response = array("status" => "error", "message" => "Maximum spots reached for this code");
                } else {
                    $response = array("status" => "success", "message" => "code valid", "payerID" => $code->payerid, "expires" => $code->expiry_date, "max_value" => $code->max_value, "code_text" => $code->code_text);
                    // Is contactID  and instanceID specific?
                    if($code->contactid != NULL && $code->instanceid != NULL){
                        if($code->contactid == $params['contactID'] && $code->instanceid == $params['instanceID']){
                            $response = array("status" => "success", "message" => "code valid", "payerID" => $code->payerid, "expires" => $code->expiry_date, "max_value" => $code->max_value, "code_text" => $code->code_text);
                        } else {
                            $response = array("status" => "error", "message" => "Entered code is not valid for this user");
                        }
                    }
                }
            }
            // check if maximum enrolments reached
        } else {
            $response = array("status" => "error", "message" => "The code you have entered is invalid");
        }
        return json_decode(json_encode($response));
    }

    public function userEnrolment($contactId)
    {
        $user = Common::curl_conn("/contact/enrolments/" . $contactId . "?type=w&displayLength=100", array());
        $enrolments = json_decode($user);
        $eLearning = array();
        //if they have > 0 enrolments, check any e-learning now. We will assign this later to save API calls
        if (count($enrolments) > 0) {
            $eLearning = json_decode(Common::curl_conn('/contact/enrolments/' . $contactId . '?type=el'));
        }

        if(count($enrolments) > 0){
            foreach ($enrolments as $filter_enrolment) {
                $filter_enrolments[$filter_enrolment->ENROLID] = $filter_enrolment;
            }
            $enrolments = $filter_enrolments;
            $user_enrolments = '';
            $completed_enrolments = '<div class="row-fluid"><table class="table table-hover">        <thead>
            <tr>
                <th class="span3">
                    Course
                </th>
                <th class="span2">
                	<span class="line"></span>
                    Date
                </th>
                <th class="span4">
                    <span class="line"></span>
                    Location
                </th>
                <th class="span2">
                    <span class="line"></span>
                    Result
                </th>
               <th class="span1">
                    <span class="line"></span>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>';
            //echo "<pre>"; print_r($enrolments); echo "</pre>"; exit; die();

            foreach ($enrolments as $enrolment) {
                //$instance = json_decode($this->curl_conn("course/detail?ID=$enrolment->ID&type=$enrolment->TYPE", array()));
                //$session_date = date("D M d\ h:i A Y ", strtotime($instance->STARTDATE));
                $session_times = "";
                foreach ($enrolment->COMPLEXDATES as $session) {
                    $session_day = date("d/m/Y", strtotime($session->DATE));
                    $session_start = date("h:i A", strtotime($session->STARTTIME));
                    $session_end = date("h:i A ", strtotime($session->ENDTIME));
                    $session_times .= "$session_day at $session_start to $session_end <br/>";
                }
                if ($enrolment->STATUS == "Completed") {
                    $instance_details = json_decode(
                        Common::curl_conn("course/instance/detail?instanceID=" . $enrolment->INSTANCEID . "&type=w", array())
                    );
                    if ($instance_details->LINKEDCLASSID == null) {
                        $data_type = "statusID";
                        $data_id = $enrolment->ENROLID;
                    } else {
                        $data_type = "enrolID";
                        $linked_enrolments = json_decode(
                            Common::curl_conn("/contact/enrolments/" . $contactId . "?type=p&displayLength=100", array())
                        );
                        //echo "<pre>"; print_r($linked_enrolments); echo "</pre>"; exit; die();
                        foreach ($linked_enrolments as $linked_enrolment) {
                            if ($linked_enrolment->INSTANCEID == $instance_details->LINKEDCLASSID) {
                                //$data_id = $enrolment->ENROLID;
                                $data_id = $linked_enrolment->ENROLID;
                            }
                        }
                    }
                    $print = json_encode($enrolment);
                    $completed_enrolments .= '

            	<tr class="even">
                    <td>
                       ' . $enrolment->NAME . ' ' . $enrolment->INSTANCEID . '
                        
                    </td>
                    <td>
                    	' . $session_times . '
                    </td>
                    <td>
                        ' . $enrolment->LOCATION . '	
                    </td>
                    <td>
                        <span class="label label-success"><i class="icon-ok"></i> ' . $enrolment->STATUS . '</span>
                    </td>
                    <td>
                    	<div class="btn-group settings">
                    		<a href="/mylearning/certificate/' . $data_id . '" data-id="' . $data_id . '" data-type="' . $data_type . '" class="generate_cert btn btn-xs btn-glow success"><i class="icon-cloud-download"></i> Download certificate </a>
						</div>
						
                    </td>
                </tr>
            	
      				';
                } else {
                    if ($enrolment->STATUS == "Booked" || $enrolment->STATUS == "Moved" || $enrolment->STATUS == "Paid") {
                        $instance_details = json_decode(
                            Common::curl_conn(
                                "course/instance/detail?instanceID=" . $enrolment->INSTANCEID . "&type=w",
                                array()
                            )
                        );
                        $venue_contactid = $instance_details->VENUECONTACTID;
                        if ($venue_contactid != "") {
                            $venue_details = json_decode(
                                Common::curl_conn("venues/?CONTACTID=" . $venue_contactid, array())
                            );
                            if ($venue_details != array()) {
                                $venue_detail = $venue_details[0];
                                $location = $venue_detail->NAME . "<br/>" . $venue_detail->SADDRESS1 . "<br/>";
                                $add2 = $venue_detail->SADDRESS2;
                                if ($add2 != null || $add2 != "") {
                                    $location .= $add2;
                                }
                                $location .= $venue_detail->SCITY . ", " . $venue_detail->SSTATE . " " . $venue_detail->SPOSTCODE;
                            } else {
                                $location = $enrolment->LOCATION;
                            }
                        } else {
                            $location = $enrolment->LOCATION;
                        }
                        $course_types = json_decode(Common::curl_conn("courses?displayLength=100", array()));
                        $short_description = "";
                        foreach ($course_types as $coursetype) {
                            if ($coursetype->ID == $enrolment->ID) {
                                $short_description = $coursetype->SHORTDESCRIPTION . '<br/><br/>';
                            }
                        }
                        // Checks if Blended
                        if ($instance_details->LINKEDELEARNING != null) {
                            $instanceResources = array();
                            $eLearningCompleted = true;
                            //loop through our already loaded eLearning and match it up
                            foreach ($instance_details->LINKEDELEARNING as $linkedLearning) {
                                foreach ($eLearning as $eLearningModule) {
                                    if ($linkedLearning->INSTANCEID == $eLearningModule->INSTANCEID) {
                                        $instanceResources[] = array(
                                            'name' => $eLearningModule->NAME,
                                            'url' => $eLearningModule->LAUNCHURL,
                                            'status' => $eLearningModule->STATUS,
                                            'newWindow' => $eLearningModule->ACTIVITYTYPE !== 'SCORMEngine'
                                        );
                                        if (!in_array($eLearningModule->STATUS, array('Completed', 'Passed', 'Failed'))) $eLearningCompleted = false;
                                    }
                                }
                            }
                            $user_enrolments .= '<div class="pracBox span6">   
					  <h4>' . $enrolment->NAME . ': ' . $enrolment->INSTANCEID . '</h4>
					    <strong> Delivery type:</strong> ' . $enrolment->DELIVERY . ' <strong>Status:</strong> ' . $enrolment->STATUS . '<br/><br/>
					
						<div class="tabbable"> 
					  <ul class="nav nav-tabs" id="step-list">
					    
					<li class="active"><a href="#tab1-' . $enrolment->INSTANCEID . '" data-toggle="tab"><i class="icon-laptop"></i> <strong>Step 1: ' . ($eLearningCompleted ? 'Completed' : 'Complete online training') .'</strong></a></li>
					<li class=""><a href="#tab2-' . $enrolment->INSTANCEID . '" data-toggle="tab"><i class="icon-group"></i>  <strong>Step 2: Attend face-to-face training</strong></a></li>
					  </ul>
					  <div class="tab-content">
					    <div class="tab-pane active" id="tab1-' . $enrolment->INSTANCEID . '">
							    	<div class="alert alert-info">
								                    <i class="icon-info-sign "></i>
								                    <strong>Important information regarding your training</strong><br>
								                    This course requires you to complete online modules prior attending the face-to-face training.<br/><br/>
								                    ';

                            $user_enrolments .= '</div>';
                            //insert eLearning here
                            foreach($instanceResources as $instanceResource) {
                                $user_enrolments .= '<div class="elearning">';
                                $user_enrolments .= $instanceResource['name'];
                                if (!in_array($instanceResource['status'], array('Completed', 'Passed', 'Failed'))) {
                                    $user_enrolments .= '<a target="' . ($instanceResource['newWindow'] ? '_blank' : '_self'). '" href="' . $instanceResource['url'] . '" class="btn btn-success pull-right">Launch</a>';
                                    $statusLabel = $instanceResource['status'] == 'In Progress' ? 'In Progress' : 'Not Completed';
                                    $user_enrolments .= '<button type="button" class="btn pull-right" style="margin-right: 10px;">Not Completed</button>';
                                } else {
                                    $user_enrolments .= '<button type="button" class="btn btn-success pull-right">Completed</button>';
                                }
                                $user_enrolments .= '<div class="clearfix"></div></div>';
                            }
                            $user_enrolments .= '	     	
                		<!-- <button id="" class="btn btn-glow inverse registration_list">Refresh results</button><br/><br/> -->
                		
							    </div>
							    <div class="tab-pane " id="tab2-' . $enrolment->INSTANCEID . '">
							      <div class="alert alert-info">
								                    <i class="icon-info-sign "></i>
								                    <strong>Important information regarding your training</strong><br><br>
					                            <strong>Description:</strong><br/>
					                            ' . $short_description . '
					                            <strong>Sessions:</strong> ' . $session_times . '<br/>
					                            <strong>Location:</strong> <br/>' . $location . '
								      	                </div>
							
							    </div>
					  </div>
				</div></div>';
                        } else {
                            $user_enrolments .= '    
						<div class="row-fluid" stlye="margin-bottom: 20px;">
					        <div class="span12 user_training pracBox">
					            <h4>' . $enrolment->NAME . ': ' . $enrolment->INSTANCEID . '</h4>
	
					            <div class="tabbable">
					                <strong> Delivery type:</strong> ' . $enrolment->DELIVERY . ' <strong>Status:</strong> ' . $enrolment->STATUS . '<br/><br/>
					
					                <div class="tab-content">
					                    <div class="tab-pane active">
					                        <div class="alert alert-info">
					                            <i class="icon-info-sign "></i> <strong>Important information regarding your training</strong>
					                            <br>
					                            <strong>Description:</strong><br/>
					                            ' . $short_description . '
					                            <strong>Sessions:</strong> ' . $session_times . '<br/>
					                            <strong>Location:</strong> <br/>' . $location . '</div>
					                    </div>
					                </div>
					            </div>
					        </div>
					
					        <div class="clear"></div>
					    </div>';
                        }
                    }
                }
            }

            $completed_enrolments .= '</tbody></table></div>';
            if ($enrolments == array()) {
                $response = json_encode(array("status" => "success", "enrolments" => null, "enrolmentsComplete" => null));
            } else {
                $response = json_encode(
                    array(
                        "status" => "success",
                        "enrolments" => $user_enrolments,
                        "enrolmentsComplete" => $completed_enrolments,
                        "data" => $enrolments
                    )
                );
            }
        } else {
            $response = json_encode(
                array(
                    "status" => "success",
                    "enrolments" => null,
                    "enrolmentsComplete" => null,
                    "data" => null
                )
            );
        }


        return $response;
    }

    public function myaccount(){
        return $this->userSession;
    }

    public function mydetails(){
        return $this->userSession;
    }

    public function myResults($userId)
    {
        $user = Common::curl_conn("contact/enrolments/" . $userId . "&type=w&displayLength=100", array());
        $enrolments = json_decode($user);
        $eLearning = array();
        //if they have > 0 enrolments, check any e-learning now. We will assign this later to save API calls
        if (count($enrolments) > 0) {
            $eLearning = json_decode(Common::curl_conn('/contact/enrolments/' . $userId . '?type=el'));
        }
        foreach ($enrolments as $filter_enrolment) {
            $filter_enrolments[$filter_enrolment->ENROLID] = $filter_enrolment;
        }
        $enrolments = $filter_enrolments;
        $user_enrolments = '';
        $completed_enrolments = '<div class="row-fluid"><table class="table table-hover">        <thead>
            <tr>
                <th class="span3">
                    Course
                </th>
                <th class="span2">
                	<span class="line"></span>
                    Date
                </th>
                <th class="span4">
                    <span class="line"></span>
                    Location
                </th>
                <th class="span2">
                    <span class="line"></span>
                    Result
                </th>
               <th class="span1">
                    <span class="line"></span>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>';
        //echo "<pre>"; print_r($enrolments); echo "</pre>"; exit; die();
        foreach ($enrolments as $enrolment) {
            //$instance = json_decode($this->curl_conn("course/detail?ID=$enrolment->ID&type=$enrolment->TYPE", array()));
            //$session_date = date("D M d\ h:i A Y ", strtotime($instance->STARTDATE));
            $session_times = "";
            foreach ($enrolment->COMPLEXDATES as $session) {
                $session_day = date("d/m/Y", strtotime($session->DATE));
                $session_start = date("h:i A", strtotime($session->STARTTIME));
                $session_end = date("h:i A ", strtotime($session->ENDTIME));
                $session_times .= "$session_day at $session_start to $session_end <br/>";
            }
            if ($enrolment->STATUS == "Completed") {
                $instance_details = json_decode(
                    Common::curl_conn("course/instance/detail?instanceID=" . $enrolment->INSTANCEID . "&type=w", array())
                );
                if ($instance_details->LINKEDCLASSID == null) {
                    $data_type = "statusID";
                    $data_id = $enrolment->ENROLID;
                } else {
                    $data_type = "enrolID";
                    $linked_enrolments = json_decode(
                        Common::curl_conn("/contact/enrolments/" . $userId . "?type=p&displayLength=100", array())
                    );
                    //echo "<pre>"; print_r($linked_enrolments); echo "</pre>"; exit; die();
                    foreach ($linked_enrolments as $linked_enrolment) {
                        if ($linked_enrolment->INSTANCEID == $instance_details->LINKEDCLASSID) {
                            //$data_id = $enrolment->ENROLID;
                            $data_id = $linked_enrolment->ENROLID;
                        }
                    }
                }
                $print = json_encode($enrolment);
                $completed_enrolments .= '

            	<tr class="even">
                    <td>
                       ' . $enrolment->NAME . ' ' . $enrolment->INSTANCEID . '
                        
                    </td>
                    <td>
                    	' . $session_times . '
                    </td>
                    <td>
                        ' . $enrolment->LOCATION . '	
                    </td>
                    <td>
                        <span class="label label-success"><i class="icon-ok"></i> ' . $enrolment->STATUS . '</span>
                    </td>
                    <td>
                    	<div class="btn-group settings">
                    		<a href="/layouts/certificate.php?id=' . $data_id . '" data-id="' . $data_id . '" data-type="' . $data_type . '" class="generate_cert btn btn-xs btn-glow success"><i class="icon-cloud-download"></i> Download certificate </a>
						</div>
						
                    </td>
                </tr>
            	
      				';
            } else {
                if ($enrolment->STATUS == "Booked" || $enrolment->STATUS == "Moved" || $enrolment->STATUS == "Paid") {
                    $instance_details = json_decode(
                        Common::curl_conn(
                            "course/instance/detail?instanceID=" . $enrolment->INSTANCEID . "&type=w",
                            array()
                        )
                    );
                    $venue_contactid = $instance_details->VENUECONTACTID;
                    if ($venue_contactid != "") {
                        $venue_details = json_decode(
                            Common::curl_conn("venues/?CONTACTID=" . $venue_contactid, array())
                        );
                        if ($venue_details != array()) {
                            $venue_detail = $venue_details[0];
                            $location = $venue_detail->NAME . "<br/>" . $venue_detail->SADDRESS1 . "<br/>";
                            $add2 = $venue_detail->SADDRESS2;
                            if ($add2 != null || $add2 != "") {
                                $location .= $add2;
                            }
                            $location .= $venue_detail->SCITY . ", " . $venue_detail->SSTATE . " " . $venue_detail->SPOSTCODE;
                        } else {
                            $location = $enrolment->LOCATION;
                        }
                    } else {
                        $location = $enrolment->LOCATION;
                    }
                    $course_types = json_decode(Common::curl_conn("courses?displayLength=100", array()));
                    $short_description = "";
                    foreach ($course_types as $coursetype) {
                        if ($coursetype->ID == $enrolment->ID) {
                            $short_description = $coursetype->SHORTDESCRIPTION . '<br/><br/>';
                        }
                    }
                    // Checks if Blended
                    if ($instance_details->LINKEDELEARNING != null) {
                        $instanceResources = array();
                        $eLearningCompleted = true;
                        //loop through our already loaded eLearning and match it up
                        foreach ($instance_details->LINKEDELEARNING as $linkedLearning) {
                            foreach ($eLearning as $eLearningModule) {
                                if ($linkedLearning->INSTANCEID == $eLearningModule->INSTANCEID) {
                                    $instanceResources[] = array(
                                        'name' => $eLearningModule->NAME,
                                        'url' => $eLearningModule->LAUNCHURL,
                                        'status' => $eLearningModule->STATUS,
                                        'newWindow' => $eLearningModule->ACTIVITYTYPE !== 'SCORMEngine'
                                    );
                                    if (!in_array($eLearningModule->STATUS, array('Completed', 'Passed', 'Failed'))) $eLearningCompleted = false;
                                }
                            }
                        }
                        $user_enrolments .= '<div class="pracBox span6">   
					  <h4>' . $enrolment->NAME . ': ' . $enrolment->INSTANCEID . '</h4>
					    <strong> Delivery type:</strong> ' . $enrolment->DELIVERY . ' <strong>Status:</strong> ' . $enrolment->STATUS . '<br/><br/>
					
						<div class="tabbable"> 
					  <ul class="nav nav-tabs" id="step-list">
					    
					<li class="active"><a href="#tab1-' . $enrolment->INSTANCEID . '" data-toggle="tab"><i class="icon-laptop"></i> <strong>Step 1: ' . ($eLearningCompleted ? 'Completed' : 'Complete online training') .'</strong></a></li>
					<li class=""><a href="#tab2-' . $enrolment->INSTANCEID . '" data-toggle="tab"><i class="icon-group"></i>  <strong>Step 2: Attend face-to-face training</strong></a></li>
					  </ul>
					  <div class="tab-content">
					    <div class="tab-pane active" id="tab1-' . $enrolment->INSTANCEID . '">
							    	<div class="alert alert-info">
								                    <i class="icon-info-sign "></i>
								                    <strong>Important information regarding your training</strong><br>
								                    This course requires you to complete online modules prior attending the face-to-face training.<br/><br/>
								                    ';

                        $user_enrolments .= '</div>';
                        //insert eLearning here
                        foreach($instanceResources as $instanceResource) {
                            $user_enrolments .= '<div class="elearning">';
                            $user_enrolments .= $instanceResource['name'];
                            if (!in_array($instanceResource['status'], array('Completed', 'Passed', 'Failed'))) {
                                $user_enrolments .= '<a target="' . ($instanceResource['newWindow'] ? '_blank' : '_self'). '" href="' . $instanceResource['url'] . '" class="btn btn-success pull-right">Launch</a>';
                                $statusLabel = $instanceResource['status'] == 'In Progress' ? 'In Progress' : 'Not Completed';
                                $user_enrolments .= '<button type="button" class="btn pull-right" style="margin-right: 10px;">Not Completed</button>';
                            } else {
                                $user_enrolments .= '<button type="button" class="btn btn-success pull-right">Completed</button>';
                            }
                            $user_enrolments .= '<div class="clearfix"></div></div>';
                        }
                        $user_enrolments .= '	     	
                		<!-- <button id="" class="btn btn-glow inverse registration_list">Refresh results</button><br/><br/> -->
                		
							    </div>
							    <div class="tab-pane " id="tab2-' . $enrolment->INSTANCEID . '">
							      <div class="alert alert-info">
								                    <i class="icon-info-sign "></i>
								                    <strong>Important information regarding your training</strong><br><br>
					                            <strong>Description:</strong><br/>
					                            ' . $short_description . '
					                            <strong>Sessions:</strong> ' . $session_times . '<br/>
					                            <strong>Location:</strong> <br/>' . $location . '
								      	                </div>
							
							    </div>
					  </div>
				</div></div>';
                    } else {
                        $user_enrolments .= '    
						<div class="row-fluid" stlye="margin-bottom: 20px;">
					        <div class="span12 user_training pracBox">
					            <h4>' . $enrolment->NAME . ': ' . $enrolment->INSTANCEID . '</h4>
	
					            <div class="tabbable">
					                <strong> Delivery type:</strong> ' . $enrolment->DELIVERY . ' <strong>Status:</strong> ' . $enrolment->STATUS . '<br/><br/>
					
					                <div class="tab-content">
					                    <div class="tab-pane active">
					                        <div class="alert alert-info">
					                            <i class="icon-info-sign "></i> <strong>Important information regarding your training</strong>
					                            <br>
					                            <strong>Description:</strong><br/>
					                            ' . $short_description . '
					                            <strong>Sessions:</strong> ' . $session_times . '<br/>
					                            <strong>Location:</strong> <br/>' . $location . '</div>
					                    </div>
					                </div>
					            </div>
					        </div>
					
					        <div class="clear"></div>
					    </div>';
                    }
                }
            }
        }
        $completed_enrolments .= '</tbody></table></div>';
        if ($enrolments == array()) {
            $response = json_encode(array("status" => "success", "enrolments" => null, "enrolmentsComplete" => null));
        } else {
            $response = json_encode(
                array(
                    "status" => "success",
                    "enrolments" => $user_enrolments,
                    "enrolmentsComplete" => $completed_enrolments,
                    "data" => $enrolments
                )
            );
        }
        return $response;
    }

    public function getCertificate($id){

        $certificate = Common::curl_conn('contact/enrolment/certificate?enrolID='.$id, array());
        $certificates = json_decode($certificate);

        if(array_key_exists("ERROR",$certificates) && $certificates->ERROR == 1) {
            $certificate = Common::curl_conn('contact/enrolment/certificate?statusID='.$id, array());
            $certificates = json_decode($certificate);
        }

        $pdf = PDF::loadHTML(base64_decode($certificates->CERTIFICATE));

        return $pdf->download('certificate.pdf');
    }

}
