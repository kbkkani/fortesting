<div class="modal fade"  id="dvforgot_username" tabindex="-1" role="dialog" aria-labelledby="forgot_username_lbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" id="forgot_username" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="forgot_username_lbl"><i class="icon-user"></i> Request username</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="givenName" class="col-sm-3 control-label">Full/legal First Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="req form-control" id="givenFirstName" name="givenFirstName" placeholder="Full/legal First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname" class="col-sm-3 control-label">Full/legal Surname:</label>
                        <div class="col-sm-9">
                            <input type="text" class="req form-control" id="legalSurname" name="legalSurname" placeholder="Full/legal Surname">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email address:</label>
                        <div class="col-sm-9">
                            <input type="email" class="req form-control" id="emailUser" name="emailUser" placeholder="E-mail address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dob" class="col-sm-3 control-label">Date of birth:</label>
                        <div class="col-sm-6">
                            <div class='input-group date' id='datetimepicker_dobuser'>
                                <input id="dobUser" name="dobUser" type='text' class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="response"></div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >
                </div>

                <div class="modal-footer">
                    <button class="btn-glow primary btn_group_email" formid="forgot_username"><i class="icon-signin"></i> Request for username</button>
                    <button type="button" class="btn-glow close_btn" data-dismiss="modal" aria-hidden="true">Close<!--removed x--></button>
                </div>
            </form>
        </div>
    </div>
</div>
