<div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  popup-center">
        <div class="popup-title"><b>欢迎回来，亲爱的比橙客！</b></div>
        <div class="modal-content">

        <div class="modal-body clearfix">
            <div class="row">
                <div class="col-md-5">
                    <form class="form-horizontal" id="sign-in-form" role="form" action="<?= base_url(); ?>login/login_user" method="POST">
                        <div class="sign-form-title"><b>登陆</b></div>
                        <div id ="validation-in-error"></div>
                        <div class="form-group">
                            <div class="col-md-12">
                                 <div id = "validation-in-email-error"></div>
                                <input type="email" name="email" value="<?= isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" class="form-control input-sm" placeholder="邮箱" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div id="validation-in-password-error"></div>
                                <input type="password" name="password" class="form-control input-sm" placeholder="密码" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="checkbox">
                                  <input type="checkbox" name="remember_me"> 记住我
                                </label>
                            </div>
                            <div class="col-md-3" style="margin-top:7px;">
                                <a href="<?= base_url()?>login/reset_password">忘记密码？</a>
                            </div>
                            <div style="margin-top:7px;">
                                <a href="#" id="no-sign-up">没有账号？</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10">
                              <button id="login-btn" type="submit" name="submit" class="btn btn-yellow" data-loading-text="<?= lang("logging")?>"><?= lang("sign_in")?></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->