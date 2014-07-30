<div class="margin-bot"><span class="setting-title"><?= lang('reset_pwd') ?></span></div>
    <?php
    echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
    if (isset($client_email))
        echo "<div class=\"alert alert-success\"><p>用户 " . $client_email . "的密码被重置为 <strong>" . $client_password . "</strong></p></div>";
    ?>

<p><a href="<?php echo site_url('admin/manage_users') ?>">回到用户管理</a></p>