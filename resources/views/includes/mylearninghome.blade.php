@extends('mylearning')
@section('content')

    <div class="animated fadeIn">
        @include("includes.learning_menu")

        <div class="row mylearninig-search" id="search_panel">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include("includes.search")
                    </div>
                </div>
            </div>
        </div>

        <!-- start current registration table -->
        <div class="tab-pane" id="current_reg">
            <div class="row-fluid" id="my_training">
                <div style="text-align: center; margin-top:100px;">
                </div>
            </div>
        </div>
        <!-- end current registrations table -->

        <!-- start past registration table -->
        <div class="tab-pane" id="complete_reg">
            <div class="row-fluid">

            </div>
        </div>
        <!-- end past registrations table -->

    </div>
@stop