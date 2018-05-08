@extends('admin')
@section('content')

    <div id="group-course-results" style="display: none;">
        <table id="groupCourse" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Instance ID</th>
                <th>Type</th>
                <th>Price</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Group</button>
    </div>



        <div class="row" id="search_panel">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body group_courses_admin">
                        @include("includes.search")
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create Group Courses</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="title" name="title" class="form-control req" />
                    </div>
                    <div class="modal-footer">
                        <button id="create_group_course" type="submit">Create Group Course</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

@stop