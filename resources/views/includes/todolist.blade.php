<div class="modal fade"  id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="todolist_lbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" id="todolist" action="" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-user"></i> Todo List</h4>
                </div>

                <div class="modal-body">
                    <p>If you know your username, please enter it below. If not, please click the "Forgot username" button to reset your password.</p>

                    <input name="header" class="form-control" type="text" placeholder="Enter Title">

                    <input name="description" class="form-control" type="textarea" placeholder="Enter Description">

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