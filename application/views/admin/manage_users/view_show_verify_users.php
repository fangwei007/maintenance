<?php $this->load->view("admin/manage_users/includes/view_manage_users_header"); ?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php $status = $this->uri->segment(4); ?>
<ul class="nav nav-pills">
    <li class="<?= ($status === "") ? 'active' : '' ?>"><a href="<?= base_url() ?>admin/manage_users/show_verify_users">所有用户</a></li>
    <li class="<?= ($status === "N") ? 'active' : '' ?>"><a href="<?= base_url() ?>admin/manage_users/show_verify_users/N">未审核用户</a></li>
    <li class="<?= ($status === "A") ? 'active' : '' ?>"><a href="<?= base_url() ?>admin/manage_users/show_verify_users/A">审核中用户</a></li>
    <li class="<?= ($status === "F") ? 'active' : '' ?>"><a href="<?= base_url() ?>admin/manage_users/show_verify_users/F">审核失败</a></li>
    <li class="<?= ($status === "S") ? 'active' : '' ?>"><a href="<?= base_url() ?>admin/manage_users/show_verify_users/S">审核通过</a></li>
</ul>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if (isset($clients_list) && !empty($clients_list)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>用户名称</th>
                <th>申请状态</th>
                <th>用户类型</th>
                <th>申请创建时间</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clients_list as $key => $value) {
                echo "<tr>";
                echo '<td><a href="' . base_url() . 'admin/manage_users/verify_user/' . $value['VerifyUserID'] . '">' . $value['Nickname'] . '</a></td>';
                echo "<td>" . $value['VerifyStatus'] . "</td>";
                echo "<td>" . lang($value['Role']) . "</td>";
                echo "<td>" . readable_time_format($value['VerifyCreatedOn'], 'ymd h:i:s') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div id="users_pagination"><?php echo $pagination; ?></div>   

<?php endif; ?>