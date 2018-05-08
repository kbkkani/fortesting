@extends('admin')
@section('content')
    <?php if($groups->count() > 0) {?>
    <?php foreach ($groups as $group) { ?>
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse<?php echo $group->id ?>"><?php echo $group->title?></a>
        </h4>
    </div>
    <div id="collapse<?php echo $group->id ?>" class="panel-collapse collapse">
        <?php foreach ($groupcourses as $course) { ?>
        <?php if($course->group_id == $group->id) { ?>

        <?php $courseInfo = \App\Course::where("id", $course->course_id)->get(); ?>
        <div class="panel-body"><?php echo($courseInfo[0]->instance_id ." ".$courseInfo[0]->type); ?></div>

        <?php } ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } else { ?>
    <div>
        No Groups Courses
    </div>
    <?php } ?>
@stop
