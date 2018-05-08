<?
$active_dashboard = true;
$added_css = array( "lib/select2.css","compiled/form-wizard.css", "compiled/jquery.signaturepad.css");

if (empty(Session::get('user_details')))
{
    header('Location: '. '/login');
}

?>

<script type="text/javascript">// <![CDATA[
    function keepSessionAlive() {
        $.post("/ping.html");
    }

    jQuery(function() { window.setInterval("keepSessionAlive()", 60000); });
</script>

<div class="content">
    <div class="content-wrap" style="margin-top: 50px;padding-bottom: 20px;">
        <div class="row">
            <div class="col-md-12">
                <form id="enrolment-form" method="post">
                    <div id="form-data">
                        <div id="fuelux-wizard" class="wizard row-fluid">
                            <ul class="wizard-steps">
                                <li data-target="#step1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Course <br> information</span>
                                </li>

                                <li data-target="#step2">
                                    <span class="step">2</span>
                                    <span class="title">Personal <br> information</span>
                                </li>

                                <li data-target="#step3">
                                    <span class="step">3</span>
                                    <span class="title">Background and Work/Education <br> information</span>
                                </li>

                                <li data-target="#step4">
                                    <span class="step">4</span>
                                    <span class="title">Enrolment <br> Confirmation</span>
                                </li>
                            </ul>
                        </div>

                        <!--- steps -->
                        <div class="step-content">
                            <!--step 1-->
                            <div class="step-pane active" id="step1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="nobtm"><i class="icon-trophy"></i> Register for <span id="course_name"></span></h3>
                                        <p>
                                            <span class="pull-right">Fields marked with * are required</span>
                                            <span id="course_startdate"></span><br/>
                                            <span id="course_location"></span>
                                            <span id="course_details"></span>
                                        </p>
                                        <!--      basic info-->
                                        <br/>
                                        <br/>
                                    </div>
                                </div>
                            </div>

                            <!--End Step 1-->

                            <!-- step 2-->
                            <div class="step-pane" id="step2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!--     setp 2 content-->
                                        <!-- start basic information -->
                                        <h4><i class="icon-pencil"></i> Basic information</h4>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Full/legal First Name*:</label>
                                                <input class="form-control req" type="text" id="givenName" name="givenName" readonly>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Full/legal Surname*:</label>
                                                <input class="form-control req" type="text" id="surname" name="surname" readonly>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Email*:</label>
                                                <input class="form-control req" type="text" id="emailAddress" name="emailAddress" readonly >
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Title*:</label>
                                                <select name="title" id="title" class="form-control req">
                                                    <option value="">Please select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Dr">Dr</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Sex*:</label>
                                                <select name="sex" id="sex" class="form-control req">
                                                    <option value="">Please select</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Date of birth*:</label>
                                                <input type="text" class="form-control req" id="dob" name="dob" readonly value='<?php #echo date("d/m/Y", strtotime($user_details->DOB)); ?>' >
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="parent" style="display:none;" >
                                            <h4><i class="icon-ban-circle"></i> Parent / Legal Guardian Declaration (Students under 18 years of age) </h4>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>First Name*:</label>
                                                    <input class="form-control" name="emstat" id="emstat"  type="hidden">
                                                    <input class="form-control" name="fcn" id="fcn"  type="text" onkeyup="concatn ()">
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>Surname*:</label>
                                                    <input class="form-control" name="fsn" id="fsn"  type="text" onkeyup="concatn ()">
                                                    <input class="form-control" name="EmergencyContact" id="fcnfull"  type="hidden">

                                                    <script>
                                                        function concatn (){
                                                            var fname = $("#fcn").val();
                                                            var sname = $("#fsn").val();
                                                            var fulln = fname+' '+sname;
                                                            $("#fcnfull").val(fulln);
                                                        }
                                                    </script>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>Relationship to Student*:</label>
                                                    <input class="form-control" name="EmergencyContactRelation" id="relst"  type="text">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>Emergency Contact Number*:</label>
                                                    <input class="form-control" name="EmergencyContactPhone" id="emcn"  type="text">
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <strong> I confirm that the student is in my care and consent to his/her enrolment into the course/unit(s) of study described above. I further agree to ensure payment of any outstanding fees for the course/unit(s) of study for which this student enrolls.</strong>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <div class="sigPad">
                                                        <ul class="sigNav">
                                                            <li class="drawIt"><a href="#draw-it" style="text-shadow: none !important;" >Signature</a></li>
                                                            <li class="clearButton"><a href="#clear">Clear</a></li>
                                                        </ul>

                                                        <div class="sig sigWrapper">
                                                            <div class="typed"></div>
                                                            <canvas class="pad" width="420" height="85"></canvas>
                                                            <input type="hidden" name="outputa"  class="output" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end basic information -->

                                        <!-- start personal information -->
                                        <h4><i class="icon-envelope"></i> Personal address</h4>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Building/property name:</label>
                                                <input class="form-control" name="sbuildingName" id="sbuildingName"  type="text">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Unit/flat details:</label>
                                                <input class="form-control" name="sunitNo" id="sunitNo" type="text">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Street number*</label>
                                                <input class="form-control req" type="text" name="sstreetNo" id="sstreetNo">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Street name*:</label>
                                                <input class="form-control req" type="text" name="sstreetName" id="sstreetName">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>City*</label>
                                                <input class="form-control req" type="text" id="scity" name="scity">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>State*:</label>
                                                <select name="sstate" id="sstate" class="form-control req">
                                                    <option value="">Please select</option>
                                                    <option  value="VIC">VIC</option>
                                                    <option value="NSW">NSW</option>
                                                    <option value="QLD">QLD</option>
                                                    <option value="WA">WA</option>
                                                    <option value="SA">SA</option>
                                                    <option value="NT">NT</option>
                                                    <option value="TAS">TAS</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Postcode*:</label>
                                                <input class="form-control req" type="text"  id="spostcode" name="spostcode" maxlength="4" >
                                            </div>
                                        </div>

                                        <!-- end personal address -->
                                        <br/>
                                        <!-- start postal information -->
                                        <h4><i class="icon-truck"></i> Postal address</h4>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="checkbox">
                                                    <div class="checker"><span><input type="checkbox" id="same-shipping" name="same-shipping" checked="checked" class="checkbox"></span></div> Same as above
                                                </label>
                                            </div>
                                        </div>

                                        <div class="postal-details" style="display: none">
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>PO Box (if applicable)</label>
                                                    <input class="form-control" type="text" name="POBox" id="POBox">
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>Building/property name</label>
                                                    <input class="form-control" type="text" name="buildingName" id="buildingName">
                                                    <input class="form-control" name="unitNo" id="unitNo" type="hidden">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>Street number*</label>
                                                    <input class="form-control req" type="text" name="streetNo" id="streetNo" >
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>Street name*:</label>
                                                    <input class="form-control req" type="text" name="streetName" id="streetName">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>City*</label>
                                                    <input class="form-control req" type="text" name="city" id="city" >
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>State*:</label>
                                                    <select name="state" id="state" class="form-control req">
                                                        <option value="">Please select</option>
                                                        <option value="VIC">VIC</option>
                                                        <option value="NSW">NSW</option>
                                                        <option value="QLD">QLD</option>
                                                        <option value="WA">WA</option>
                                                        <option value="SA">SA</option>
                                                        <option value="NT">NT</option>
                                                        <option value="TAS">TAS</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>Postcode*:</label>
                                                    <input class="form-control req" type="text" name="postcode" maxlength="4" id="postcode" >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end postal address -->

                                        <!-- start contact numbers -->

                                        <br/>
                                        <h4 class="nobtm"><i class="icon-phone-sign"></i> Contact numbers</h4>
                                        <p>Please enter at least one form of contact below</p>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Home phone number</label>
                                                <input class="form-control phone_group" type="text" name="phone" id="phone" >
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Work phone number</label>
                                                <input class="form-control phone_group" type="text" name="workphone" id="workphone">
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Mobile phone number</label>
                                                <input class="form-control phone_group" type="text" name="mobilephone" id="mobilephone">
                                            </div>
                                        </div>
                                        <!--     setp 2 content-->
                                    </div>
                                </div>
                            </div>

                            <!--End step 2-->
                            <!-- Step 3-->
                            <div class="step-pane" id="step3">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!--           Edu info-->
                                        <h4><i class="icon-phone-sign"></i> Background information <!--(Mandatory for RTO - Registered training organisations)--></h4>
                                        <!-- start background information -->
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
                                                <select id="CountryofBirthID2" name="CountryofBirthID" style="width:100%" >
                                                    <option value=""></option>
                                                    <?php
                                                    foreach($countries as $key => $country){
                                                        echo "<option value='".$key."'>$country</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Are you of Aboriginal or Torres Strait Islander origin?</label>
                                                <div class="ui-select ">
                                                    <select name="IndigenousStatusID" class="form-control">
                                                        <option value="">Please select</option>
                                                        <?php foreach ($indigenous as $key => $indigenou) {?>
                                                        <option value="<?php echo $key ?>"><?php echo $indigenou ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
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
                                                <select id="MainLanguageID2" name="MainLanguageID" class="select2" style="width:100%" >
                                                    <option value="">Please select</option>
                                                    <?php foreach ($languages as $key=>$language) { ?>
                                                        <option id="<?php echo $key ?>"><?php echo $language ?></option>
                                                    <?php } ?>
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
                                                <select id="DisabilityTypeID" name="DisabilityTypeID" multiple="multiple" class="select2" style="width:100%" >
                                                    <?php
                                                    foreach($disabilityType as $key => $disability){
                                                        echo "<option value='".$key ."'>$disability</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <h4><i class="icon-phone-sign"></i> Education / Work background <!--(Mandatory for RTO - Registered training organisations)--></h4>

                                        <!-- start work/education  information -->

                                        <div class="row">

                                            <div class="form-group col-sm-3">

                                                <label>Student Number</label>

                                                <input class="form-control" type="text" name="customField1">

                                            </div>

                                            <div class="form-group col-sm-3">

                                                <label>Unique Student Identifier</label>

                                                <input class="form-control" type="text" id="USI" name="USI">

                                            </div>



                                            <div class="form-group col-sm-3">

                                                <label>What is your highest school level completed</label>

                                                <select class="form-control" id="HighestSchoolLevelID" name="HighestSchoolLevelID">
                                                    <option value="">Please select</option>
                                                    <?php
                                                    foreach($schools as $key => $school){
                                                        echo "<option value='".$key."'>$school</option>";
                                                    } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-3">

                                                <label>In which year did you complete that school level?</label>

                                                <input class="form-control" type="text" id="HighestSchoolLevelYear" name="HighestSchoolLevelYear">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-5">

                                                <label>Are you still attending secondary school?</label>
                                                <select class="form-control" name="AtSchoolFlag" id="AtSchoolFlag">
                                                    <option value="">Please select</option>
                                                    <option value="true">Yes</option>
                                                    <option value="false">No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-7">
                                                <label>Have you successfully completed any of the following qualifications?</label>
                                                <select class="select2" style="width:100%" name="PriorEducationID" id="PriorEducationID" multiple="multiple">
                                                    <?php
                                                    foreach($educations as $key => $education){
                                                        echo "<option value='".$key."'>$education</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <br/>

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

                                        <br/>

                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label>Of the following categories, which best describes yours main reason for undertaking this course / traineeship / apprenticeship?</label>

                                                <select  class="form-control" id="studyreasons" name="work[studyreasons]">
                                                    <option value="">Please select</option>
                                                    <option value="To get a job">To get a job</option>
                                                    <option value="To develop my existing business">To develop my existing business</option>
                                                    <option value="To start my own business">To start my own business</option>
                                                    <option value="To try for a different career">To try for a different career</option>
                                                    <option value="To get a better job or promotion">To get a better job or promotion</option>
                                                    <option value="It was a requirement of my job">It was a requirement of my job</option>
                                                    <option value="I wanted extra skills for my job">I wanted extra skills for my job</option>
                                                    <option value="To get into another course of study">To get into another course of study</option>
                                                    <option value="For personal interest or self-development">For personal interest or self-development</option>
                                                    <option value="Other reasons">Other reasons</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- end work/education information -->

                                    </div>

                                </div>

                            </div>

                            <!-- End Step 3-->

                            <!-- Step 4-->

                            <div class="step-pane" id="step4">

                                <div class="row payment-info" >

                                    <!-- start payment information -->

                                    <div class="col-sm-12" id="payment_info">

                                        <h4><i class="icon-check"></i> Select payment type</h4>

                                        <div class="row">

                                            <div class="form-group col-sm-6">

                                                <label class="radio-inline">

                                                    <input type="radio"   name="payment_option" id="creditcard" value="creditcard" checked="checked">Credit Card

                                                </label>



                                                <label class="radio-inline">

                                                    <input type="radio" name="payment_option" id="code" value="techone">Code

                                                </label>

                                            </div>



                                        </div>



                                        <!-- start credit card form -->

                                        <div class="row" id="creditcard-details" style="display:block;">

                                            <div class="col-sm-12">

                                                <h4><i class="icon-credit-card"></i> Enter credit card details</h4>

                                                <div class="row">

                                                    <div class="form-group col-sm-4">

                                                        <label>Card holder name*</label>

                                                        <input class="form-control req" type="text" name="nameOnCard" id="nameOnCard" value="">

                                                    </div>

                                                    <div class="form-group col-sm-4">

                                                        <label>Price AU$</label>

                                                        <input class="form-control" readonly id="paymentAmount" name="paymentAmount"  type="text" >

                                                    </div>

                                                    <div class="form-group col-sm-4">

                                                        <label>Accepted payments</label><br/>

                                                        <img src="{{asset('img/accepted_payments.jpg')}}" alt="accepted payments Mastercard, VISA"/><img src="https://www.rapidssl.com/assets/shared/images/rapidssl_ssl_certificate.gif?d=050911" height="36"/>

                                                        <!--

<label>Credit card type*</label>



                                                            <select  id="cardtype" class="form-control req" name="cardtype">

                                                                <option value="">Please select</option>

                                                                <option value="Mastercard">Mastercard</option>

                                                                <option value="VISA">VISA</option>

                                                            </select>
-->


                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="form-group col-sm-4">

                                                        <label>Credit card number*</label>

                                                        <input class="form-control req" type="text" name="cardNumber" id="cardNumber" value="">

                                                    </div>

                                                    <div class="form-group col-sm-2">
                                                        <label>Expiry date*</label>
                                                        <select  name="expiryMonth" id="expiryMonth" class="form-control req" >
                                                            <option value="">MM</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>

                                                            <option value="07">07</option>

                                                            <option value="08">08</option>

                                                            <option value="09">09</option>

                                                            <option value="10">10</option>

                                                            <option value="11">11</option>

                                                            <option value="12">12</option>

                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-2">
                                                        <label>&nbsp;</label>
                                                        <select name="expiryYear" id="expiryYear" class="form-control req" >
                                                            <option value="">YYYY</option>
                                                            <?php $current_year = date('y');
                                                            $i=$current_year;
                                                            while ($i <= $current_year + 10) { // Output values from 0 to 10
                                                                $year = $i + 2000;
                                                                echo "<option value='$i'>$year</option>";
                                                                $i++;
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label>CVV* <a href="#" class="info_sign"><i class="icon-question-sign"></i> </a></label>

                                                        <input class="form-control req" type="text" name="cardCCV" id="cardCCV" maxlength="5" value="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end credit card form -->

                                        <!-- start tech one code -->

                                        <div id="techonecode" style="display: none">
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <h4><i class="icon-barcode"></i> Enter code</h4>
                                                    <div class="input-group">

                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <label>Coupon code</label>
                                                            <input class="form-control req" type="text" name="couponcode" value=""  id="coupon"/>
                                                        </div>

                                                        <div class="form-group col-sm-6">
                                                            <label>Price AU$</label>
                                                            <input class="form-control paymentAmount" readonly type="text" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end tech one code -->

                                    </div>

                                    <!-- end payment information -->

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="req" name="codeofpractice">I have read and understood the VET Code of Practice and terms & conditions. <a href="http://www.lsv-from-anywhere.com.au/VETCodeofPractice" target="_blank" class="info_sign" title="View VET Code of Practice"><i class="icon-external-link"></i> </a>
                                            </label>

                                            <br />

                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="req" name="codeofpractice2">I have provided my email address for notification of certificate issue
                                            </label>

                                            <br />

                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="req" name="codeofpractice3" id="codeofpractice3"><div id="reqfl"></div>
                                            </label>
                                            <br />

                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="req" name="codeofpractice4" id="codeofpractice4"><div id="reqfl1"></div>
                                            </label>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-sm-12">

                                            <div class="sigPad">

                                                <ul class="sigNav">
                                                    <li class="drawIt"><a href="#draw-it" style="text-shadow: none !important;" >Signature</a></li>
                                                    <li class="clearButton"><a href="#clear">Clear</a></li>
                                                </ul>

                                                <div class="sig sigWrapper">
                                                    <div class="typed"></div>
                                                    <canvas class="pad" width="420" height="85"></canvas>
                                                    <input type="hidden" name="output"  class="output" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--  End Step 4-->

                        </div>

                        <!-- End Steps -->

                    </div>

                    <div class="wizard-actions">

                        <button type="button" disabled="" class="btn-glow primary btn-prev">

                            <i class="icon-chevron-left"></i> Prev

                        </button>

                        <button type="button" class="btn-glow primary btn-next" data-last="Finish">
                            Next <i class="icon-chevron-right"></i>
                        </button>

                        <button type="submit" class="btn-glow success btn-finish submit_btn" formid="enrolment-form">
                            Complete registration
                        </button>

                    </div>

                    <input type="hidden" id="public" name="public"  class="output" >

                    <input type="hidden" id="type" name="type" value="w">

                    <input type="hidden" id="instanceID" value="<?php echo $instanceID; ?>" name="instanceID">

                    <input type="hidden" id="contactID" value="<?php echo $user_details["CONTACTID"]; ?>" name="contactID">

                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                </form>

                <div class="response">

                </div>

            </div>
        </div>
    </div>
</div>

<!-- start pre req -->

<div class="modal fade"  id="pre_req" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="pre_req_lbl" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="pre_req_lbl">Prerequisite required</h4>
            </div>

            <div class="modal-body">

                <div id="pre_req_content"></div>

                <!--strong>My confirmation:</strong><br/>

I have successfully completed the unit(s) of competency listed above as pre-requisite for this course and will provide a copy of my certificate prior to completion of this course. <br/-->
                <br/>
                Click 'confirm' if you hold the pre-requisite and will provide a copy prior to the completion of the course.
                Click 'cancel' and exit the enrolment if you are unable / unwilling to meet the pre-requisite requirement.<br/><br/>
                For further information click 'cancel' then select the 'help' link at the top right screen.
            </div>

            <div class="modal-footer">

                <button type="button" class="btn-glow success" data-dismiss="modal" aria-hidden="true"><i class="icon-check"></i> <em>Confirm</em></button>

                <button type="button"  class="btn-glow" style="background: #ae3b3b;

background: linear-gradient(to bottom, #cc1212 0%, #ae3b3b 100%);

box-shadow: inset 0px 1px 0px 0px rgba(255, 255, 255, 0.5);

border: 1px solid #99bd56;

text-shadow: rgba(0, 0, 0, 0.24706) 0px 1px 0px;

color: #fff;" value="Back" onclick="history.go(-1);"><em>Cancel</em> &times;</button>

            </div>

            </form>

        </div>

    </div>

</div>

<!-- end pre req -->

<script>

    $(function() {

        var $wizard = $('#fuelux-wizard'),
            $btnPrev = $('.wizard-actions .btn-prev'),
            $btnNext = $('.wizard-actions .btn-next'),
            $btnFinish = $(".wizard-actions .btn-finish");
        $wizard.wizard().on('finished', function(e) {

            // wizard complete code

        }).on("changed", function(e) {

            var step = $wizard.wizard("selectedItem");

            // reset states
            $btnNext.removeAttr("disabled");
            $btnPrev.removeAttr("disabled");
            $btnNext.show();
            $btnFinish.hide();
            if (step.step === 1) {
                $btnPrev.attr("disabled", "disabled");
            } else if (step.step === 4) {
                $btnNext.hide();
                $btnFinish.show();
            }
        });

        $btnPrev.on('click', function() {
            $wizard.wizard('previous');
            $(window).scrollTop(0);
        });

        $btnNext.on('click', function() {
            if ($('#enrolment-form').valid()) {
                $wizard.wizard('next');
                $(window).scrollTop(0);
            } else {
                return false;
            }
        });

        $btnFinish.on('click', function() {
            createPayment();
            return false;
        });
    });

    function createPayment(){
        if (!$('#enrolment-form').valid()) {
            return false;
        }

        var instanceID = "<?php echo $instanceID ?>";
        var contactID = "<?php echo $user_details["CONTACTID"] ?>";
        var formData = $("#enrolment-form").serialize();
        $.blockUI({ message: waitmsg });

        $.ajax({
            type: "POST",
            url: "/mylearning/createEnrol",
            dataType: 'json',
            cache: false,
            data: formData,
            success: function(data) {
                var result = JSON.stringify(data, undefined, 2);
                console.log(data);
                if(data.status == 'success'){
                    $('#enrolment-form').fadeOut();
                    $('.content-wrap').css({ 'margin-top': '0px' });
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
    }

    $('#same-shipping').change(function() {

        if ($(this).is(':checked')) {
            $(".postal-details").slideUp();
            var sbuildingName = $("#sbuildingName").val();
            var sstreetNo = $("#sstreetNo").val();
            var sstreetName = $("#sstreetName").val();
            var scity = $("#scity").val();
            var sstate = $('#sstate option:selected').text();
            var spostcode = $("#spostcode").val();
            var sunitNo = $("#sunitNo").val();


            $("#buildingName").val(sbuildingName);
            $("#streetNo").val(sstreetNo);
            $("#streetName").val(sstreetName);
            $("#city").val(scity);
            $("#state").val(state);
            $("#postcode").val(spostcode);
            $("#unitNo").val(sunitNo);
        } else {
            $(".postal-details").slideDown();
        }
    });

    $("input:radio[name=payment_option]").click(function() {

        var payment = $(this).val();

        if (payment == "creditcard") {

            $("#techonecode").slideUp();

            $("#creditcard-details").slideDown();

        } else {

            $("#creditcard-details").slideUp();

            $("#techonecode").slideDown();

        }

    });

    $(document).ready(function () {
        //start User Profile
        var userID= "<?php echo $user_details['USERID'] ?>";

        getUserDetails(userID,"enrolment");
        getInstanceDetails(<?php echo $instanceID ?>);

        $("#enrolment-form").validate({
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            },

            rules: {
                'mobilephone': {
                    require_from_group: [1, ".phone_group"]
                },

                'phone': {
                    require_from_group: [1, ".phone_group"]
                },

                'workphone': {
                    require_from_group: [1, ".phone_group"]
                },

                'resaddress[postcode]': {
                    required: true,
                    maxlength: 4,
                    number: true
                }
            }
        });

        $('.sigPad').signaturePad({
            drawOnly: true,
            lineTop: 70,
            penWidth: 4
        }).regenerate(sig);

        $("#signature_form").submit(function(event) {
            var result = deflateFromJsonSignature($("#signature_json_text").val());
            return true;
        });
    });

    function getInstanceDetails(instanceID){
        $.blockUI({ message: waitmsg });
        var currentToken = jQuery('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/mylearning/enrolInstanceDetails",
            dataType: 'json',
            data:{
                instanceID: instanceID,
                '_token': currentToken
            },
            cache: false,
            success: function(data) {
                if(data.status == 'success'){
                    var ccode = data.details.CODE;
                    var cnamed = data.details.NAME;

                    if(ccode == 'PLG'){

                        var n = cnamed.indexOf("Blended");
                        if (n == '-1'){
                            $("#reqfl").html("I hold / will hold the pre-requisite prior to the course commencement.");
                            $("#codeofpractice4").css("display", "none");
                        }else {
                            $("#reqfl").html("I hold / will hold the pre-requisite prior to the course commencement.");
                            $("#reqfl1").html("I have / will have completed the required online learning prior to the course commencement.");
                        }
                    }
                    else if (ccode == 'PLG U')
                    {
                        $("#reqfl").html("I hold / will hold the pre-requisite prior to the course commencement.");
                        $("#codeofpractice4").css("display", "none");
                    }
                    else if (ccode == 'CPR')
                    {
                        var n = cnamed.indexOf("Blended");
                        if (n == '-1'){
                            $("#codeofpractice3").css("display", "none");
                            $("#codeofpractice4").css("display", "none");
                        }else {
                            $("#reqfl").html("I have / will have completed the required pre-course learning prior to the course commencement.");
                            $("#codeofpractice4").css("display", "none");
                        }
                    }

                    else if (ccode == 'FA FLX')
                    {
                        $("#reqfl").html("I have / will have completed the required flexible delivery workbook prior to the course commencement.");
                        $("#codeofpractice4").css("display", "none");
                    }
                    else if (ccode == 'FA')
                    {
                        var n = cnamed.indexOf("Blended");
                        if (n == '-1'){
                            $("#codeofpractice3").css("display", "none");
                            $("#codeofpractice4").css("display", "none");
                        }else{
                            $("#reqfl").html("I have / will have completed the required pre-course learning prior to the course commencement.");
                            $("#codeofpractice4").css("display", "none");
                        }
                    }

                    else if (ccode == 'IAR')
                    {
                        var n = cnamed.indexOf("Blended");
                        if (n == '-1'){
                            $("#codeofpractice3").css("display", "none");
                            $("#codeofpractice4").css("display", "none");
                        }
                        else {
                            $("#reqfl").html("I have / will have completed the required pre-course learning prior to the course commencement.");
                            $("#codeofpractice4").css("display", "none");
                        }
                    } else {
                        $("#codeofpractice3").css("display", "none");
                        $("#codeofpractice4").css("display", "none");
                    }

                    //add ceckbox for final section

                    $("#type").val(data.details.TYPE);
                    $("#paymentAmount").val(data.details.COST);
                    $(".paymentAmount").val(data.details.COST);

                    $("#course_name").html(data.name);
                    $("#course_location").html(data.location);
                    if(data.pre_req != null && data.pre_req != ""){
                        $('#pre_req').modal('show');
                        $('#pre_req_content').html(data.pre_req);
                    }
                    $("#course_startdate").html("Starts on  "+ data.start_date);
                    $("#course_details").html("<br/><br/>Description:<br/>"+ data.description);
                    $("#DisabilityTypeID").select2();
                    var public = data.details.PUBLIC;
                    $("#public").val(public);
                    if(public == 0){
                        var text = this.text;
                        var org = "(YMCA) ";
                        var org2 = "(YMCAGRP)";

                        if(  data.details.NAME.indexOf( org ) != -1 ) {
                            $("#payment_info").show();
                        } else if (data.details.NAME.indexOf( org2 ) != -1) {
                            $("#payment_info").show();
                        } else {
                            $("#payment_info").hide();
                        }

                    }else{
                        $("#payment_info").show();
                    }

                    //start User Profile
                    var userID= "<?php echo $user_details["USERID"]?>";
                    // getUserDetails(userID,"enrolment");

                    // End User Profile
                    $('[name="DisabilityFlag"]').on('change', function (e) {
                        var optionSelected = $("option:selected", this);
                        if(this.value == "0"){
                            $("#DisabilityTypeID").select2("val", "", false);
                        }
                    });

                    $("#PriorEducationID").select2();
                    $("#CountryofBirthID2").select2();
                } else {
                    $.unblockUI();
                    $('#form-data').remove();
                    $('.wizard-actions').remove();
                    $('.response').html('<div class="alert alert-warning"><i class="icon-warning-sign"></i><strong>Important Information</strong><br>'+data.message+'</div>');

                }
                return false;
            },

            error: function(data) {
                $.unblockUI();
                alert('The selected course has already been expired');
            }
        });
    }

</script>

<?php
$added_js = array("fuelux.wizard.js", "sigpad/jquery.signaturepad.min.js", "select2.min.js");
?>