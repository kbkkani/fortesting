<div class="modal fade"  id="create_account" tabindex="-1" role="dialog" aria-labelledby="create_account_lbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" id="register_acc" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="create_account_lbl"><i class="icon-user"></i> Create new account</h4>
                </div>

                <div class="modal-body">
                    <div class="register_account">
                        <div class="alert alert-warning">
                            <i class="icon-warning-sign"></i>
                            All fields are required.
                        </div>
                        <div class="form-group">
                            <label for="emailAddress" class="col-sm-3 control-label">E-mail:</label>
                            <div class="col-sm-8"><!--Changed the class to sm-8 (all of them)-->
                                <input type="email" class="form-control req" id="emailAddress" name="emailAddress" placeholder="Email address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Username:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control req" id="username" name="username" placeholder="Username" readonly >
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="chkusername" name="chkusername" value="" checked >
                                        Same as e-mail
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title:</label>
                            <div class="col-sm-8">
                                <select name="title" class="col-sm-12 req ddl">
                                    <option value="">Please select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Mrs">Miss</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="givenName" class="col-sm-3 control-label">Full/legal First Name :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control req" id="givenName" name="givenName" placeholder="Full/legal First Name ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="surname" class="col-sm-3 control-label">Full/legal Surname:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control req" id="surname" name="surname" placeholder="Full/legal Surname">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dob" class="col-sm-3 control-label">Date of birth:</label>
                            <div class="col-sm-8">
                                <div class='input-group date' id='datetimepicker_dob'>
                                    <input id="dob" name="dob" type='text' class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pwd" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" id="pwd" class="form-control req" name="password" placeholder="">
                            </div>
                        </div>

                        <div class="form-group last"><!--new class last-->
                            <label for="verifyPassword" class="col-sm-3 control-label">Verify password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control req" id="verifyPassword" name="verifyPassword" placeholder="">
                            </div>
                        </div>
                        <div class="response">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="organisation" value="Life Saving Victoria Ltd">
                    <input type="hidden" id="courseInstanceID" value="">
                    <button type="submit" class="register_btn btn-glow primary btn_group_email"><i class="icon-signin"></i> Register Account</button>
                    <button type="button" class="btn-glow close_btn" data-dismiss="modal" aria-hidden="true">Close<!--removed x--></button>
                </div>
                <input type="hidden" value="register" name="action" />
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >
            </form>
        </div>
    </div>
</div>