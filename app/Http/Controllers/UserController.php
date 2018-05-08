<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use app\Helpers\Common;
use Auth;
use App\User;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function groupCourses(Request $params)
    {
        try {
            $data = $params->all();
            $data['Courses'] = implode(",", $params['Courses']);

            Mail::send('course_group_mail', ['organisation' => $data["OrganisationName"], "contact_name" => $data['ContactName'],
                "contact_email" => $data['ContactEmail'], "contact_number" => $data['ContactNumber'], "venue" => $data['CourseVenue'],
                "date" => $data['Date'], "comments" => $data['AdditionalComments'], "courses" => $data['Courses']], function ($message) use ($data) {
                $message->to('training@lsv.com.au', 'Training')->subject
                ('New group training enquiry');
                $message->from($data['ContactEmail'], $data['ContactName']);
            });
            $status["success"] = "New group training enquiry";
            $status["error"] = "";
        } catch (\Exception $exception) {
            $status["error"] = "An error occurred";
            $status["success"] = "";
        }
    }

    public function register(Request $request)
    {
        $params = $request->all();
        $username = $params['username'];
        $contact_response = Common::curl_conn("contacts/?givenName=$params[givenName]&surname=$params[surname]&dob=$params[dob]", array());
        $contact_result = json_decode($contact_response);
        $contacts = count($contact_result);

        if ($contacts > 1) {
            //thorw error
            return json_encode(array("status" => "error", "message" => "Please contact LSV as their are duplicate contact records with your details.Please Email: volunteertraining@lsv.com.au or Telephone: 9676 6950 (Option 2 - Volunteer Training)."));
        }

        if ($contacts == 1) {
            //get contact id and check user exist
            $contact_id = $contact_result[0]->CONTACTID;
            $user_response = Common::curl_conn("users", array("contactID" => $contact_id));
            $user_result = json_decode($user_response);
            $users = count($user_result);
            if ($users > 0) {
                //throw error
                return json_encode(array("status" => "error", "message" => "A contact record has been found with same details, please use the forgot password function to retrieve your login detail."));
            } else {

                //check username
                if ($this->usernameExist($username)) {
                    return json_encode(array("status" => "error", "message" => "Username already exist, please enter another username."));
                } else {
                    //registration
                    $params['contact_id'] = $contact_id;
                    return $this->registerUser($params);
                }
            }
        } else {
            //check username
            if ($this->usernameExist($username)) {
                return json_encode(array("status" => "error", "message" => "Username already exist, please enter another username."));
            } else {
                //registration
                return $this->registerUser($params);
            }
        }
    }

    function registerUser($params)
    {

        $params['organisation'] = '';
        $result = array();
        if (array_key_exists("contact_id", $params) && isset($params['contact_id'])) {
            if ($params['contact_id'] != "") {
                $result->CONTACTID = $params['contact_id'];
                $update_email = array("emailAddress" => $params['emailAddress']);
                $update_user = json_decode(Common::curl_conn_put("contact/$result->CONTACTID", $update_email));
            } else {
                $results = Common::curl_conn("contact", $params);
                $result = json_decode($results);
            }
        } else {
            $results = Common::curl_conn("contact", $params);
            $result = json_decode($results);
        }

        if (array_key_exists("CONTACTID", $result) && $result->CONTACTID) {
            $user_details = array(
                "contactID" => $result->CONTACTID,
                "username" => $params['username'],
                "password" => $params['password']
            );

            $registration = json_decode(Common::curl_conn("user", $user_details));

            if (array_key_exists("ERROR", $registration) && $registration->ERROR) {
                $response = array("status" => "error", "message" => $registration->MESSAGES);
            } else {
                $user_input = array("passwordchangeatnextlogin" => "1");
                Common::curl_conn_put("/user/$registration->USERID", $user_input);
                $user_params = array(
                    "username" => $params['username'],
                    "oldPassword" => $params['password'],
                    "newPassword" => $params['password'],
                    "verifyPassword" => $params['password']
                );
                Common::curl_conn("/user/changePassword", $user_params);

                $user_infos = Common::curl_conn("/contact/$registration->CONTACTID", array());
                $user_info = json_decode($user_infos, true);

                $user_info["USERID"] = $registration->USERID;
                $user_info["USERNAME"] = $registration->USERNAME;

                //$user = json_decode($user_info,true);
                $contact = json_decode(Common::curl_conn("/contact/$registration->CONTACTID", array()));

                $user['GIVENAME'] = $contact->GIVENNAME;
                $user['SURNAME'] = $contact->SURNAME;
                $user_details = array_merge($user_info, $user);
                //$user_details = array_merge($user_details, $contact);
//                if(isset($_SESSION['org'])){
//                    if($_SESSION['org'] == "ymca"){
//                        $contactid = array();
//                        $contactid['categoryids'] = 8258;
//                        $result = json_decode(Common::curl_conn_put("contact/$registration->CONTACTID", $contactid));
//                    }
//                }

                Session::set("user_details", $user_details);

                $userParams['name'] = $params['givenName'];
                $userParams['email'] = $params['emailAddress'];
                $userParams['password'] = Hash::make($params['password']);
                $user = User::create($userParams);
                Auth::login($user);
                $_SESSION["user_details"] = $user_details;
                $response = array("status" => "success", "message" => "User created successfully.");
            }
        }
        return json_encode($response);
    }

    function usernameExist($username)
    {

        $username_response = Common::curl_conn("users", array("username" => $username));
        $username_result = json_decode($username_response);
        $usernames = count($username_result);
        if ($usernames > 0) {
            //throw error
            return true;
        } else {
            //registration
            return false;
        }
    }

    public function login(Request $request)
    {
        $params = $request->all();

        $user = User::where('email', $params['userId'])
            ->first();
        if ($user && $user->name == "admin") {
            Auth::login($user);
            Session::set("user_details", $user);
            $response = array("status" => "success", "message" => "Login successful.");
        } else {
            $data = array("username" => $params['userId'], "password" => $params['password']);
            $results = Common::curl_conn("user/login", $data);
            $result = json_decode($results, true);

            if (array_key_exists("STATUS", $result) && strtolower($result["STATUS"]) == "error") {
                $response = array("status" => "error", "message" => $result["MESSAGE"], "user_details" => $result);
            } else {
                $users = Common::curl_conn("user/" . $result["USERID"], array());
                $user = json_decode($users, true);
                $contact = json_decode(Common::curl_conn("/contact/" . $user['CONTACTID'], array()));
                $user['GIVENAME'] = $contact->GIVENNAME;
                $user['SURNAME'] = $contact->SURNAME;
                $user['CATEGORYID'] = $contact->CATEGORYIDS;
                Session::set("user_details", $user);


                $user = User::where('email', $params['userId'])
                    ->first();
                if ($user) {
                    Auth::login($user);
                }


                $response = array("status" => "success", "message" => "Login successful.");
            }
        }

        return json_encode($response);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended("/");
    }

    public function resetPassword(Request $request)
    {

    }

    public function requestPassword(Request $request)
    {
        $params = $request->all();
        $username = $params['username'];
        $username_response = Common::curl_conn("users", array("username" => $username));

        $username_result = json_decode($username_response);
        $usernames = count($username_result);
        if (count($username_result) > 0) {

            $contact_id = $username_result[0]->CONTACTID;
            $contact_user = json_decode(Common::curl_conn("contact/$contact_id", array()));
            $email = $contact_user->EMAILADDRESS;

            $req_params = array(
                "username" => $username,
                "email" => $email,
            );

            //update password
            $password_response = Common::curl_conn('user/forgotPassword', $req_params);
            $update_password = json_decode($password_response);

            $user_input = array("passwordchangeatnextlogin" => '0');
            $value = "/user/" . $username_result[0]->USERID;

            Common::curl_conn_put($value, $user_input);

            if ($update_password->STATUS == "success") {
                return json_encode(array("status" => "success", "message" => "Password has been reset, please check your email for further instructions"));
            } else {
                return json_encode(array("status" => "error", "message" => $update_password->MSG));
            }

        } else {
            return json_encode(array("status" => "error", "message" => "There is no matching user record for the username above, please click ‘Forgot username’ to reset your password"));
        }

    }

    public function requestUsername(Request $request)
    {
        $params = $request->all();
        $data["DOB"] = $params["dobUser"];
        $data["givenName"] = $params["givenFirstName"];
        $data["surname"] = $params["legalSurname"];
        $data["email"] = $params["emailUser"];

        $results = Common::curl_conn("user/forgotUsername", $data);
        $result = json_decode($results);

        if (array_key_exists("ERROR", $result) && $result->ERROR == true) {
            $response = array("status" => "error", "message" => "An error has occurred: $result->DETAILS");
        } else if (array_key_exists("STATUS", $result) && $result->STATUS == "error") {
            $response = array("status" => "error", "message" => "An error has occurred: $result->MSG");
        } else {
            $response = array("status" => "success", "message" => "You have successfully retrieved your username, we have sent an email to the email address you used to sign up with further details.");
        }

        return json_encode($response);
    }

    public function validateCert(Request $request)
    {
        $params = $request->all();
        $certificate = $params["id1"] . "-" . $params["id3"];
        $results = json_decode(Common::curl_conn("/contact/enrolment/verifyCertificate/$certificate", array()));

        if (array_key_exists("RESULT", $results) && $results->RESULT == true) {
            $result = json_encode(array("status" => "success", "message" => "Record verified", "results" => $results));
        } else {
            $result = json_encode(array("status" => "error", "message" => "No record found, please contact us via email: training@lsv.com.au or phone: (03) 9676 6950"));
        }
        return $result;
    }


    public function profile($get)
    {

        $user = Common::curl_conn("user/" . $get, array());
        $results = json_decode($user);

        if (array_key_exists("ERROR", $results) && $results->ERROR == true) {
            $response = array("status" => "error", "message" => "An error occurred: $results->MESSAGES");
        } else {
            $contact = json_decode(Common::curl_conn("contact/$results->CONTACTID", array()));
            $response = array("status" => "success", "userDetails" => $results, "contactDetails" => $contact);
        }
        return json_encode($response);
    }

    public function updatePassword(Request $request)
    {
        $params = $request->all();
        $results = Common::curl_conn("/user/changePassword", $params);
        $result = json_decode($results);

        if (array_key_exists("STATUS", $result) && $result->STATUS == "error") {
            $response = array("status" => "error", "message" => $result->MSG);
        } else {
            $response = array("status" => "success", "message" => "Your password has been updated.");
        }

        return json_encode($response);
    }

    public function myDetails(Request $request)
    {
        $params = $request->all();
        unset($params["_token"]);
        unset($params["url"]);
        $update_email = array("givenName" => 'Prathibaab', "surname" => 'dantha',
            "emailAddress" => 'cpdantha57@gmail.com',
            "title" => 'Mr',
            "sex" => '',
            "dob" => '17/01/1995',
            "buildingName" => '',
            "unitNo" => '',
            "streetNo" => '',
            "streetName" => '',
            "city" => '',
            "state" => '',
            "postcode" => '',
            "POBox" => '',
            "sbuildingName" => '',
            "sstreetNo" => '',
            "sstreetName" => '',
            "scity" => '',
            "sstate" => '',
            "spostcode" => '',
            "phone" => '',
            "workphone" => '',
            "mobilephone" => '',
            "CountryofBirthID" => 'No',
            "CountryofBirthID" => '',
            "IndigenousStatusID" => '',
            "MainLanguageID" => 'Yes',
            "MainLanguageID" => '',
            "EnglishProficiencyID" => '',
            "DisabilityFlag" => '0',
            "customField1" => '',
            "USI" => '',
            "HighestSchoolLevelID" => '',
            "HighestSchoolLevelYear" => '',
            "AtSchoolFlag" => 'false',
            "LabourForceID" => '',
            "DisabilityTypeIDs" => '',
            "PriorEducationIDs" => '',
            "contactID" => '4923418');
        $result = json_decode(Common::curl_conn_put("contact/4923418", $update_email));
        if (array_key_exists("ERROR", $result) && $result->ERROR == true) {
            $response = array("status" => "error", "message" => $result->MESSAGES, "response" => $result);
        } else {
            $response = array("status" => "success", "message" => "You have successfully updated your details.");
        }
        return json_encode($response);
    }

}
