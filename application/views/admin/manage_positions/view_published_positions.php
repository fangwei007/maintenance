<?php $this->load->view("admin/manage_positions/includes/view_manage_positions_header");?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : ''; 
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<?php if(isset($published_positions_list)&&!empty($published_positions_list)){ ?>

<table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Created On</th>
            <th>Level</th>
            
            <th> </th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($published_positions_list as $key => $value):                 
            $position_id = $value['PositionID'];
        ?>
            <tr>
                <td><a href="<?= base_url() . 'admin/manage_positions/edit_position/'
                             . $position_id ?>"><?= $value['Title']?></a></td>
                <td><?= $value['CreatedOn']?></td>
                <td><?= $value['Level']?></td>
                <td><a href="<?= base_url() . 'admin/manage_positions/delete_position/'
                             . $position_id?>" onclick="return confirm('是否确定删除文章？');">Delete</a></td>
            </tr>
        <?php
         endforeach;
        ?>
    </tbody>
</table>
<div class="positions_pagination"><?= $pagination; ?></div>
<?php }else{
    echo lang('no_position');
} ?>

