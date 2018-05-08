<div class="container-fluid ">
    {{--<form id="searchcourse" role="form" action="https://training.lsv-from-anywhere.com.au/api/index.php" method="post">--}}
    <div id="search-course">
        <div> <!-- class="row div-icon-btns " -->
            <div class="filter_option">
                <div class="col-xs-12 col-md-3">
                    <label for="coursetype" class=""><i class="icon-exchange"></i> Select a training course:</label>
                    <br>
                    <select id="courseType" name="courseType" style="font-size: 13px;"
                            class="form-control course-type-main">
                        <?php foreach ($types as $type){ ?>
                        <option id="<?php echo $type->instance_id ?>"><?php echo $type->type ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-2">
                    <label><i class="icon-calendar"></i> Date from:</label>
                    <div class='input-group date' id='datetimepicker_start'>
                        <input id="startDate" type='text' class="form-control"/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <label><i class="icon-calendar"></i> Date to:</label>
                    <div class='input-group date' id='datetimepicker_end'>
                        <input id="endDate" type='text' class="form-control"/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <label>Course ID <a href="https://training.lsv-from-anywhere.com.au/userguides" class="info_sign"
                                        data-toggle="tooltip" title="" style="font-size: 13px;"
                                        data-original-title="Course codes are a alphanumeric set of numbers and letters provided by training organisations for both public and private courses."><i
                                    class="icon-question-sign"></i> </a>:</label>
                    <input id="instanceId" type="text" class="form-control" placeholder="Enter Course ID"/>
                </div>
                <div class="col-xs-12 col-md-2">
                    <label class="visibility-hidden hidden-xs"><i class=""></i> Date from:</label>
                    <br>
                    <button id="searchcourse" class="search_btn btn spec_search"><i class="icon-search"></i> Search
                    </button>
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
                    <div class="courses-panel-heading" style="display: none"><span class=" pull-right"><button
                                    class="btn btn-glow toggle_show">Show/Hide</button><br></span><h5><i
                                    class="fa fa-info icon"></i>Information on training courses</h5></div>

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