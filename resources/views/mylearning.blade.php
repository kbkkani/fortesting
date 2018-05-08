<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Alba - Bootstrap 4 Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,jQuery,CSS,HTML,RWD,Dashboard,Vue,Vue.js,React,React.js">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Learn from anywhere</title>

    <!-- Icons -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 

    <!-- Main styles for this application -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

    <!-- Styles required by this views -->
    <link type="text/css" href="{{asset('css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/gauge.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/toastr.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/application.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/select2.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset('css/master.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}"/>
    <!-- Bootstrap and necessary plugins -->
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>


<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none mr-auto">
        <li class="nav-item px-3">
            <a class="nav-link dashboard-nav-toggler-link" href="<?php echo App::make('url')->to('/mylearning') ?>">Dashboard</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link nav-link dropdown-item" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon ico-welcome"></i>
                <span><?php echo "Welcome " . $user['GIVENAME']; ?></span>
            </a>
        </li>
    </ul>
    <div class="nav-help">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#contact_us" role="button">
            <i class="icon ico-help"></i> Help
        </a>
    </div>
    <div class="nav-logout">
        <a class="dropdown-item" href="<?php echo App::make('url')->to('/user/logout')?>"><i class="icon ico-logout"></i> Logout</a>
    </div>
</header>



<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-title">
                    Dashboard
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning') ?>"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-info"></span></a>
                </li>

                <li class="divider"></li>
                <li class="nav-title">
                    My Functions
                </li>


                <!-- 11th Apr, 2018 - by hasitha
                
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> My Trainings</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="components-buttons.html"><i class="icon-puzzle"></i> TO-DO List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php //echo App::make('url')->to('/mylearning/myaccount') ?>"><i class="icon-puzzle"></i> My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php //echo App::make('url')->to('/mylearning/mydetails') ?>"><i class="icon-puzzle"></i> My Details</a>
                        </li>

                    </ul>
                </li> -->

                <!-- new list by hasith on 11th Apr, 2018 -->
                <li class="nav-item nav-dropdown">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-graph"></i> My Training</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="components-buttons.html"><i class="icon-notebook"></i> TO-DO List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning/myaccount') ?>"><i class="icon-user"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning/mydetails') ?>"><i class="icon-book-open"></i> My Details</a>
                    </li>
                </li>

            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>


    <!-- Main content -->
    <main class="main">

        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Dashboard</li>
            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <i class="icon-graph"></i> Thought of the day
                </div>
            </li>
        </ol>

        <div class="container-fluid main-container">

            <div>
                @yield('content')
            </div>

        </div>
    </main>


</div>
<footer class="app-footer">
    <span></span>
    <span class="ml-auto">Powered by <a href="http://www.230i.com">230i</a></span>
</footer>

<script>
    var contactID = "<?php //echo $contactId ?>";
    $(document).ready(function(){

        if (location.hash.substr(0,2) == "#1") {
            var pageType = location.hash.substr(2);
            $("a[href='#" + location.hash.substr(2) + "']").tab("show");
            if(pageType == "current_reg"){
                $.blockUI({ message: waitmsg });
                $.ajax({
                    type: "GET",
                    url: "/mylearning/userEnrolment/"+contactID,
                    dataType: 'json',
                    cache: false,
                    data: [],
                    success: function(data) {
                        var result = JSON.stringify(data, undefined, 2);
                        if(data.status == 'success'){
                            var userEnrolments=data.enrolments;
                            var certNotification = '<div class="alert alert-warning"><i class="icon-warning-sign"></i><strong>No enrolments</strong><br/>You are currently not enrolled to any courses</p></div>';
                            if(data.enrolments == null){
                                $('#current_reg').html(certNotification);
                            } else {
                                $('#current_reg').html(userEnrolments);
                            }
                        } else {
                            $.unblockUI();
                            alert(data.message);
                        }
                    },
                    error: function(data) {
                        $.unblockUI();
                        alert('Network error please try again.');
                    }
                });
            }
        }

        $("a[data-toggle='tab']").on("shown", function (e) {
            var hash = $(e.target).attr("href");
            if (hash.substr(0,1) == "#") {
                location.replace("#1" + hash.substr(1));
            }
        });

    });

    $(".advanced_search").click(function() {
        $('#calendar').fullCalendar('destroy');
        $('.advanced_fields').slideDown();
    });

    $(".calendar_btn").click(function() {
        $('.advanced_fields').slideUp();
        $('#calendar').fullCalendar('destroy').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },

            events:
                [
                    {
                        "id": "36162BE3-7907-46A6-8670470275E5D926",
                        "title": "aXc Day: Session Three - For existing aXcelerate Users (Operational level)",
                        "start": "2015-01-24 13:30",
                        "allDay": false,
                        "type": "non-accredited",
                        "location": "Brisbane",
                        "courseInstanceID": 155391,
                        "courseID": 5089,
                        "end": "2015-01-24 15:30",
                        "type":"w"
                    },
                    {
                        "id": "D59EAC05-A4FE-48B8-BE261964D3645012",
                        "title": "aXc Day: Session Two - For RTO Managers and Business Owners (Strategic Level)",
                        "start": "2015-01-24 11:00",
                        "allDay": false,
                        "type": "non-accredited",
                        "location": "Brisbane",
                        "courseInstanceID": 155370,
                        "courseID": 5088,
                        "end": "2015-01-24 12:30",
                        "type":"w"
                    },
                    {
                        "id": "24CDF04D-82B1-474D-A4D143023EE3D0A3",
                        "title": "aXc Day: Session One - For aXcelerate Prospects & RTO Consultants",
                        "start": "2015-01-24 08:30",
                        "allDay": false,
                        "type": "non-accredited",
                        "location": "Brisbane",
                        "courseInstanceID": 157134,
                        "courseID": 5087,
                        "end": "2015-01-24 10:30",
                        "type":"w"
                    },
                    {
                        "id": "052D1703-1A55-48CE-9EAC8AA685E104A1",
                        "title": "aXcelerate Training",
                        "start": "2015-01-25 09:00",
                        "allDay": false,
                        "type": "non-accredited",
                        "location": "Olympus Mons, Mars",
                        "courseInstanceID": 155397,
                        "courseID": 1727,
                        "end": "2015-01-25 11:00",
                        "type":"w"
                    }
                ]
            ,
            eventColor: '#5674f7',
            eventClick: function(event) {
                if (event.courseInstanceID) {
//                    opencourse_modal(event.courseInstanceID,event.type)
//                    return false;
                    $('#course-modal').modal({
                        show: true,
                        remote: "" + "/api/courses/details/" + event. b  + "/" + event.type
                    })
                    return false;
                }
            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            }
        });
    });
</script>

<script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('js/pace.min.js')}}"></script>

<!-- Plugins and scripts required by all views -->
<script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>

<!-- Alba main scripts -->

<script type="text/javascript" src="{{asset('js/app.js')}}"></script>

<!-- Plugins and scripts required by this views -->
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/gauge.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>

<!-- Custom scripts required by this view -->
{{--<script type="text/javascript" src="{{asset('js/main.js')}}"></script>--}}
<script src="{{asset('js/lsv.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.js"></script>
<script src="https://training.lsv-from-anywhere.com.au/assets/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('js/moment-with-locales.js')}}"></script>

<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="https://training.lsv-from-anywhere.com.au/assets/js/additional-methods.min.js"></script>
<script src="{{asset('js/theme.js')}}" type="text/javascript"></script>
<script src="{{asset('js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/Chart.min.js')}}" type="text/javascript"></script>

</body>
</html>