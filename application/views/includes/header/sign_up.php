<div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog popup-center">
        <div class="popup-title"><b>现在注册，成为一名比橙客吧！</b></div>
        <div class="modal-content">

        <div class="modal-body clearfix">
            <div class="row">
                <div class="col-md-5">
                    <form class="form-horizontal" id="sign-up-form" role="form" action="<?= base_url(); ?>register/register_user" method="POST">
                        <div class="sign-form-title"><b><?= lang('register')?></b></div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div id="validation-email-error"></div>
                                <input type="email" name="email" class="form-control input-sm" placeholder="邮箱" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div id="validation-nickname-error"></div>
                                <input type="text" name="nickname" class="form-control input-sm" placeholder="昵称 (只限中英文及数字)" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div id="validation-password-error"></div>
                                <input type="password" name="password" class="form-control input-sm" placeholder="密码" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div id="validation-passconf-error"></div>
                                <input type="password" name="passconf" class="form-control input-sm" placeholder="再次输入密码" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-md-4">
                            <label class="checkbox">
                              <input type="checkbox" name="remember_me"> 记住我
                            </label>
                        </div>
                        <div class="col-md-5" style="margin-top:6px;">
                            <a href="/about_us/terms" target="_blank">查看用户使用协定</a>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                              <button data-loading-text="<?= lang("signing_up")?>" id="signup-btn" type="submit" name="submit" class="btn btn-yellow">注册</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-body -->

        </div><!-- /.modal-content -->
        <div class="clearfix">
            <a href="<?= base_url();?>register/register_official_user/industry"><div class="popup-title pull-left"><b>初创公司注册</b></div></a>
<!--            <a href="<?= base_url();?>register/register_official_user/school"><div class="popup-title pull-right"><b>学校账号注册</b></div></a>-->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->