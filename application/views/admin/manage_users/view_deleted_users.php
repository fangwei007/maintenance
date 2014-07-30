<?php $this->load->view("admin/manage_users/includes/view_manage_users_header");?>
<?php 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php if(isset($error)) echo $error; ?>

<?php if(isset($clients_list)&&!empty($clients_list)): ?>

<table border="1">
    <thead>
        <tr>
            <th> </th>
            <th> </th>
            <th>邮箱</th>
            <!--<th>昵称</th>-->
            <th>状态</th>
            <th>角色</th>
            <th>创建时间</th>
            
         
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($clients_list as $key => $value){
            //$user_id = $value['UserID'];
            echo "<tr>";
            echo '<td><a href="' . base_url() . 'admin/manage_users/restore_user/' . $value['UserID'] . '">'. '还原' .'</a></td>';
            echo '<td><a href="' . base_url() . 'admin/manage_users/perm_delete_user/' . $value['UserID'] . '" onclick="return confirm(\'是否确定删除用户？\');">' . '永久删除' . '</a></td>';
//            echo "<td>" . $value['Email'] . "</td>";
            echo '<td><a href="' . base_url() . 'admin/manage_users/edit_user/' . $value['UserID'] . '">'. $value['Email'] .'</a></td>';
            echo "<td>" . $value['Status'] . "</td>";
            echo "<td>" . lang($value['Role']) . "</td>";
//            echo "<td>" . $value['ExpiresOn'] . "</td>";
            echo "<td>" . readable_time_format($value['CreatedOn'], 'ymd') . "</td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table> 

<?php endif; ?>