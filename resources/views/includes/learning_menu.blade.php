<div class="row" style="display: none;">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 clearfix">
                <i class="fa fa-laptop bg-info p-3 font-2xl mr-3 float-left"></i>
                <div class="h5 text-primary mt-2 mb-0"><?php echo $coursesCount ?></div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Total No of Courses</div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="font-weight-bold font-xs btn-block text-muted" href="#">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>
            </div>
        </div>
    </div>
    <!--/.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 clearfix">
                <i class="fa fa-cogs bg-primary p-3 font-2xl mr-3 float-left"></i>
                <div class="h5 text-primary mt-2 mb-0"><?php echo count($types) ?></div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Course Varieties</div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="font-weight-bold font-xs btn-block text-muted" href="#">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>
            </div>
        </div>
    </div>
    <!--/.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 m-0">50%</div>
                <div class="progress progress-xs my-3">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Enrolled Vs Completed</small>
            </div>
        </div>
    </div>
    <!--/.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 m-0">20 Activities TO-DO</div>
                <div class="progress progress-xs my-3">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Activity List</small>
            </div>
        </div>
    </div>
    <!--/.col-->
</div>

<div class="row" id="dashboard-learning-menu">
    <div class="col-xs-12">
        <nav class="navbar navbar-default middle-menu" role="navigation">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <ul class="nav navbar-nav user-nav">
                <li class="dashboard">
                    <a href="<?php echo App::make('url')->to('/mylearning') ?>">
                        <i class="icon-speedometer"></i>
                        <h3>Dashboard</h3>
                        <span>Search through available courses</span>
                    </a>
                </li>

                <li>
                    <a href="#current_reg" class="registration_list" data-contactid="<?php echo $contactId ?>" data-toggle="tab">
                        <i class="icon-graph"></i> 
                        <h3>My training</h3>
                        <span>See your enrolments and training progress</span>
                    </a>
                </li>
                
                <li>
                    <a href="#complete_reg" class="result_list" data-toggle="tab" data-contactid="<?php echo $contactId ?>">
                        <i class="icon-note"></i> 
                        <h3>My results</h3>
                        <span>View results and download certifications </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>  
</div>