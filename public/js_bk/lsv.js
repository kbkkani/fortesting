$(document).ready(function () {
    var currentToken = jQuery('meta[name="csrf-token"]').attr('content');

    jQuery.ajax({
        type: 'POST',
        url: '/home/getAllCourses',
        data: {'_token':currentToken,'next10':'true',"instanceID":jQuery("#instanceID").val(),"courseType":jQuery("#courseType").val(),"startDate":jQuery("#startDate").val()},
        //dataType: "json",
        success: function(response){

            var results = jQuery.parseJSON(response);
            if(results.length > 0){
                for (i = 0; i < results.length; ++i) {
                    jQuery('#example tbody').append('<tr><td>'+results[i]["start_date"]+'</td>' +
                        '<td class="type">'+results[i]["type"]+'</td>' +
                        '<td>'+results[i]["timing"]+'</td>' +
                        '<td class="location">'+results[i]["location"]+'</td>' +
                        '<td>'+results[i]["delivery_mothod"]+'</td>' +
                        '<td class="price">'+results[i]["price"]+'</td>' +
                        '<td>'+results[i]["space_available"]+'</td>' +
                        '<td>'+results[i]["enrol_now"]+'</td>' +
                        '</tr>');
                    jQuery(".session_btn").next().addClass("hide");
                    jQuery('[data-toggle="tooltip"]').tooltip();
                }
                jQuery('#example').DataTable();

            } else {

            }
            $.unblockUI();
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });

    jQuery("#searchcourse").click(function(){
        jQuery("#example_wrapper").remove();
        $.ajax({
            type: "POST",
            url: '/home/searchCourses',
            data: {'_token':currentToken,"instanceID":jQuery("#instanceId").val(),"courseType":jQuery("#courseType").find('option:selected').attr('id'),"startDate":jQuery("#startDate").val(),"endDate":jQuery("#endDate").val()},
            cache: false,
            success: function(response) {
                var results = jQuery.parseJSON(response);

                if(results.length > 0){
                    jQuery("#search-results").html("<table id='example' class='table table-striped table-bordered' cellspacing='0' width='100%'><thead><tr><th>Course start date</th><th>Type</th><th>Course timing</th><th>Location</th><th>Delivery Method</th><th>Price</th><th>Spaces available</th><th>Enrol</th></tr></thead><tbody></tbody></table>");
                    for (i = 0; i < results.length; ++i) {
                        jQuery('#example tbody').append('<tr><td>'+results[i]["start_date"]+'</td>' +
                            '<td class="type">'+results[i]["type"]+'</td>' +
                            '<td>'+results[i]["timing"]+'</td>' +
                            '<td class="locaion">'+results[i]["location"]+'</td>' +
                            '<td>'+results[i]["delivery_mothod"]+'</td>' +
                            '<td class="price">'+results[i]["price"]+'</td>' +
                            '<td>'+results[i]["space_available"]+'</td>' +
                            '<td>'+results[i]["enrol_now"]+'</td>' +
                            '</tr>');
                    }
                    jQuery('#example').DataTable();
                    jQuery(".session_btn").next().css("display","none")
                } else {
                    jQuery("#search-results").html("<div class='no-results'>No Results Found</div>");
                }
                $.unblockUI();
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

    $('#group_email').validate({
        rules: {
            ContactEmail: {
                required: true,
                email: true
            }
        },
        submitHandler: function (form) {
            $.blockUI({message: waitmsg});
            var formData = $("#group_email").serialize();
            $.ajax({
                type: "POST",
                url: "/user/groupCourses",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function (data) {
                    console.log("gorup_email:" + JSON.stringify(data));
                    if (data.status == 'success') {
                        $('#group_components').slideUp();
                        $('.group_response').html(' <i class="icon-ok-sign"></i> ' + data.message).fadeIn();
                    }
                    return false;
                },
                error: function (data) {
                    alert('Network error');
                }
            });
        }
    });

    jQuery(".course_info").click(function () {
        $.blockUI({message: waitmsg});
        $.ajax({
            type: "POST",
            url: '/home/getAllCourseInfo',
            data: {'_token':currentToken},
            cache: false,
            success: function(response) {
                var results = jQuery.parseJSON(response);
                for (i = 0; i < results.length; ++i) {
                    jQuery(".courses-panel").show();
                    jQuery(".courses-panel-heading").show();
                    if(results[i]['update_cost'] != ""){
                        var update_course = '<li class="list-group-item" style="font-size: 14px;">Update course: $'+results[i]['update_cost']+' <button data-id="'+results[i]['type_id']+'" class="book_btn btn btn-glow primary btn-xs pull-right" onclick="callsearch(jQuery(this).attr(\'data-id\'))">Book now</button><div class="clearfix"></div></li>';
                    } else {
                        var update_course = '';
                    }
                    var full_course = '<li class="list-group-item" style="font-size: 14px;">Full course: $'+results[i]['cost']+' <button data-id="'+results[i]['info_id']+'" class="book_btn btn btn-glow primary btn-xs pull-right" onclick="callsearch(jQuery(this).attr(\'data-id\'))">Book now</button><div class="clearfix"></div></li>';
                    jQuery('#accordion').append('<div class="panel panel-default">'+
                        '<div class="panel-heading course_type_lbl" data-id="'+results[i]['info_id']+'" role="tab" id="heading-'+results[i]['info_id']+'" data-toggle="collapse" data-parent="false" style="cursor: pointer;" href="#collapse'+results[i]['info_id']+'"><i class="icon-plus pull-right" style="color: #999999;"></i><h5 class="panel-title">'+results[i]['name']+'</h5></div>'+
                        '<div id="collapse'+results[i]['info_id']+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+results[i]['info_id']+'">'+
                        '<div class="panel-body">'+results[i]['short_description']+'</div>' +
                        '<ul>'+full_course+update_course+'</ul></div></div>'
                    );
                }
                jQuery('#example').DataTable();
                $.unblockUI();
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

    function bindCourseTypes(){
        $.blockUI({ message: waitmsg });
        $.ajax({
            type: "GET",
            url: BASE_URL +"/api/courses/coursetypes",
            dataType: 'json',
            cache: false,
            success: function(data) {
                var result = JSON.stringify(data, undefined, 2);
                if(data.status == 'success'){
                    var toAppend = '<option selected value="">Please select</option>';
                    $.each(data.coursetypes,function(i,o){
                        toAppend += '<option value="'+ o.ID+'">'+o.NAME+'</option>';
                    });

                    $('#courseType').empty();
                    $('#courseType').append(toAppend);
                } else {
                    $.unblockUI();
                }
            },
            error: function(data) {
                $.unblock({});
                console.log('Network error');
            }
        });

        return false;
    }

    $(function () {
        $('#startDate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#endDate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dobUser').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });

    $(".toggle_show").click(function () {
        $('.all_courses').toggle();
    });

    $(".group_btn").click(function () {

        $('#groupModal').modal('show');

        $('#Courses').select2();

    });

    $('#create_account').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        console.log("data-course_code:"+button.attr("data-course_code"));
        $("#courseInstanceID").val(button.attr("data-course_code"));
        $('#course-modal').modal("hide");
    });

    $('#create_account').on('hidden.bs.modal', function (e) {
        $(".form-group ").removeClass("has-error");
        $(".req").removeClass("ddl-error");
        $(".help-block ").hide();
        $('#register_acc')[0].reset();
        $("#courseInstanceID").val("");
    });

    $("#register_acc #emailAddress").on("change paste keyup", function() {
        $("#register_acc #username").val($(this).val());
    });

    $('#register_acc').validate({
        rules: {
            emailAddress: {
                email: true
            },
            verifyPassword: {
                equalTo: "#pwd"
            }
        },

        messages: {
            dd: {
                required: ""
            },
            mm: {
                required: ""
            },
            yyyy: {
                required: ""
            }
        },

        submitHandler: function(form) {
            $.blockUI({ message: waitmsg });
            var formData = $("#register_acc").serialize();
            var postType = $("#register_acc").attr('method');
            $.ajax({
                type: postType,
                url:"/user/register",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function(data) {
                    console.log("register:" + JSON.stringify(data));
                    if(data.status == 'success'){
                        var courseid = $("#courseInstanceID").val(); // click on enrol with existing account
                        if(courseid == ""){
                            courseid = getQueryString("courseid"); // instanceid in URL
                        }
                        if(courseid != ""){
                            window.location.href="/enrolment/course/" +courseid;
                        }else{
                            window.location.href="/mylearning";
                        }
                    } else {
                        $('#register_acc').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                    }
                    return false;
                },

                error: function(data) {
                    alert('Network error');
                }
            });
        }
    });

    $(".contact_btn").click(function() {
        $('#contact_us').modal('show');
    });

    $('#formlogin').validate({
        rules: {
            username: {
                required:true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Please enter Username"
            },
            password: {
                required: "Please enter Password"
            }
        },
        submitHandler: function(form) {
            $.blockUI({ message: waitmsg });
            var formData = $("#formlogin").serialize();
            $.ajax({
                type: "POST",
                url: "/user/login",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function(data) {
                    console.log("login:" + JSON.stringify(data));
                    if(data.status == 'success'){
                        var courseid = getQueryString("courseid");
                        if(courseid != ""){
                            window.location.href="/enrolment/course/" +courseid;
                        }else{
                            window.location.href="/mylearning";
                        }
                    } else {
                        var msg= data.message;
                        if(msg.toLowerCase() == "you must change your password"){
                            $("#reset_password").modal('show');
                            console.log($("#username").val());
                            $('#reset_pw').find('#username').val($('#formlogin').find("#username").val());
                            $('#reset_pw').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                        }else{
                            $('#formlogin').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                        }
                    }
                    return false;
                },
                error: function(data) {
                    alert('Invalid Login');
                }
            });
        }
    });

    $(".reset_btn").click(function() {
        var formID = $(this).attr('formid');
        var formData = $("#" + formID).serialize();
        var postType = $("#" + formID).attr('method');

        $.ajax({
            type: "POST",
            url: "/user/requestPassword",
            dataType: 'json',
            cache: false,
            data: formData,
            success: function(data) {
                var result = JSON.stringify(data, undefined, 2);
                if(data.status == 'success'){
                    $('#'+formID).find('.response').hide().html('<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + data.message + '</div>').fadeIn();
                } else {
                    $('#'+formID).find('.response').hide().html('<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i> ' + data.message + '</div>').fadeIn();
                }
            },

            error: function(data) {
                alert('Network error');
            }
        });

        return false;
    });

    $('#forgot_password').on('hidden.bs.modal', function (e) {
        $(".form-group ").removeClass("has-error");
        $(".req").removeClass("ddl-error");
        $(".help-block ").hide();
        $('#forgot_password').find('.response').html('');
        $('#forgot_pw')[0].reset();
    });

    $('#dvforgot_username').on('hidden.bs.modal', function (e) {
        $(".form-group ").removeClass("has-error");
        $(".req").removeClass("ddl-error");
        $(".help-block ").hide();
        $('#forgot_username')[0].reset();
        $('#forgot_username').find('.response').html('');
    });

    $('#forgot_username').validate({
        rules: {
            email: {
                email: true
            }
        },
        submitHandler: function(form) {
            $.blockUI({ message: waitmsg });
            var formData = $("#forgot_username").serialize();
            $.ajax({
                type: 'POST',
                url: "/user/requestUsername",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function(data) {
                    if(data.status == 'success'){
                        $('#forgot_username').find('.response').hide().html(alertMessage('status',data.message)).fadeIn();
                    } else {
                        $('#forgot_username').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                    }
                    return false;
                },
                error: function(data) {
                    alert('Network error');
                }
            });
        }
    });

    $('#validate_cert').validate({
        submitHandler: function(form) {
            $.blockUI({ message: waitmsg });
            var formData = $("#validate_cert").serialize();
            $.ajax({
                type: 'POST',
                url: "/user/validateCert",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function(data) {
                    if(data.status == 'success'){
                        var form=formData.split("&");
                        var results = data.results;
                        results = results.DOCUMENT;
                        results = results.DETAIL;
                        var givenname=results.GIVENNAME;
                        var surname=results.SURNAME;
                        if(givenname.toLowerCase()===((form[0].split("="))[1]).toLowerCase() && surname.toLowerCase()===((form[1].split("="))[1]).toLowerCase()){
                            $('.cert_btn').hide();
                            $('#validate_cert').find('.response').hide().html(alertMessage('status',data.message)).fadeIn();
                        }else{
                            $('#validate_cert').find('.response').hide().html(alertMessage('error',"No record found, please contact us via email: training@lsv.com.au or phone: (03) 9676 6950")).fadeIn();
                        }
                    } else {
                        $('#validate_cert').find('.response').hide().html(alertMessage('error',data.message)).fadeIn();
                    }
                    return false;
                },
                error: function(data) {
                    alert('Network error');
                }
            });
        }
    });

});

function callsearch (dataId) {
    jQuery("#courseType option[id='" + dataId + "']").attr('selected', 'selected');
    jQuery("#searchcourse").trigger("click");
}

function getQueryString(key)
{
    var queries = {};
    var isvalue = true;
    $.each(document.location.search.substr(1).split('&'), function(c,q){
        if(q.length > 0){
            var i = q.split('=');
            queries[i[0].toString()] = i[1].toString();
        }else{
            isvalue = false;
            return;
        }
    });
    if(isvalue){
        if(queries.hasOwnProperty(key))
            return queries[key];
        else
            return "";
    }else{
        return "";
    }
}

function alertMessage(type,message){
    var html="";
    switch (type){
        case 'error':
            html='<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i> ' + message + '</div>';
            break;
        case 'status':
            html='<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + message + '</div>';
            break;
        default :
            html='<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + message + '</div>';
            break;

    }

    return html;
}