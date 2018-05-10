@extends('admin')
@section('content')
    <style>
        .form-control{height:25px !important;padding:2px 12px !important;float:right;border-radius: 4px;}

    </style>
    <div class="panel-heading">
        <div class="row">
            <h4>Manage user types</h4>
        </div>
    </div>

    <table class="table table-bordered" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Course Id</th>
            <th>Location</th>
            <th style="width:60px;">Type</th>
            <th style="width:60px;">User Form</th>
        </tr>
        </thead>
    </table>


    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = '';

        $(function () {

            table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('course-form') !!}',
                    method: 'POST'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'instance_id', name: 'instance_id'},
                    {data: 'location', name: 'location'},
                    {data: 'type-fl', name: 'type-fl'},
                    {data: 'form-s', name: 'form-s'},
                ]
            });

        });

        $(document).on('change', '.slf', function () {

            var currentToken = jQuery('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{route('course-form.save')}}',
                type: 'post',
                cache: false,
                data: {
                    '_token': currentToken,
                    'course_id': $(this).attr('u-id'),
                    'type': $(this).val()
                },
                success: function (data, textStatus, jQxhr) {
                    table.ajax.reload();

                },
                error: function (jqXhr, textStatus, errorThrown) {

                }
            });
            // alert($(this).val()+' - '+$(this).attr('u-id'));
        });


    </script>
@stop


