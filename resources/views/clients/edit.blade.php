@extends('admin')
@section('content')


<div class="panel-heading">
    <div class="row">
        <h4>Edit Corporate Client</h4>
    </div>
</div>

@if(count($errors)>0)
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif





<div class="panel panel-default">
    <div class="panel-body">


        <div class="row">
            <form action="{{route('corporate-client/'.isset($clients)?$clients->id:'')}}" method="PUT" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Business Name</label>
                        <input type="text" name="businessname" class="form-control" id=""
                               placeholder="Business Name" value="{{$clients['business_name']}}">
                    </div>
                    <div class="form-group">
                        <label for="">Contact No</label>
                        <input type="test" name="contactno" class="form-control" id="" placeholder="Contact No"  value="{{$clients['contact_no']}}">
                    </div>

                    <div class="form-group">
                        <label for="">Email Address</label>
                        <input type="email" name="email" class="form-control" id="" placeholder="Email"  value="{{$clients['email']}}">
                    </div>

                    <div class="form-group">
                        <label for="">Point of contact First Name and Last Name</label>
                        <textarea name="fnameandlname" class="form-control" placeholder="Point of contact First Name and Last Name"  value="{{$clients['pointof_fname_and_lastname']}}"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Point of contact Email Address</label>
                        <input type="email" name="pemail" class="form-control" id="" placeholder="Point of contact Email Address"  value="{{$clients['pointof_email']}}">
                    </div>

                    <div class="form-group">
                        <label for="">Subdomains</label>
                        <input type="test" name="subdomains[]" class="form-control" id="tags_1" placeholder=""  value="">
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Prefix Code</label>
                        <input type="text" name="prefixcode" class="form-control" id="" placeholder="Prefix Code"  value="{{$clients['prefix_code']}}">
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="isage"> Is checkAge
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="">Agreement Text</label>
                        <textarea name="agreement" class="form-control" placeholder="Agreement Text" value="{{$clients['agreement_text']}}"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Logo</label>
                                <input type="file" name="logo_image" id="logoInput">
                                <p class="help-block">250 x 250 px.</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <img id="logo" src="/logo/{{$clients['logo']}}" alt="logo image"  width="100%"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="">Header Color</label>
                        <input type="text" name="headercolor" class="form-control jscolor" id=""
                               placeholder="Header Color"  value="{{$clients['header_color']}}">
                    </div>

                    <div class="form-group">
                        <label for="">Footer Color</label>
                        <input type="text" name="footercolor" class="form-control jscolor  `AZ1Q" id=""
                               placeholder="Footer Color"  value="{{$clients['footer_color']}}">
                    </div>
                </div>


                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Update Corporate Client</button>
                </div>

            </form>
        </div>


    </div>
</div>



@stop


