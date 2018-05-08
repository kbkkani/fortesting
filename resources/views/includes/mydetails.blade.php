@extends('mylearning')
@section('content')
<?php
$user_details = $user;
?>
<div class="content">
    <div class="">
        <div id="pad-wrapper" class="user-profile">
            <div class="row">
                <div class="col-md-12">
                    <form id="detail-form" method="post">
                        <!-- Basic Information -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-pencil" id="icon-basic-information"></i> Basic information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Full/legal First Name<span>*</span></label>
                                        <input class="form-control req" type="text" id="givenName" name="givenName" value="<?php echo $user_details['GIVENAME'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Full/legal Surname<span>*</span></label>
                                        <input class="form-control req" type="text" id="surname" name="surname" readonly value="<?php echo $user_details['SURNAME'] ?>">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Email<span>*</span></label>
                                        <input class="form-control req" type="text" id="emailAddress" name="emailAddress" readonly>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Title<span>*</span></label> 

                                        <select name="title" id="title" class="form-control req">
                                            <option value="">Please select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Mrs">Miss</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Dr">Dr</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Sex<span>*</span></label>

                                        <select name="sex" id="sex" class="form-control req">
                                            <option value="">Please select</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Date of birth<span>*</span></label>
                                        <input type="text" class="form-control req" id="dob" name="dob" readonly value="<?php //echo date("d/m/Y", strtotime($user["dob"])); ?>" >
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Basic Information -->

                        <!-- Personal Address -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-envelope" id="icon-personal-address"></i> Personal address</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Building/property name</label>
                                        <input class="form-control" name="buildingName" id="buildingName"  type="text">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Unit/flat details</label>
                                        <input class="form-control" name="unitNo" id="unitNo" type="text">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Street number<span>*</span></label>
                                        <input class="form-control req" type="text" name="streetNo" id="streetNo">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Street name<span>*</span></label>
                                        <input class="form-control req" type="text" name="streetName" id="streetName">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>City<span>*</span></label>
                                        <input class="form-control req" type="text" id="city" name="city" >
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>State<span>*</span></label>

                                        <select name="state" id="state" class="form-control req">
                                            <option selected="selected" value="">Please select</option>
                                            <option  value="VIC">VIC</option>
                                            <option value="NSW">NSW</option>
                                            <option value="QLD">QLD</option>
                                            <option value="WA">WA</option>
                                            <option value="SA">SA</option>
                                            <option value="NT">NT</option>
                                            <option value="TAS">TAS</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Postcode<span>*</span></label>
                                        <input class="form-control req" type="text"  id="postcode" name="postcode" maxlength="4" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End Personal Address ->

                        <!-- Postal Address -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-envelope-open" id="icon-postal-address"></i> Postal address</h3>
                            </div>
                            <div class="panel-body">

                                <div class="postal-details" >
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>PO Box (if applicable)</label>
                                            <input class="form-control" type="text" name="POBox">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>Building/property name</label>
                                            <input class="form-control" type="text" name="sbuildingName">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>Street number<span>*</span></label>
                                            <input class="form-control req" type="text" name="sstreetNo" >
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>Street name<span>*</span></label>
                                            <input class="form-control req" type="text" name="sstreetName" >
                                        </div>
                                         <div class="form-group col-lg-3 col-md-6">
                                            <label>City<span>*</span></label>
                                            <input class="form-control req" type="text" name="scity" >
                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>State<span>*</span></label>

                                            <select name="sstate" class="form-control req">
                                                <option selected="selected" value="">Please select</option>
                                                <option value="VIC">VIC</option>
                                                <option value="NSW">NSW</option>
                                                <option value="QLD">QLD</option>
                                                <option value="WA">WA</option>
                                                <option value="SA">SA</option>
                                                <option value="NT">NT</option>
                                                <option value="TAS">TAS</option>
                                            </select>

                                        </div>
                                        <div class="form-group col-lg-3 col-md-6">
                                            <label>Postcode<span>*</span></label>
                                            <input class="form-control req" type="text" name="spostcode" maxlength="4" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Postal Address-->

                        <!-- Contact numbers -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-phone" id="icon-contact-numbers"></i> Contact numbers</h3>
                            </div>
                            <div class="panel-body">
                                <p>Please enter at least one form of contact below</p>
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Home phone number</label>
                                        <input class="form-control phone_group" type="text" name="phone" id="phone" >
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Work phone number</label>
                                        <input class="form-control phone_group" type="text" name="workphone" id="workphone">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Mobile phone number</label>
                                        <input class="form-control phone_group" type="text" name="mobilephone" id="mobilephone" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Contact numbers-->

                        <!-- Background information -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-info" id="icon-background-information"></i> Background information <small>(Mandatory for RTO - Registered training organisations)</small></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Were you born in Australia?</label>

                                        <select class="form-control" id="CountryofBirthID" name="CountryofBirthID">
                                            <option value="">Please select</option>
                                            <option value="1101">Yes</option>
                                            <option value="No">No</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>If no please specify</label>
                                        <select id="CountryofBirthID2" name="CountryofBirthID" class="form-control" style="width:100%" >
                                            <option value="">Please select country</option>
                                            @foreach($countries as $key => $country)
                                                <option value="<?php echo $key ?>"><?php echo $country ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Are you of Aboriginal or Torres Strait Islander origin?</label>

                                        <select name="IndigenousStatusID" class="form-control">
                                            <option value="">Please select</option>
                                            <option value="1">Yes, Aboriginal</option>
                                            <option value="2">Yes, Torres Strait Islander</option>
                                            <option value="4">No</option>
                                            <option value="@">I would prefer not to disclose this information</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Do you speak a language other than English at home?</label>

                                        <select id="MainLanguageID" class="form-control" name="MainLanguageID">
                                            <option value="">Please select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="1201">No, English only</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>If yes please specify</label>
                                        <select id="MainLanguageID2" name="MainLanguageID" class="form-control" style="width:100%" >
                                            <option value="">Please select</option>
                                            @foreach($languages as $key => $language)
                                                <option value="<?php echo $key ?>"><?php echo $language ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>How well do you speak English?</label>
                                        <select class="form-control" name="EnglishProficiencyID">
                                            <option value="">Please select</option>
                                            <option value="1">Very well</option>
                                            <option value="2">Well</option>
                                            <option value="3">Not well</option>
                                            <option value="4">Not at all</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Do you consider yourself to have a disability?</label>
                                        <select class="form-control" name="DisabilityFlag">
                                            <option value="">Please select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>If yes please specify</label>

                                        <select id="DisabilityTypeID" name="DisabilityTypeID" multiple="multiple" class="form-control" style="width:100%" >
                                            <option value="12">Physical</option>
                                            <option value="11">Hearing/Deaf</option>
                                            <option value="13">Intellectual</option>
                                            <option value="16">Acquired Brain Impairment</option>
                                            <option value="15">Mental Illness</option>
                                            <option value="14">Learning</option>
                                            <option value="18">Medical Condition</option>
                                            <option value="19">Other</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Background information -->

                        <!-- Education / Work background -->
                        <div class="panel panel-default details-panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon-briefcase" id="icon-work-background"></i> Education / Work background <small>(Mandatory for RTO - Registered training organisations)</small></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-sm-6"><!-- new class change-->
                                        <label>Student Number</label>
                                        <input class="form-control" type="text" name="customField1">
                                    </div>
                                    <div class="form-group col-lg-3 col-sm-6"><!-- new class change-->
                                        <label>Universal Student Identifier</label>
                                        <input class="form-control" type="text" id="USI" name="USI">
                                    </div>

                                    <div class="form-group col-lg-3 col-sm-6"><!-- new class change-->
                                        <label>What is your highest school level completed</label>
                                        <select class="form-control" id="HighestSchoolLevelID" name="HighestSchoolLevelID">
                                            <option value="">Please select</option>
                                            <option value="12">Year 12 or equivalent</option>
                                            <option value="11">Year 11 or equivalent</option>
                                            <option value="10">Year 10 or equivalent</option>
                                            <option value="09">Year 9 or equivalent</option>
                                            <option value="08">Year 8 or below</option>
                                            <option value="02">Did not go to school</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-3 col-sm-6"><!-- new class change-->
                                        <label>In which year did you complete that school level?</label>
                                        <input class="form-control" type="text" id="HighestSchoolLevelYear" name="HighestSchoolLevelYear">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-lg-5 col-sm-12">
                                        <label>Are you still attending secondary school?</label>

                                        <select class="form-control" name="AtSchoolFlag" id="AtSchoolFlag">
                                            <option value="">Please select</option>
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-7 col-sm-12">
                                        <label>Have you successfully completed any of the following qualifications?</label>

                                        <select class="form-control" style="width:100%" name="PriorEducationID" id="PriorEducationID" multiple="multiple">

                                            <option value="008">Bachelor Degree or Higher</option>
                                            <option value="410">Advanced Diploma or Associate Degree</option>
                                            <option value="420">Diploma</option>
                                            <option value="511">Certificate IV</option>
                                            <option value="514">Certificate III</option>
                                            <option value="521">Certificate II</option>
                                            <option value="524">Certificate I</option>
                                            <option value="990">Certificate other than above</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Of the following categories, which best describes your current employment status?</label>

                                        <select name="LabourForceID" id="LabourForceID" class="form-control">
                                            <option value="">Please select</option>
                                            <option value="1">Full-time Employee</option>
                                            <option value="3">Self Employed - Not employing others</option>
                                            <option value="2">Part-time Employee</option>
                                            <option value="8">Not Employed - Not seeking work</option>
                                            <option value="5">Employed - Unpaid, working in a family business</option>
                                            <option value="7">Unemployed - Seeking full-time work</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Education / Work background -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="response"></div>
                            </div>
                            <div class="col-md-12 ">
                                <input type="hidden" id="DisabilityTypeIDs" value="" name="DisabilityTypeIDs">
                                <input type="hidden" id="PriorEducationIDs" value="" name="PriorEducationIDs">
                                <input type="hidden" id="contactID" value="<?php echo $user["CONTACTID"]; ?>"name="contactID">
                                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                                <button class="r-btn btn-flat default pull-right" style="margin-left:20px;">Cancel</button>
                                <button class="r-btn btn-flat primary pull-right" id="btnSave">Save</button>
                            </div>
                        </div>
                    </form>
                </div><!-- col -->
            </div> <!-- row-->

        </div> <!-- pad -->
    </div><!-- container -->
