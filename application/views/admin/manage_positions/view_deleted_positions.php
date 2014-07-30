<?php $this->load->view("admin/manage_positions/includes/view_manage_positions_header");?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : ''; 
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<?php if (isset($deleted_positions_list) && !empty($deleted_positions_list)){ ?>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
<!--                <th>AuthorID</th>-->
                <th>Created On</th>
                <th>Level</th>

                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deleted_positions_list as $key => $value):
                $position_id = $value['PositionID'];
                ?>
                <tr>
                    <td><a href="<?php
                        echo base_url() . 'admin/manage_positions/edit_position/'
                        . $position_id
                        ?>"><?= $value['Title'] ?></a></td>
                    <td><?= $value['CreatedOn'] ?></td>
                    <td><?= $value['Level'] ?></td>
                    <td><a href="<?=
                        base_url() . 'admin/manage_positions/restore_position/'
                        . $position_id
                        ?>" onclick="return confirm('确定恢复吗？')">Restore</a></td>
                    <td><a href="<?=
                        base_url() . 'admin/manage_positions/perm_delete_position/'
                        . $position_id
                        ?>" onclick="return confirm('确定删除吗？')">Delete</a></td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <div class="positions_pagination"><?= $pagination; ?></div>
<?php }else{
    echo lang('no_deleted_post');
} ?>
