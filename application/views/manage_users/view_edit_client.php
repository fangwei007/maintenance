<h2>编辑用户</h2>
<div id="edit_client_form">
    <?php
    echo validation_errors('<p class="error">');
    echo $this->session->flashdata('msg');
    ?>
    <?php $reset_pwd_url = isset($UserID) ? array('admin', 'manage_users', 'reset_password', $UserID) : ''; ?>
    <p><a href="<?php echo site_url($reset_pwd_url) ?>" onclick="return confirm('你要更新用户密码吗？');" >重置密码</a></p>
    <form action="<?php echo site_url('admin/manage_users/edit_client') . '/' . (isset($UserID) ? $UserID : ''); ?>" method="POST">
        <?php if (isset($UserID)): ?>
            <input type="hidden" value="<?php echo $UserID; ?>" name="user_id" />
        <?php endif; ?>

        <div class=formTitle>邮箱：</div>
        <div class=formLine>
            <input type="email" value="<?php if (isset($Email)) {
            echo $Email;
        } ?>" name="email" />
        </div>&nbsp;


        <div class=formTitle>昵称：</div>
        <div class=formLine>
            <input type="text" value="<?php if (isset($Nickname)) {
            echo $Nickname;
        } ?>" name="nickname" class="txtForm"/>
        </div>&nbsp;

        <div class=formTitle>状态：</div>
        <div class=formLine>
            <select name="status" id="status">
                <option value="" <?php if ($Status == '') echo ' selected="selected"'; ?>>Select a Status</option>
                <option value="A" <?php if ($Status == 'A') echo ' selected="selected"'; ?>>Activated</option>
                <option value="N" <?php if ($Status == 'N') echo ' selected="selected"'; ?>>Inactivate</option>
                <option value="S" <?php if ($Status == 'S') echo ' selected="selected"'; ?>>Suspended</option>
                <option value="D" <?php if ($Status == 'D') echo ' selected="selected"'; ?>>Deleted</option>
            </select>
        </div>&nbsp;

<?php if ($this->session->userdata('role') === 'superman'): ?> <!-- Only super admin can see this option-->
            <div class=formTitle>角色：</div>
            <div class=formLine>
                <select name="type" id="type">
                    <option value="client" <?php if ($Role == 'client') echo ' selected="selected"'; ?>>Client</option>
                    <option value="admin" <?php if ($Role == 'admin') echo ' selected="selected"'; ?>>Administrator</option>
                    <option value="c_editor" <?php if ($Role == 'c_editor') echo ' selected="selected"'; ?>>Copy Editor</option>
                    <option value="f_editor" <?php if ($Role == 'f_editor') echo ' selected="selected"'; ?>>Financial Editor</option>
                    <option value="franchise" <?php if ($Role == 'franchise') echo ' selected="selected"'; ?>>Franchise</option>
                    <option value="affiliate" <?php if ($Role == 'affiliate') echo ' selected="selected"'; ?>>Affiliate</option>
                    <option value="superman" <?php if ($Role == 'superman') echo ' selected="selected"'; ?>>Super Administrator</option>
                </select>
            </div>&nbsp;
<?php endif; ?>

        <div class=formButtonLine><input type="submit" name="update" value="更新用户" /></div>&nbsp;&nbsp;&nbsp;&nbsp;
        <div class=formButtonLine><a href="<?= site_url('admin/manage_users/'); ?>">回到用户管理</a></div>
    </form>

</div>
