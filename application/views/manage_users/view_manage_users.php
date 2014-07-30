<p><a href="<?php echo site_url('admin/manage_users/view_users') ?>">查看所有用户</a></p>
<p><a href="<?php echo site_url('admin/manage_users/create_user') ?>">创建新用户</a></p>
<?= $this->session->flashdata('msg'); ?>
<?php if(isset($error)) echo $error; ?>

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
        
        <tr>

            <td class="formTitle" >
            <label for="fromDate_search">创建日期范围：</label>&nbsp;
            </td>
            <td>
            <input type="text" class="input-datepicker" id="fromDate_search" name="fromDate_search" value="" />
            &nbsp;to&nbsp;
            <input type="text" class="input-datepicker" id="toDate_search" name="toDate_search" value="" />
            <!--
            <input type="hidden" name="fromDate_search" value=""/>
            <input type="hidden" name="toDate_search" value=""/>
            -->
            </td>
        </tr>
            
        
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
            <!--<th>昵称</th>-->
            <th>状态</th>
            <th>角色</th>
            <th>创建时间</th>
            <th>创建自</th>
            
            
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
//            echo "<td>" . $value['Email'] . "</td>";
            echo '<td><a href="' . base_url() . 'admin/manage_users/edit_client/' . $value['UserID'] . '">'. $value['Email'] .'</a></td>';
            echo "<td>" . $value['Status'] . "</td>";
            echo "<td>" . $value['Role'] . "</td>";
//            echo "<td>" . $value['ExpiresOn'] . "</td>";
            echo "<td>" . $value['CreatedOn'] . "</td>";
            echo "<td>" . $value['CreatedFrom'] . "</td>";
//            echo "<td>" . $value['CreatedBy'] . "</td>";
//            echo "<td>" . $value['Language'] . "</td>";
//            echo "<td>" . $value['Referrer'] . "</td>";
//            echo "<td>" . $value['Experience'] . "</td>";
//            echo "<td>" . $value['MarketActivity'] . "</td>";
//            echo "<td>" . $value['HomePhone'] . "</td>";
//            echo "<td>" . $value['MobilePhone'] . "</td>";
//            echo "<td>" . $value['Country'] . "</td>";
//            echo "<td>" . $value['State'] . "</td>";
//            echo "<td>" . $value['City'] . "</td>";
//            echo "<td>" . $value['AccessRight'] . "</td>";
//            echo "<td>" . $value['UpdatedBy'] . "</td>";
//            echo "<td>" . $value['UpdatedFrom'] . "</td>";
//            echo "<td>" . $value['UpdatedOn'] . "</td>";
//            echo "<td>" . $value['NewsletterSubscription'] . "</td>";
//            echo "<td>" . $value['Note'] . "</td>";
            
//            foreach($value as $column_name => $column_value){
//                if($column_name != "Password" && $column_name != "UserID"){
//                    if($column_name == "Name"){
//                        echo '<td><a href="' . base_url() . 'manage_users/edit_client/'
//                             . $user_id . '">' . $column_value . "</a></td>";
//                    }else{
//                        echo "<td>" . $column_value . "</td>";
//                    }
//                }
//            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<div id="users_pagination"><?php echo $pagination; ?></div>   

<?php endif; ?>