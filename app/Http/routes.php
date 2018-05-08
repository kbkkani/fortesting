<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::post('/home/searchDt', 'HomeController@searchDt');

Route::post('/home/getAllCourses', 'HomeController@getAllCourses');

Route::post('/home/searchCourses', 'HomeController@searchCourses');

Route::post('/home/getAllCourseInfo', 'HomeController@getAllCourseInfo');

Route::post('/user/groupCourses', 'UserController@groupCourses');

Route::post('/user/register', 'UserController@register');

Route::post('/user/login', 'UserController@login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/mylearning', function () {

        $alltype = App\Type::all(array("instance_id", "type", "is_active"));
        $type = App\Type::where('is_active', 1)->get();
        $coursesCount = App\Course::all()->count();

        if (\Auth::check()) {
            $loggedIn = "Logged In";
            $user = \Auth::user();
            $user_details = App::call('App\Http\Controllers\LearnController@index');
        } else {
            $loggedIn = "Not Logged In";
        }
        if ($user->name == "admin") {

            return view('includes.admin', array('token' => csrf_token(), "types" => $alltype, "loggedIn" => $loggedIn, "user" => $user));
        } else {
            return view('includes.mylearninghome', array('token' => csrf_token(), "contactId" => $user_details["CONTACTID"], "types" => $type, "loggedIn" => $loggedIn, "user" => $user, "coursesCount" => $coursesCount));
        }

    });
});

Route::get('/user/logout', 'UserController@logout');

Route::post('/user/requestPassword', 'UserController@requestPassword');

Route::post('/user/requestUsername', 'UserController@requestUsername');

Route::post('/user/validateCert', 'UserController@validateCert');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/mylearning/courses/{instanceId}', 'LearnController@courses');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/profile/{instanceId}', 'UserController@profile');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/mylearning/enrolInstanceDetails', 'LearnController@enrolInstanceDetails');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('mylearning/createEnrol', 'LearnController@createEnrol');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('mylearning/userEnrolment/{contactId}', 'LearnController@userEnrolment');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('mylearning/myaccount', function () {
        $value = App::call('App\Http\Controllers\LearnController@myaccount');

        return view('includes.myaccount', array("user" => $value));
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('user/updatePassword', 'UserController@updatePassword');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('mylearning/mydetails', function () {
        $value = App::call('App\Http\Controllers\LearnController@mydetails');
        $countries = \App\Helpers\Common::countries();
        $languages = \App\Helpers\Common::languages();
        return view('includes.mydetails', array("user" => $value, "countries" => $countries, "languages" => $languages));
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('user/myDetails', 'UserController@myDetails');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/mylearning/myResults/{userId}', 'LearnController@userEnrolment');
});

Route::get('/mylearning/certificate/{id}', 'LearnController@getCertificate');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/admin/updateType', 'AdminController@updateType');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/groupCourses', function () {

        $type = App\Type::where('is_active', 1)->get();

        if (\Auth::check()) {
            $loggedIn = "Logged In";
            $user = \Auth::user();
        } else {
            $loggedIn = "Not Logged In";
        }
        return view('includes.group_courses', array("loggedIn" => $loggedIn, "user" => $user, "types" => $type));
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/createGroupCourses/{Id}', 'AdminController@createGroupCourses');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/deleteGroupItem/{Id}/{Group}', 'AdminController@deleteGroupItem');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/admin/submitGroupForm', 'AdminController@submitGroupForm');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/viewGroupCourse', function () {
        $groups = \App\GroupMaster::all();
        $user = \Auth::user();
        $groupcourses = \App\GroupCourse::all();

        return view('includes.view_group', array("groups" => $groups, "groupcourses" => $groupcourses, "user" => $user));
    });

    Route::get('admin/course-form', 'CourseFormController@index')->name('course-form.index');

    Route::post('admin/course-form', 'CourseFormController@getUsers')->name('course-form');
    Route::post('admin/course-form.save', 'CourseFormController@saveUserType')->name('course-form.save');


});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/mylearning/viewGroupCourse', function () {
        $groups = \App\GroupMaster::all();
        $user = \Auth::user();
        $groupcourses = \App\GroupCourse::all();

        return view('includes.view_group', array("groups" => $groups, "groupcourses" => $groupcourses, "user" => $user));
    });

//    Route::get('admin/allCorporateClients', 'CorporateclientController@allCorporateClients')->name('corporate.clients');
//    Route::get('admin/addNewCorporateClient', 'CorporateclientController@addNewCorporateClient')->name('corporate.add');
//
//    Route::post('admin/createCorporateClient', 'CorporateclientController@createCorporateClient')->name('ccnew');
//
//    Route::post('admin.createCorporateClient', 'CorporateclientController@getUsers')->name('datatable.clients');
//
    Route::get('admin/corporate-client/{id}', 'CorporateclientController@delete');
//    Route::post('admin.updateCorporateClient', 'CorporateclientController@update')->name('corporate.update');
    Route::resource('admin/corporate-client', 'CorporateclientController');
});



Route::get('clean', function (){
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    exec('composer dump-autoload');
});









