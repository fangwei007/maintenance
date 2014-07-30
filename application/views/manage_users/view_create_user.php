<h2>创建新用户</h2>
<?php
    if(isset($message)) {
            echo '<p class="message">' . $message . '</p>';
    }
    echo $this->session->flashdata('msg');
?>
<div id="create_user_form">
    <form action="<?php echo site_url('admin/manage_users/create_user') ?>" method="POST">
        <div class=formTitle>邮箱：</div>
        <div class=formLine><input type="email" class="required" value="<?php echo set_value('email'); ?>" name="email" /></div>

        <div class=formTitle>昵称：</div>
        <div class=formLine><input type="text" value="<?= set_value('nickname'); ?>" name="nickname" class="txtForm"/></div>
        
        <div class=formTitle>密码：</div>
        <div class=formLine><input type="password" class="required" name="password" /></div>
        
        <div class=formTitle>密码再次：</div>
        <div class=formLine><input type="password" class="required" name="passconf" /></div>
        
        <?php if($this->session->userdata('role') === 'superman'): ?> <!-- Only super admin can see this option-->
        <div class=formTitle>用户类型：</div>
        <select name="role" id="role">
            <option value="client">Client</option>
            <option value="admin">Administrator</option>
            <option value="c_editor">Copy Editor</option>
            <option value="f_editor">Financial Editor</option>
            <option value="franchise">Franchise</option>
            <!-- <option value="affiliate">Affiliate</option> -->
            <option value="superman">Super Administrator</option>
        </select>
        <?php endif; ?>
        <div class=formButtonLine><input type="submit" name="create" value="创建" /></div>&nbsp;&nbsp;
        <p><a href="<?php echo site_url('admin/manage_users') ?>">回到用户管理</a></p>
    </form>
    <?php 
    echo validation_errors('<p class="error">'); 
    if(isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
</div>
