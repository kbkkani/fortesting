<!DOCTYPE html>
<html>
    <head>
        <title>Learn from anywhere</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="<?php echo csrf_token() ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        
        <link type="image/png" href="img/favicon.png" rel="icon" />
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        
        <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="{{asset('js/moment-with-locales.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.js"></script>
        <script src="https://training.lsv-from-anywhere.com.au/assets/js/jquery.blockUI.js"></script>
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script src="https://training.lsv-from-anywhere.com.au/assets/js/additional-methods.min.js"></script>
        <script src="{{asset('js/theme.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/lsv.js')}}" type="text/javascript"></script>

        <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}"/>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/application.css')}}"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/select2.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}"/> <!--new css file-->
        <link rel="stylesheet" type="text/css" href="{{asset('css/master.css')}}"/> <!--new css file-->

    </head>
    <body class="home-body"><!--body class for gradient effect*-->
    <div class="logo-container">
        <div class="container">
            <div class="row">
               <!-- *11-04-18 by sasith* <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12 top_cont"> <a href="">www.lsv.com.au</a> </div>-->
               <div class="col-xs-12 social list-inline"><!--new social media icons*-->
                   <ul class="pull-right list-inline">
                        <li class="f"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="tw"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="pl"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li class="lin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li class="ins"><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li class="yt"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>    
            </div>
        </div>
    </div>

    <div class="logo_area">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12"> <img class="logo" src="{{asset('img/logo.png')}}"> </div>
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <ul class="pull-right list-inline tlist"><!--new greay text list*-->
                        <li class="course_info"><a data-toggle="tooltip" title="" data-original-title="Information on training courses">Course info</a></li>
                        <li data-toggle="modal" data-target="#groupModal"><a data-toggle="tooltip" title="" data-original-title="Book a course for a group or organisation">Group courses</a></li>
                        <li><a data-toggle="modal" data-target="#validate-modal">Validate</a></li>
                        <li data-toggle="modal" data-target="#contact_us"><a data-toggle="tooltip" title="" data-original-title="Information on reaching us">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main_bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 ">
                    <h1 class="main_header">Upcoming Training Courses</h1>
                </div>
                <div class="col-xs-8 col-xs-offset-2 top_sec">
                    <p class="blue-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed eiusmod tempor</p>
                  <!-- *11-04-18 by sasith*  <p>On this page, you can see information on our training courses, find upcoming training courses, <a href="#" data-toggle="modal" data-target="#create_account">register an account with us or login to your account.</a></p>-->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="login-form-container">
                        <div class="row">
                            <!-- *11-04-18 by sasith* <div class="col-lg-6 col-sm-12 col-md-6 pad_r_0">
                                <div class="col-xs-12 col-md-6 icon_info course_info box_data" style="cursor: pointer" data-toggle="tooltip" title="" data-original-title="Information on training courses"> <span><img src="{{asset('img/info.png')}}" alt="info"></span> COURSE INFO </div>
                                <div class="col-xs-12 col-md-6 icon_info group_btn box_data group_courses" style="cursor: pointer" data-toggle="tooltip" title="" data-original-title="Book a course for a group or organisation">
                                    <span><img src="{{asset('img/group.png')}}" alt="group"></span> GROUP COURSES </div>
                                <div class="col-xs-12 col-md-6 icon_info  box_data contact contact_btn" style="cursor: pointer" data-toggle="tooltip" title="" data-original-title="Information on reaching us">
                                    <span><img src="{{asset('img/contact.png')}}" alt="contact"></span>  CONTACT </div>
                                <div class="col-xs-12 col-md-6 icon_info box_data validate" style="cursor: pointer" data-toggle="modal" data-target="#validate-modal">
                                    <span><img src="{{asset('img/validate.png')}}" alt="validate"></span>  VALIDATE </div>
                            </div>-->
                            <div class="col-xs-12 login-form-out">
                                <div class="login-form">

                                 @include("includes.login")

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid ">
        {{--<form id="searchcourse" role="form" action="https://training.lsv-from-anywhere.com.au/api/index.php" method="post">--}}
        <div id="search-course">
            <div class="row div-icon-btns ">
                <div class="filter_option">
                    <div class="col-xs-12 col-md-3">
                        <label for="coursetype" class=""><i class="icon-exchange"></i> Select a training course:</label>
                        <br>
                        <select id="courseType" name="courseType" style="font-size: 13px;" class="form-control course-type-main">
                            <?php foreach ($types as $type){ ?>
                            <option id="<?php echo $type->instance_id ?>"><?php echo $type->type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                   
                   <!-- *11-04-18 by sasith*  <div class="col-xs-12 col-md-2">
                        <label><i class="icon-calendar"></i> Date to:</label>
                        <div class='input-group date' id='datetimepicker_end'>
                            <input id="endDate" type='text' class="form-control" />
                        </div>
                    </div>-->
                    <div class="col-xs-12 col-md-3">
                        <label>Course ID <a href="https://training.lsv-from-anywhere.com.au/userguides" class="info_sign" data-toggle="tooltip" title="" style="font-size: 13px;" data-original-title="Course codes are a alphanumeric set of numbers and letters provided by training organisations for both public and private courses."><i class="icon-question-sign"></i> </a>:</label>
                        <input id="instanceId" type="text" class="form-control" placeholder="Enter Course ID" />
                    </div>
                      <!--new date range select-->
                     <div class="col-xs-12 col-md-2">
                        <label><i class="icon-calendar"></i> Date Range:</label>
                        <div class='input-group' id=''>
                           <select id="dateRange" name="dateRange" style="font-size: 13px;" class="form-control">
                              <option value="next-10-days">Next 10 Days</option>
                              <option value="next-15-days">Next 15 Days</option>
                           </select>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-2 pull-right">
                        <label class="visibility-hidden hidden-xs"><i class=""></i> Date from:</label>
                        <br>
                        <button id="searchcourse" class="search_btn btn spec_search"><i class="icon-search"></i> Search</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <input type="hidden" name="displayLength" value="100">
                <input type="hidden" name="is_Loggedin" id="is_Loggedin" value="0">

                <div class="clearfix"></div>
            </div>
        </div>
        {{--</form>--}}
        <div class="clearfix"></div>
    </div>

            <div class="container-fluid">
                    <div class="row">
                        <div class='col-md-12'>
                            <div class="clearfix"></div>
                            <div id="course_info">
                                <div class="courses-panel" style="display: none;">
                                    <div class="courses-panel-heading" style="display: none"><span class=" pull-right"><button class="btn btn-glow toggle_show"><i class="fa fa-chevron-up"></i><!--new arrow--></button><br></span><h5><!--<i class="fa fa-info icon"></i>-->Information on training courses</h5></div>

                                    <div class="panel-body all_courses" style="display: block;">
                                        <div class="bs-example">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="courses-panel-body">
                                <div class="response">
                                    <div id="search-results">
                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Course start date</th>
                                                <th>Type</th>
                                                <th>Course timing</th>
                                                <th>Location</th>
                                                <th>Delivery Method</th>
                                                <th>Price</th>
                                                <th>Spaces available</th>
                                                <th>Enrol</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



            </div>

    <footer>
        @include('includes.footer')
    </footer>

    <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" id="group_email" action="#" name="group_email" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="groupModalLabel"><i class="icon-group"></i> Groups</h4>
                    </div>
                    <div class="modal-body">
                        <div id="group_components">
                            <div class="form-group">
                            
                            <!--changed .col-sm-7 to .col-sm-8-->
                            
                                <label for="OrganisationName" class="col-sm-4 control-label">Organisation Name:</label>
                                <div class="col-sm-8">
                                    <input class="req form-control" type="text" name="OrganisationName" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContactName" class="col-sm-4 control-label">Contact Name:</label>
                                <div class="col-sm-8">
                                    <input class="req form-control" type="text" name="ContactName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContactNumber" class="col-sm-4 control-label">Contact Number:</label>
                                <div class="col-sm-8">
                                    <input class="req form-control" type="text" name="ContactNumber">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContactEmail" class="col-sm-4 control-label">Contact Email:</label>
                                <div class="col-sm-8">
                                    <input class="req form-control" type="text" name="ContactEmail">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label">I'd like to be contacted with
                                    information and a quote for the following course/s:</label>
                                <div class="col-sm-8">
                                    <select class="select2" style="width: 100%; display: none;" name="Courses[]" id="Courses" multiple="multiple">
                                        <option value="Pool Lifeguard">Pool Lifeguard</option>
                                        <option value="Emergency First Aid (Level 1)">Emergency First Aid (Level 1) </option>
                                        <option value="Provide First Aid (Level 2)">Provide First Aid (Level 2)</option>
                                        <option value="Advanced First Aid (Level 3)">Advanced First Aid (Level 3) </option>
                                        <option value="CPR">CPR</option>
                                        <option value="Defibrillator">Defibrillator</option>
                                        <option value="Asthma Management">Asthma Management</option>
                                        <option value="Anaphylaxis">Anaphylaxis</option>
                                        <option value="Community Surf Lifesaving Certificate">Community Surf Lifesaving
                                            Certificate </option>
                                        <option value="Aquatic Technical Operators">Aquatic Technical Operators</option>
                                        <option value="Pool Bronze Medallion">Pool Bronze Medallion</option>
                                        <option value="Beach Bronze Medallion">Beach Bronze Medallion</option>
                                        <option value="First Aid for Students">First Aid for Students</option>
                                        <option value="Child and Infant CPR Workshop">Child and Infant CPR Workshop </option>
                                        <option value="Spinal Management Workshop">Spinal Management Workshop</option>
                                        <option value="Hydro Rescue Award">Hydro Rescue Award</option>
                                        <option value="Oxygen Resuscitation">Oxygen Resuscitation</option>
                                        <option value="Inland Waterways Life Saving Certificate">Inland Waterways Life
                                            Saving Certificate </option>
                                        <option value="Other (please specific in comments box)">Other (please specific
                                            in comments box) </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="CourseVenue" class="col-sm-4 control-label">Training Course Venue (facility
                                    hire is available upon request):</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="CourseVenue">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Date" class="col-sm-4 control-label">I'd like to request the following
                                    date/s for the training session/s:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="Date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="AdditionalComments" class="col-sm-4 control-label">Additional
                                    comments:</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="AdditionalComments"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success group_response" style="display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-glow primary btn_group_email" type="submit"><i class="icon-signin"></i>Submit </button>
                        <button type="button" class="btn-glow close_btn" data-dismiss="modal" aria-hidden="true">Close </button>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                </form>
            </div>
            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>

    <div id="registration">
        @include('includes.registration')
    </div>

    @include('includes.contact')

    @include('includes.forgotpassword')

    @include('includes.forgotusername')

    @include('includes.validate')
    </body>

    <script type="application/javascript">
        $.blockUI({message: "<i class='fa fa-refresh fa-spin'></i> Please wait..."});
        $(document).ready(function() {
            $(".toggle-accordion").on("click", function() {
                var accordionId = $(this).attr("accordion-id"),
                    numPanelOpen = $(accordionId + ' .collapse.in').length;

                $(this).toggleClass("active");

                // if (numPanelOpen == 0) {
                //     openAllPanels(accordionId);
                // } else {
                    closeAllPanels(accordionId);
                // }
            });

            openAllPanels = function(aId) {
                console.log("setAllPanelOpen");
                $(aId + ' .panel-collapse:not(".in")').collapse('show');
            }
            closeAllPanels = function(aId) {
                console.log("setAllPanelclose");
                $(aId + ' .panel-collapse.in').collapse('hide');
            }

        });


        <?php
        if(isset($_GET)){
            unset($_GET['page']);
            $_GET['next10'] = true;
        }

        ?>

    </script>
</html>
