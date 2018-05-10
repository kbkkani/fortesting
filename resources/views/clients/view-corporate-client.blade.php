@extends('admin')
@section('content')

    <style>
        .paginate_button{padding:0 !important}

    </style>

    <div class="panel-heading">
        <div class="row">
            <h4>All coporate clients</h4>
        </div>
    </div>



    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered" id="users-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Business Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>POS Name</th>
                    <th>POS Email</th>
                    <th>Code</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


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
                    url: '{!! route('datatable.clients') !!}',
                    method: 'POST'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'business_name', name: 'business_name'},
                    {data: 'contact_no', name: 'contact_no'},
                    {data: 'email', name: 'email'},
                    {data: 'pointof_fname_and_lastname', name: 'pointof_fname_and_lastname'},
                    {data: 'pointof_email', name: 'pointof_email'},
                    {data: 'prefix_code', name: 'prefix_code'},
                    {data: 'actions', name: 'actions'}
                ]
            });

        });




    </script>


@stop