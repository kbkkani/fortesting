@extends('admin')
@section('content')


    <div id="types_status">
        @foreach($types as $type)
            <div class="col-sm-6">
                <span>
                @if($type->is_active)
                        <input id="status{{$type->instance_id}}" name="status[{{$type->instance_id}}]" type="checkbox" checked value="1"/>
                    @else
                        <input id="status{{$type->instance_id}}" name="status[{{$type->instance_id}}]" type="checkbox" value="0"/>
                    @endif
                </span>
                &nbsp;&nbsp;
                {{$type->type}}

            </div>
        @endforeach
    </div>

    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

    <div>
        <button id="update_status" type="submit">Update</button>
    </div>



@stop