<h2>密码重置</h2>

<?php
if(isset($error)) {
    echo '<p class="error">' . $error . '</p>';
}
//    echo $this->session->flashdata('msg');
if(isset($client_email)) echo "<p>用户 " . $client_email . "的密码被重置为 <strong>" . $client_password . "</strong></p>";
?>

<p><a href="<?php echo site_url('admin/manage_users') ?>">回到用户管理</a></p>