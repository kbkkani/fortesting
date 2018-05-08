<div class="modal fade"  id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="forgot_password_lbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" id="forgot_pw" action="" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="forgot_password_lbl"><i class="icon-user"></i> Reset password</h4>
                </div>

                <div class="modal-body">
                    <p>If you know your username, please enter it below. If not, please click the "Forgot username" button to reset your password.</p>

                        <input name="username" class="form-control" type="text" placeholder="Enter username">
                        <input name="action" type="hidden" value="reset_pw">
                        <div class="response"></div>

                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                <div class="modal-footer">
                    <button class="btn-glow reset_btn primary btn_group_email" formid="forgot_pw"><i class="icon-signin"></i> Reset my password</button>
                </div>
            </form>
        </div>
    </div>
</div>