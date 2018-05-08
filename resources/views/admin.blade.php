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
    <link href="{{asset('css/fontawesome-all.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Tag inputs-->
    <link href="{{asset('taginput/jquery.tagsinput.css')}}" rel="stylesheet" type="text/css">

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

    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- Bootstrap and necessary plugins -->
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

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
            <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning') ?>">Dashboard</a>
        </li>

    </ul>
    <ul class="nav navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <span><?php echo "Welcome " . $user['name'] ?></span>
            </a>
        </li>

    </ul>
    <div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#contact_us" role="button">
            <i class="icon-phone"></i> Help
        </a>
    </div>
    <div>
        <a class="dropdown-item" href="<?php echo App::make('url')->to('/user/logout')?>"><i class="fa fa-lock"></i>
            Logout</a>
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
                    <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning') ?>"><i
                                class="icon-speedometer"></i> Dashboard <span class="badge badge-info"></span></a>
                </li>

                <li class="divider"></li>
                <li class="nav-title">
                    My Functions
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i>Administration</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo App::make('url')->to('/mylearning') ?>"><i
                                        class="icon-puzzle"></i>Update Types</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo App::make('url')->to('/admin/groupCourses') ?>"><i
                                        class="icon-puzzle"></i>Group Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo App::make('url')->to('/admin/viewGroupCourse') ?>"><i
                                        class="icon-puzzle"></i>View Group Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('course-form.index')}}"><i class="icon-puzzle"></i>Manage
                                Course Forms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('corporateclient.index')}}"><i class="icon-puzzle"></i>Manage
                                Corporate Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('corporate.store')}}"><i class="icon-puzzle"></i>Add Corporate
                                Client</a>
                        </li>
                    </ul>
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

        <div class="container-fluid">

            <div>
                @yield('content')
            </div>

        </div>
    </main>


</div>
<footer class="app-footer">
    <span></span>
    <span class="ml-auto">Powered by <a href="http://www.230i.com" target="_blank">230i</a></span>
</footer>


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


<!-- color picker-->
<script src="{{asset('js/colorpicker/jscolor.js')}}" type="text/javascript"></script>

<!-- Tag inputs-->
<script src="{{asset('taginput/jquery.tagsinput.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {

        $('#tags_1').tagsInput({width:'auto'});

    });

</script><script>
    $(function() {
        var src = $('#logo').attr('src');
        if(src == 'noimage'){
            $('#logo').hide();
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    console.log(e.target.result);
                    $('#logo').attr('src', e.target.result);
                    $('#logo').fadeIn(400);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#logoInput").change(function() {

            readURL(this);
        });
    });
</script>
</body>
</html>