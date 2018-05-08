<div class="modal fade"  id="validate-modal" tabindex="-1" role="dialog" aria-labelledby="validate_lbl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" id="validate_cert" action="" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="validate_lbl"><i class="icon-user"></i> Validation of Certificate or Statement of Attainment</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="givenName" class="col-sm-3 control-label">Full/legal First Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="req form-control" id="givenNameValidate" name="givenName" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname" class="col-sm-3 control-label">Full/legal Surname:</label>
                        <div class="col-sm-9">
                            <input type="text" class="req form-control" id="surnameValidate" name="surname" placeholder="">
                        </div>
                    </div>

                    <style>
                        .form-group .grouped-field { width: auto; text-align: center; border: 1px solid #CCC; float: left; }
                        .form-group span { float: left; display: inline-block; margin-left: .25em; margin-right: .25em;}
                    </style>

                    <div class="form-group">
                        <label for="phoneNumberParts" class="col-sm-3 control-label">Certificate ID</label>
                        <div class="col-sm-9" style="padding-left:8px;">
                            <span class="form-control-static"></span>
                            <input type="text" class="form-control grouped-field req"  name="id1" id="certPrefix" placeholder="XXXXXXX" size="7" maxlength="7">
                            <span class="form-control-static">-</span></dd>
                            <dd><input type="text" class="form-control grouped-field req" name="id3"  id="certPrefix" placeholder="XXXXXXX" size="7" maxlength="7"></dd>
                        </div>
                    </div>

                    <div class="response"></div><br>
                    <div class="alert alert-info"><!--new b tag--><b>Note:</b> Online validation is available for Certificate or Statement of Attainment issued after 1 July 2015. For validation of certificates before this date, please contact us via email: training@lsv.com.au or phone: (03) 9676 6950. </div>
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >

                <div class="modal-footer">
                    <button class="btn-glow primary cert_btn btn_group_email" formid="validate_cert"><i class="icon-signin"></i> Validate</button>
                    <button type="button" class="btn-glow close_btn" data-dismiss="modal" aria-hidden="true">Close<!--removed x--></button>
                </div>

            </form>
        </div>
    </div>

</div>