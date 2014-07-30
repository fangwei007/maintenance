<?php $this->load->view("admin/manage_posts/includes/view_manage_posts_header"); ?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php if (isset($videos) && !empty($videos)){ ?>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Category</th>
                <th>Created On</th>
                <th>Level</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($videos as $key => $value):
                $post_id = $value['PostID'];
                ?>
                <tr>
                    <td><a href="<?= base_url() . 'admin/manage_posts/edit_post/'
        . $post_id
                ?>"><?= $value['Title'] ?></a></td>
                    <td><?= lang($value['Type']) ?></td>
                    <td><?= lang($value['Category']) ?></td>
                    <td><?= readable_time_format($value['CreatedOn'],'ymd') ?></td>
                    <td><?= $value['Level'] ?></td>
                    <td><a href="<?= base_url() . 'admin/manage_posts/delete_post/'
                   . $post_id
                   ?>" onclick="return confirm('是否确定删除该视频？');">Delete</a></td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
<div class="posts_pagination"><?= $pagination; ?></div>
<?php }else{
    echo lang('no_post');
} ?>