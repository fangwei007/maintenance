<?php
    if(isset($message)) {
            echo '<p class="message">' . $message . '</p>';
    }
if(isset($users_list)&&!empty($users_list)): 
?>
<table border="1">
    <thead>
        <tr>
        <?php
        foreach($users_list as $key => $value){
            foreach($value as $column_name => $column_value){
                if($column_name != "Password" && $column_name != "UserID"){echo "<th>" . $column_name . "</th>";}
            }
            break;
        }
        ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($users_list as $key => $value){
            $user_id = $value['UserID'];
            echo "<tr>";
            foreach($value as $column_name => $column_value){
                if($column_name != "Password" && $column_name != "UserID"){
                    if($column_name == "Name"){
                        echo '<td><a href="' . base_url() . 'admin/manage_users/edit_client/'
                             . $user_id . '">' . $column_value . "</a></td>";
                    }else{
                        echo "<td>" . $column_value . "</td>";
                    }
                }
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php endif; ?>