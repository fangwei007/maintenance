<?php $this->load->view("admin/manage_users/includes/view_manage_users_header");?>
<?php 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : ''; 
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<?php if(isset($clients_list)&&!empty($clients_list)): ?>
<div class="search_tab">
    <h2>用户查询</h2>
<form action="<?php echo site_url('admin/manage_users/search_users') ?>" method="POST">
    <table width="100%" cellpadding="0" cellspacing="0" class="admin_search table">
        <tr>
            <td class="formTitle" width="150">
                <label for="email_search">邮箱：</label>&nbsp;
            </td>
            <td width="150">
                <input type="text" name="email_search" id="email_search" value="" placeholder="">
            </td>

            <td class="formTitle" >
                <label for="name_search">用户昵称：</label>&nbsp;
            </td>
            <td>
                <input type="text" name="name_search" id="name_search" value="" placeholder="昵称">
            </td>
        </tr>

        <tr>
           
            <td class="formTitle" >
                <label for="status_search">状态：</label>&nbsp;
            </td>
            <td>
            <select name="status_search" id="status_search">
                <option value="" >All</option>
                <option value="A" >Activated</option>
                <option value="N" >Inactivate</option>
                <option value="S" >Suspended</option>
                <option value="D" >Deleted</option>
            </select>
            </td>
        </tr>
        
<!--        <tr>

            <td class="formTitle" >
            <label for="fromDate_search">创建日期范围：</label>&nbsp;
            </td>
            <td>
            <input type="text" class="input-datepicker" id="fromDate_search" name="fromDate_search" value="" />
            &nbsp;to&nbsp;
            <input type="text" class="input-datepicker" id="toDate_search" name="toDate_search" value="" />
            
            <input type="hidden" name="fromDate_search" value=""/>
            <input type="hidden" name="toDate_search" value=""/>
            
            </td>
        </tr>-->
            
        
    </table>
    <input type="submit" name="search" value="查询" />
</form>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<table border="1">
    <thead>
        <tr>
            <th> </th>
            <th>邮箱</th>
            <th>状态</th>
            <th>角色</th>
            <th>创建时间</th>
            
            
        <?php
//        foreach($clients_list as $key => $value){
//            foreach($value as $column_name => $column_value){
//                if($column_name != "Password" && $column_name != "UserID"){echo "<th>" . $column_name . "</th>";}
//            }
//            break;
//        }
        ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($clients_list as $key => $value){
            //$user_id = $value['UserID'];
            echo "<tr>";
            echo '<td><a href="' . base_url() . 'admin/manage_users/delete_user/' . $value['UserID'] . '" onclick="return confirm(\'是否确定删除用户？\');">' . 'Delete' . '</a></td>';
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

<div id="users_pagination"><?php echo $pagination; ?></div>   

<?php endif; ?>