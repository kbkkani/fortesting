@extends('mylearning')
@section('content')
    <?php
    $active_myaccount = true;

    $user_details = $user;
    ?>
    <div class="content">
        <div class="">
            <div id="pad-wrapper" class="user-profile">
                <!-- header -->
                <div class="row">
                    <div class="col-xs-10 col-sm-8 col-md-8 profile-head">
                        <img src="{{asset('img/avatar.png')}}" class="avatar img-circle" />
                        <h3 id="name"><?php echo ($user_details['GIVENAME']. " ". $user_details['SURNAME'] . "&nbsp;(".$user_details['CONTACTID'].")"); ?></h3>
                        <span id="dob" class="area"></span>
                    </div>
                </div>
                <div class="clear"></div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title up-head"><!--new class-->
                                <i class="icon-lock"></i> Update password</h3>
                            </div>
                            <div class="panel-body">
                                <form method="post" id="update_password" action="">
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>Enter current password</label>
                                            <input class="form-control" type="password" name="oldPassword" value="" />
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6 form-group-wrap">
                                            <label>New password</label>
                                            <input class="form-control" type="password" name="newPassword" id="newPassword" />
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6 form-group-wrap">
                                            <label>Verify new password</label>
                                            <input class="form-control" type="password" name="verifyPassword" />
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6 form-group-wrap">
                                            <label class="col-xs-12">&nbsp;</label>
                                            <button class="btn-glow primary submit_btn" formid="update_password">Update password</button>
                                        </div>

                                        <input type="hidden" value="<?php echo $user_details["USERNAME"]; ?>" name="username">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                                    </div>
                                    <div class="row ">
                                        <div class="response"></div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            //start User Profile
            var userID= "<?php echo $user_details["USERID"] ;?>";
            getUserDetails(userID,"account");

            // End User Profile
            // Start Update Email
            $('#update_email').validate({
                rules: {

                    newEmail: {
                        required: true,
                        email: true
                    },
                    verifyEmail: {
                        equalTo: "#newEmail"
                    }


                },
                submitHandler: function(form) {
                    $.blockUI({ message: waitmsg });
                    var formData = $("#update_email").serialize();
                    var postType = $("#update_email").attr('method');
                    $.ajax({
                        type: postType,
                        url: "/api/user/updateEmail",
                        dataType: 'json',
                        cache: false,
                        data: formData,
                        success: function(data) {
                            var result = JSON.stringify(data, undefined, 2);
                            if(data.status == 'success'){
                                $('#update_email')[0].reset();
                                $('#update_email').find('.response').hide().html(alertMessage('status',data.message)).fadeIn();
                            } else {
                                $('#update_email').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                            }
                            return false;
                        },
                        error: function(data) {
                            alert('Network error');
                        }

                    });

                }
            });
            // End Update Email

            // Start Update Email
            var frm_update_password = $("#update_password");
            frm_update_password.validate({
                rules: {

                    oldPassword: {
                        required: true
                    },
                    newPassword: {
                        required: true
                    },
                    verifyPassword: {
                        equalTo: "#newPassword"
                    }
                },
                submitHandler: function(form) {
                    $.blockUI({ message: waitmsg });
                    var formData = frm_update_password.serialize();
                    var postType = frm_update_password.attr('method');
                    $.ajax({
                        type: "post",
                        url: "/user/updatePassword",
                        dataType: 'json',
                        cache: false,
                        data: formData,
                        success: function(data) {
                            var result = JSON.stringify(data, undefined, 2);
                            if(data.status == 'success'){
                                frm_update_password[0].reset();
                                frm_update_password.find('.response').hide().html(alertMessage('status',data.message)).fadeIn();
                            } else {
                                frm_update_password.find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                            }
                            return false;
                        },
                        error: function(data) {
                            alert('Network error');
                        }
                    });
                }
            });
            // End Update Email
        });
    </script>

@stop