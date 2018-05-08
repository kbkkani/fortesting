            <div class="login_box">
            <div class="box">
                <div class="content-wrap">
                    <form class="login-form" method="post" id="formlogin">
                        <div class="form-group">
                            <input type="text" class="form-control col-12 req" id="userId" name="userId" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control col-12 req" name="password" id="password" placeholder="Password">
                        </div>
                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >
                        <div class="row tr">
                            <div class="col-md-4 col-xs-12">
                                <button type="submit" class="log_btn" > <i class="icon-signin"></i> Log in </button>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <a type="button" class="spec_btn" data-toggle="modal" data-target="#dvforgot_username"> <i class="icon-user"></i> Forgot username? </a>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <a type="button" class="spec_btn" data-toggle="modal" data-target="#forgot_password"> <i class="icon-lock"></i> Forgot password? </a>
                            </div>
                        </div>
                        <div class="row bt">
                            <div class="col-xs-12 no-pad">

                                <button class="btn btn-glow primary spec_reg_btn" type="button" data-toggle="modal" data-target="#create_account"> <i class="icon-user"></i> Register</button>
                            </div>
                        </div>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
        </div>