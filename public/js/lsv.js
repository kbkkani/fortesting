var BASE_URL = "http://www.training-master.com";

$(document).ready(function () {
    var currentToken = jQuery('meta[name="csrf-token"]').attr('content');
    if (window.location.href.indexOf("mylearning") == -1 && window.location.href.indexOf("groupCourses") == -1) {
        jQuery.ajax({
            type: 'POST',
            url: '/home/getAllCourses',
            data: {
                '_token': currentToken,
                'next10': 'true',
                "instanceID": jQuery("#instanceID").val(),
                "courseType": jQuery("#courseType").val(),
                "startDate": jQuery("#startDate").val()
            },
            //dataType: "json",
            success: function (response) {

                var results = jQuery.parseJSON(response);
                if (results.length > 0) {
                    for (i = 0; i < results.length; ++i) {
                        jQuery('#example tbody').append('<tr><td>' + results[i]["start_date"] + '</td>' +
                            '<td class="type">' + results[i]["type"] + '</td>' +
                            '<td>' + results[i]["timing"] + '</td>' +
                            '<td class="locaion"><a href="https://www.google.com/maps/dir/' + jQuery(results[i]["location"]).text().trim() + '" target="_blank"><img src="../img/map_marke.png" /></a> &nbsp;' + results[i]["location"] + '</td>' +
                            '<td>' + results[i]["delivery_mothod"] + '</td>' +
                            '<td class="price">' + results[i]["price"] + '</td>' +
                            '<td>' + results[i]["space_available"] + '</td>' +
                            '<td>' + '<a href="/mylearning/courses/"' + results[i]["instance_id"] + ' style="min-width:110px" data-toggle="modal" data-target="#course-modal" class="btn-glow primary enrolnow_btn"><i class="icon-share-alt"></i> Enrol Now</a><div class="group_courses_control hide"><input type="checkbox" name="group[' + results[i]["instance_id"] + ']" value="' + results[i]["id"] + '" /></div>' + '</td>' +
                            '</tr>');
                        jQuery(".session_btn").next().addClass("hide");
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    }
                    jQuery('#example').DataTable();

                } else {

                }
                $.unblockUI();
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    jQuery("#searchcourse").click(function () {
        jQuery("#example_wrapper").remove();
        $.ajax({
            type: "POST",
            url: '/home/searchCourses',
            data: {
                '_token': currentToken,
                "instanceID": jQuery("#instanceId").val(),
                "courseType": jQuery("#courseType").find('option:selected').attr('id'),
                "startDate": jQuery("#startDate").val(),
                "endDate": jQuery("#endDate").val()
            },
            cache: false,
            success: function (response) {
                var results = jQuery.parseJSON(response);

                if (results.length > 0) {
                    jQuery("#search-results").html("<table id='example' class='table table-striped table-bordered' cellspacing='0' width='100%'><thead><tr><th>Course start date</th><th>Type</th><th>Course timing</th><th>Location</th><th>Delivery Method</th><th>Price</th><th>Spaces available</th><th>Enrol</th></tr></thead><tbody></tbody></table>");
                    for (i = 0; i < results.length; ++i) {
                        jQuery('#example tbody').append('<tr><td>' + results[i]["start_date"] + '</td>' +
                            '<td class="type">' + results[i]["type"] + '</td>' +
                            '<td>' + results[i]["timing"] + '</td>' +
                            '<td class="locaion"><a href="https://www.google.com/maps/dir/' + jQuery(results[i]["location"]).text().trim() + '" target="_blank"><img src="../img/map_marke.png" /></a> &nbsp;' + results[i]["location"] + '</td>' +
                            '<td>' + results[i]["delivery_mothod"] + '</td>' +
                            '<td class="price">' + results[i]["price"] + '</td>' +
                            '<td>' + results[i]["space_available"] + '</td>' +
                            '<td>' + '<a href="/mylearning/courses/' + results[i]["instance_id"] +
                            '" style="min-width:110px" class="btn-glow primary enrolnow_btn"><i class="icon-share-alt"></i> Enrol Now</a><div class="group_courses_control hide"><input type="checkbox" name="group[' + results[i]["instance_id"] + ']" value="' + results[i]["id"] + '" onclick="addtoGroup(this)" /></div>' + '</td>' +
                            '</tr>');
                    }
                    jQuery('#example').DataTable();
                    jQuery(".session_btn").next().css("display", "none");
                    jQuery('[data-toggle="tooltip"]').tooltip();
                } else {
                    jQuery("#search-results").html("<div class='no-results'>No Results Found</div>");
                }
                $.unblockUI();
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
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

    $(".registration_list").click(function () {
        var formID = $(this).attr('formid');
        var formData = $("#" + formID).serialize();
        var contactId = $('.registration_list').attr('data-contactid')
        $.blockUI({message: waitmsg});
        $.ajax({
            type: "GET",
            url: "/mylearning/userEnrolment/" + contactId,
            dataType: 'json',
            cache: false,
            data: formData,
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    jQuery("#complete_reg").hide();
                    jQuery("#current_reg").show();
                    var userEnrolments = data.enrolments;
                    $(".dashboard a").removeClass("active");
                    $(".dashboard a").css("background", "none");
                    var certNotification = '<div class="alert alert-warning"><i class="icon-warning-sign"></i><strong>No enrolments</strong><br/>You are currently not enrolled to any courses</p></div>';
                    if (data.enrolments == null) {
                        $('#current_reg').html(certNotification);
                    } else {
                        $('#current_reg').html(userEnrolments);
                    }
                    $('#search_panel').hide();

                } else {
                    $.unblockUI();
                    alert(data.message);
                }
            },
            error: function (data) {
                $.unblockUI();
                alert('Network error please try again.');
            }
        });
    });

    jQuery(".course_info").click(function () {
        $.blockUI({message: waitmsg});
        $.ajax({
            type: "POST",
            url: '/home/getAllCourseInfo',
            data: {'_token': currentToken},
            cache: false,
            success: function (response) {
                var results = jQuery.parseJSON(response);
                for (i = 0; i < results.length; ++i) {
                    jQuery(".courses-panel").show();
                    jQuery(".courses-panel-heading").show();
                    if (results[i]['update_cost'] != "") {
                        var update_course = '<li class="list-group-item" style="font-size: 14px;">Update course: $' + results[i]['update_cost'] + ' <button data-id="' + results[i]['type_id'] + '" class="book_btn btn btn-glow primary btn-xs pull-right" onclick="callsearch(jQuery(this).attr(\'data-id\'))">Book now</button><div class="clearfix"></div></li>';
                    } else {
                        var update_course = '';
                    }
                    var full_course = '<li class="list-group-item" style="font-size: 14px;">Full course: $' + results[i]['cost'] + ' <button data-id="' + results[i]['info_id'] + '" class="book_btn btn btn-glow primary btn-xs pull-right" onclick="callsearch(jQuery(this).attr(\'data-id\'))">Book now</button><div class="clearfix"></div></li>';
                    jQuery('#accordion').append('<div class="panel panel-default">' +
                        '<div class="panel-heading course_type_lbl" data-id="' + results[i]['info_id'] + '" role="tab" id="heading-' + results[i]['info_id'] + '" data-toggle="collapse" data-parent="false" style="cursor: pointer;" href="#collapse' + results[i]['info_id'] + '"><i class="icon-plus pull-right" style="color: #999999;"></i><h5 class="panel-title">' + results[i]['name'] + '</h5></div>' +
                        '<div id="collapse' + results[i]['info_id'] + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-' + results[i]['info_id'] + '">' +
                        '<div class="panel-body">' + results[i]['short_description'] + '</div>' +
                        '<ul>' + full_course + update_course + '</ul></div></div>'
                    );
                }
                jQuery('#example').DataTable();
                $.unblockUI();
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

    function bindCourseTypes() {
        $.blockUI({message: waitmsg});
        $.ajax({
            type: "GET",
            url: BASE_URL + "/api/courses/coursetypes",
            dataType: 'json',
            cache: false,
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    var toAppend = '<option selected value="">Please select</option>';
                    $.each(data.coursetypes, function (i, o) {
                        toAppend += '<option value="' + o.ID + '">' + o.NAME + '</option>';
                    });

                    $('#courseType').empty();
                    $('#courseType').append(toAppend);
                } else {
                    $.unblockUI();
                }
            },
            error: function (data) {
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
        console.log("data-course_code:" + button.attr("data-course_code"));
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

    $("#register_acc #emailAddress").on("change paste keyup", function () {
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

        submitHandler: function (form) {
            $.blockUI({message: waitmsg});
            var formData = $("#register_acc").serialize();
            var postType = $("#register_acc").attr('method');
            $.ajax({
                type: postType,
                url: "/user/register",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function (data) {
                    console.log("register:" + JSON.stringify(data));
                    if (data.status == 'success') {
                        var courseid = $("#courseInstanceID").val(); // click on enrol with existing account
                        if (courseid == "") {
                            courseid = getQueryString("courseid"); // instanceid in URL
                        }
                        if (courseid != "") {
                            window.location.href = "/enrolment/course/" + courseid;
                        } else {
                            window.location.href = "/mylearning";
                        }
                    } else {
                        $('#register_acc').find('.response').hide().html(alertMessage('error', data.message)).fadeIn();
                    }
                    return false;
                },

                error: function (data) {
                    alert('Network error');
                }
            });
        }
    });

    $(".contact_btn").click(function () {
        $('#contact_us').modal('show');
    });

    $('#formlogin').validate({
        rules: {
            username: {
                required: true
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
        submitHandler: function (form) {
            $.blockUI({message: waitmsg});
            var formData = $("#formlogin").serialize();
            $.ajax({
                type: "POST",
                url: "/user/login",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function (data) {
                    console.log("login:" + JSON.stringify(data));
                    if (data.status == 'success') {
                        var courseid = getQueryString("courseid");
                        if (courseid != "") {
                            window.location.href = "/enrolment/course/" + courseid;
                        } else {
                            window.location.href = "/mylearning";
                        }
                    } else {
                        var msg = data.message;
                        if (msg.toLowerCase() == "you must change your password") {
                            $("#reset_password").modal('show');
                            console.log($("#username").val());
                            $('#reset_pw').find('#username').val($('#formlogin').find("#username").val());
                            $('#reset_pw').find('.response').hide().html(alertMessage('error', data.message)).fadeIn();
                        } else {
                            $('#formlogin').find('.response').hide().html(alertMessage('error', data.message)).fadeIn();
                        }
                    }
                    return false;
                },
                error: function (data) {
                    alert('Invalid Login');
                }
            });
        }
    });

    $(".reset_btn").click(function () {
        var formID = $(this).attr('formid');
        var formData = $("#" + formID).serialize();
        var postType = $("#" + formID).attr('method');

        $.ajax({
            type: "POST",
            url: "/user/requestPassword",
            dataType: 'json',
            cache: false,
            data: formData,
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    $('#' + formID).find('.response').hide().html('<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + data.message + '</div>').fadeIn();
                } else {
                    $('#' + formID).find('.response').hide().html('<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i> ' + data.message + '</div>').fadeIn();
                }
            },

            error: function (data) {
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
        submitHandler: function (form) {
            $.blockUI({message: waitmsg});
            var formData = $("#forgot_username").serialize();
            $.ajax({
                type: 'POST',
                url: "/user/requestUsername",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function (data) {
                    if (data.status == 'success') {
                        $('#forgot_username').find('.response').hide().html(alertMessage('status', data.message)).fadeIn();
                    } else {
                        $('#forgot_username').find('.response').hide().html(alertMessage('error', data.message)).fadeIn();
                    }
                    return false;
                },
                error: function (data) {
                    alert('Network error');
                }
            });
        }
    });

    $('#validate_cert').validate({
        submitHandler: function (form) {
            $.blockUI({message: waitmsg});
            var formData = $("#validate_cert").serialize();
            $.ajax({
                type: 'POST',
                url: "/user/validateCert",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function (data) {
                    if (data.status == 'success') {
                        var form = formData.split("&");
                        var results = data.results;
                        results = results.DOCUMENT;
                        results = results.DETAIL;
                        var givenname = results.GIVENNAME;
                        var surname = results.SURNAME;
                        if (givenname.toLowerCase() === ((form[0].split("="))[1]).toLowerCase() && surname.toLowerCase() === ((form[1].split("="))[1]).toLowerCase()) {
                            $('.cert_btn').hide();
                            $('#validate_cert').find('.response').hide().html(alertMessage('status', data.message)).fadeIn();
                        } else {
                            $('#validate_cert').find('.response').hide().html(alertMessage('error', "No record found, please contact us via email: training@lsv.com.au or phone: (03) 9676 6950")).fadeIn();
                        }
                    } else {
                        $('#validate_cert').find('.response').hide().html(alertMessage('error', data.message)).fadeIn();
                    }
                    return false;
                },
                error: function (data) {
                    alert('Network error');
                }
            });
        }
    });

    $(".result_list").click(function () {
        var formID = $(this).attr('formid');
        var formData = $("#" + formID).serialize();
        $.blockUI({message: waitmsg});
        $.ajax({
            type: "GET",
            url: "/mylearning/myResults/" + $('.result_list').attr('data-contactid'),
            dataType: 'json',
            cache: false,
            data: formData,
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    jQuery("#current_reg").hide();
                    jQuery("#complete_reg").show();
                    var certNotification = '<div class="alert alert-warning"><i class="icon-warning-sign"></i><strong>Important Information</strong><br/>Certificates issued before 25/02/2015 can be requested directly from your state branch office - please use the Contact Us link on the top right of the screen to reach us.</p></div>';
                    if (data.enrolmentsComplete != null) {
                        var userEnrolments = data.enrolmentsComplete;
                    } else {
                        var userEnrolments = '';
                    }

                    $('#complete_reg').html(certNotification + '<br/>' + userEnrolments);

                } else {
                    $.unblockUI();
                    alert(data.message);
                }
            },
            error: function (data) {
                $.unblockUI();
                alert('Network error please try again.');
            }
        });
    });

    $("#update_status").click(function () {
        var data = $('input:checkbox');
        obj = {};
        var hidden = $('input:hidden');
        for (var i = 0; i < data.length; i++) {
            obj[data[i].name] = obj[data[i].name] || [];
            if (data[i].checked) {
                obj[data[i].name] = 1;
            } else {
                obj[data[i].name] = 0;
            }
        }
        obj["_token"] = currentToken;

        $.ajax({
            type: "POST",
            url: "/admin/updateType",
            dataType: 'json',
            cache: false,
            data: obj,
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    location.reload();
                }
            },

            error: function (data) {
                alert('Network error');
            }
        });

        return false;
    });

    $("#create_group_course").click(function () {
        var title = $('#title').val();
        jsonObj = [];
        obj = {};
        obj["title"] = title;
        obj["_token"] = currentToken;
        jsonObj.push(obj);
        $.ajax({
            type: "POST",
            url: "/admin/submitGroupForm/",
            dataType: 'json',
            cache: false,
            data: jsonObj[0],
            success: function (data) {
                var result = JSON.stringify(data, undefined, 2);
                if (data.status == 'success') {
                    alert("Successfully Group Created");
                    location.reload();
                }
            },

            error: function (data) {
                alert('Network error');
            }
        });
    });

});

function callsearch(dataId) {
    jQuery("#courseType option[id='" + dataId + "']").attr('selected', 'selected');
    jQuery("#searchcourse").trigger("click");
}

function getQueryString(key) {
    var queries = {};
    var isvalue = true;
    $.each(document.location.search.substr(1).split('&'), function (c, q) {
        if (q.length > 0) {
            var i = q.split('=');
            queries[i[0].toString()] = i[1].toString();
        } else {
            isvalue = false;
            return;
        }
    });
    if (isvalue) {
        if (queries.hasOwnProperty(key))
            return queries[key];
        else
            return "";
    } else {
        return "";
    }
}

function alertMessage(type, message) {
    var html = "";
    switch (type) {
        case 'error':
            html = '<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i> ' + message + '</div>';
            break;
        case 'status':
            html = '<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + message + '</div>';
            break;
        default :
            html = '<div class="alert alert-success" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-ok-sign"></i> ' + message + '</div>';
            break;

    }

    return html;
}

function getUserDetails(userID, page_name) {
    $.blockUI({message: waitmsg});
    $.ajax({
        type: "GET",
        url: "/user/profile/" + userID,
        dataType: 'json',
        cache: false,
        success: function (data) {
            var result = JSON.stringify(data, undefined, 2);
            if (data.status == 'success') {
                var contactDetails = data.contactDetails;
                var userDetails = data.userDetails;
                if (page_name == "account") {
                    if (contactDetails && !contactDetails.ERROR) {
                        $("#name").text(contactDetails.GIVENNAME + " " + contactDetails.SURNAME + " (" + contactDetails.CONTACTID + ")");

                        if (contactDetails.DOB && contactDetails.DOB != "") {
                            var dob = contactDetails.DOB.split("-");
                            $("#dob").text("Date of birth: " + dob[2] + "/" + dob[1] + "/" + dob[0]);
                            console.log(contactDetails);
                            $("#oldemail").val(contactDetails.EMAILADDRESS);
                        }
                    }
                } else if (page_name == "enrolment") {
                    if (userDetails && !userDetails.ERROR) {
                        //$("#username").val(userDetails.USERNAME);
                    }

                    if (contactDetails && !contactDetails.ERROR) {
                        $("#givenName").val(contactDetails.GIVENNAME);
                        $("#surname").val(contactDetails.SURNAME);
                        $("#emailAddress").val(contactDetails.EMAILADDRESS);
                        $("#title").val(contactDetails.TITLE);
                        $("#sex").val(contactDetails.SEX);
                        $("#buildingName").val(contactDetails.BUILDINGNAME);
                        $("#unitNo").val(contactDetails.UNITNO);
                        $("#streetNo").val(contactDetails.STREETNO);
                        $("#streetName").val(contactDetails.STREETNAME);
                        $("#city").val(contactDetails.CITY);
                        $("#state").val(contactDetails.STATE);
                        $("#postcode").val(contactDetails.POSTCODE);

                        $("#phone").val(contactDetails.PHONE);
                        $("#mobilephone").val(contactDetails.MOBILEPHONE);
                        $("#workphone").val(contactDetails.WORKPHONE);
                        $("#sunitNo").val(contactDetails.SUNITNO);

                        function diff_years(dt2, dt1) {
                            var diff = (dt2.getTime() - dt1.getTime()) / 1000;
                            diff /= (60 * 60 * 24);
                            return Math.abs(Math.round(diff / 365.25));
                        }

                        if (contactDetails.DOB && contactDetails.DOB != "") {
                            var dob = contactDetails.DOB.split("-");
                            var dateq = dob[2] + "/" + dob[1] + "/" + dob[0];
                            //calculate age
                            var date1 = new Date(dateq);
                            var date2 = new Date();
                            var age = diff_years(date1, date2);
                            $("#dob").val(dob[2] + "/" + dob[1] + "/" + dob[0]);
                            if (age <= 18) {
                                $("#emstat").val("Y");
                                $("#parent").show();
                                $("#fsn").addClass("req");
                                $("#fcn").addClass("req");
                                $("#relst").addClass("req");
                                $("#emcn").addClass("req");
                                var fname;
                                var lname;

                                if (contactDetails.EMERGENCYCONTACT != null && contactDetails.EMERGENCYCONTACT != "") {
                                    fname = (contactDetails.EMERGENCYCONTACT).split(' ').slice(0, -1).join(' ');
                                    lname = (contactDetails.EMERGENCYCONTACT).split(' ').slice(-1).join(' ');
                                }
                                $("#fcnfull").val(contactDetails.EMERGENCYCONTACT)
                                $("#fcn").val(fname);
                                $("#fsn").val(lname);
                                $("#emcn").val(contactDetails.EMERGENCYCONTACTPHONE);
                                $("#relst").val(contactDetails.EMERGENCYCONTACTRELATION);
                            }
                        }

                        //postal address
                        $('[name="POBox"]').val(contactDetails.POBOX);
                        $('[name="sbuildingName"]').val(contactDetails.SBUILDINGNAME);
                        $('[name="sstreetNo"]').val(contactDetails.SSTREETNO);
                        $('[name="sstreetName"]').val(contactDetails.SSTREETNAME);
                        $('[name="scity"]').val(contactDetails.SCITY);
                        $('[name="sstate"]').val(contactDetails.SSTATE);
                        $('[name="spostcode"]').val(contactDetails.SPOSTCODE);
                        $('[name="sPOBox"]').val(contactDetails.POBOX);

                        //background
                        if (contactDetails.COUNTRYOFBIRTHID != "1101") {
                            var COUNTRYOFBIRTHID = "No";
                            var COUNTRYOFBIRTHID2 = contactDetails.COUNTRYOFBIRTHID;
                        } else {
                            var COUNTRYOFBIRTHID = "1101";
                        }
                        $("#CountryofBirthID").val(COUNTRYOFBIRTHID);
                        if ($("#CountryofBirthID").val() == "1101") {
                            $("#CountryofBirthID2").val();
                            $("#CountryofBirthID2").select2('disable');
                        } else {
                            $("#CountryofBirthID2").select2("destroy");
                            $("#CountryofBirthID2").val(COUNTRYOFBIRTHID2);
                            $("#CountryofBirthID2").select2();
                            $("#CountryofBirthID2").select2('enable');
                        }

                        $("#CountryofBirthID").on('change', function (e) {
                            var optionSelected = $("option:selected", this);
                            if (this.value == "No") {
                                $("#CountryofBirthID2").select2('enable');
                            } else {
                                $("#CountryofBirthID2").val();
                                $("#CountryofBirthID2").select2("destroy");
                                $("#CountryofBirthID2").select2('disable');
                            }
                        });

                        $('[name="IndigenousStatusID"]').val(contactDetails.INDIGENOUSSTATUSID);

                        if (contactDetails.MAINLANGUAGEID != "1201") {
                            var MainLanguageID = "Yes";
                            var MainLanguageID2 = contactDetails.MAINLANGUAGEID;
                        } else {
                            var MainLanguageID = "1201";
                            var MainLanguageID2 = "";
                        }
                        $("#MainLanguageID").val(MainLanguageID);
                        if ($("#MainLanguageID").val() != "1201") {
                            $("#MainLanguageID2").val(MainLanguageID2);
                            $("#MainLanguageID2").select2();
                            $("#MainLanguageID2").select2('enable');
                        } else {
                            $("#MainLanguageID2").val();
                            $("#MainLanguageID2").select2("destroy");
                            $("#MainLanguageID2").select2();
                            $("#MainLanguageID2").select2('disable');

                        }
                        $("#MainLanguageID").on('change', function (e) {
                            var optionSelected = $("option:selected", this);
                            if (this.value == "Yes") {
                                $("#MainLanguageID2").select2();
                                $("#MainLanguageID2").select2('enable');
                            } else {
                                $("#MainLanguageID2").val();
                                $("#MainLanguageID2").select2("destroy");
                                $("#MainLanguageID2").select2();
                                $("#MainLanguageID2").select2('disable');
                            }
                        });
                        console.log(contactDetails.MAINLANGUAGEID);

                        $('[name="EnglishProficiencyID"]').val(contactDetails.ENGLISHPROFICIENCYID);
                        $('[name="DisabilityTypeID"]').val(contactDetails.DISABILITYTYPEIDS);
                        var DISABILITYFLAG = contactDetails.DISABILITYFLAG == true ? "1" : "0";
                        $('[name="DisabilityFlag"]').val(DISABILITYFLAG);

                        $.each($("#DisabilityTypeID"), function () {
                            $(this).select2('val', contactDetails.DISABILITYTYPEIDS);
                        });
                        //Education
                        $('[name="USI"]').val(contactDetails.USI);
                        $('[name="HighestSchoolLevelID"]').val(contactDetails.HIGHESTSCHOOLLEVELID);
                        $('[name="HighestSchoolLevelYear"]').val(contactDetails.HIGHESTSCHOOLLEVELYEAR);
                        var AtSchoolFlag = contactDetails.ATSCHOOLFLAG == true ? "true" : "false";
                        $('[name="AtSchoolFlag"]').val(AtSchoolFlag);
                        $.each($("#PriorEducationID"), function () {
                            $(this).select2('val', contactDetails.PRIOREDUCATIONIDS);
                        });
                        $('[name="LabourForceID"]').val(contactDetails.LABOURFORCEID);
                    }
                }
            } else {
                $.unblockUI();
                alert(data.message);
            }
            return false;
        },
        error: function (data) {
            $.unblockUI();
            alert('Network error');
        }
    });
}

function addtoGroup(data) {
    $.blockUI({message: waitmsg});
    $.ajax({
        type: "GET",
        url: "/admin/createGroupCourses/" + data.value,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.status == 'success') {
                $("#group-course-results").show();
                var results = jQuery.parseJSON(data.results);
                jQuery('#groupCourse tbody').append('<tr id="row' + results[0]["id"] + '"><td>' + results[0]["instance_id"] + '</td>' +
                    '<td class="type">' + results[0]["type"] + '</td>' +
                    '<td class="type">' + results[0]["price"] + '</td>' +
                    '<td>' + '<a onclick="deleteGroupItem(' + results[0]['id'] + ',' + data.group_id + ')" style="min-width:110px" data-toggle="modal" data-target="#course-modal">Delete</a>' + '</td>' +
                    '</tr>');
                $.unblockUI();
            }
        }
    })
}

function deleteGroupItem(id, group_id) {
    $.blockUI({message: waitmsg});
    $.ajax({
        type: "GET",
        url: "/admin/deleteGroupItem/" + id + "/" + group_id,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.status == 'success') {
                $("#row" + id).remove();
            }
            $.unblockUI();
        }
    })
}