</div><!-- Content -->

<script>
    $(document).ready(function(){
        $("#DisabilityTypeID").select2();

        //start User Profile
        var userID= "<?php echo $user["USERID"] ;?>";
        getUserDetails(userID,"enrolment");

        // End User Profile

        $('[name="DisabilityFlag"]').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            if(this.value == "0"){
                $("#DisabilityTypeID").select2("val", "", false);
            }
        });

        $("#PriorEducationID").select2();
        $("#CountryofBirthID2").select2();
        $("#btnSave").on('click', function() {
            var DisabilityTypeIDs = $.map($("#DisabilityTypeID option:selected"), function (el, i) {
                return $(el).val();
            });
            $("#DisabilityTypeIDs").val(DisabilityTypeIDs.join(","));

            var PriorEducationIDs = $.map($("#PriorEducationID option:selected"), function (el, i) {
                return $(el).val();
            });
            $("#PriorEducationIDs").val(PriorEducationIDs.join(","));

            var formData = $("#detail-form").serialize();
            $.blockUI({ message: waitmsg });
            $.ajax({
                type: "POST",
                url: "/user/myDetails",
                dataType: 'json',
                cache: false,
                data: formData,
                success: function(data) {
                    var result = JSON.stringify(data, undefined, 2);
                    console.log(data);
                    if(data.status == 'success'){
                        $('.response').hide().html('<div class="alert" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-check"></i> ' + data.message + '</div>').fadeIn();
                    } else {
                        $('.response').hide().html('<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i> ' + data.message + '</div>').fadeIn();
                    }
                },
                error: function(data) {
                    $('.response').hide().html('<div class="alert alert-error" style="margin-top: 10px; margin-bottom: 0;"><i class="icon-remove-sign"></i>Network error</div>').fadeIn();
                }
            });
            return false;
        });
    });
</script>

<?php
//$added_js = array("select2.min.js");
?>

@stop