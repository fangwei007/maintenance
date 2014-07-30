<?php
if ($this->session->flashdata('msg')) {
    echo $this->session->flashdata('msg');
}
?>

<?php if (isset($deleted_posts_list) && !empty($deleted_posts_list)): ?>
    <h2>回收站里的文章</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Category</th>
                <th>AuthorID</th>
                <th>Created On</th>
                <th>Summary</th>
                <th>Content</th>
                <th>Video link</th>
                <th>Updated on</th>
                <th>Image</th>
                <th>Level</th>

                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deleted_posts_list as $key => $value):
                $post_id = $value['PostID'];
                ?>
                <tr>
                    <td><a href="<?php
                        echo base_url() . 'admin/manage_posts/edit_post/'
                        . $post_id
                        ?>"><?= $value['Title'] ?></a></td>
                    <td><?= $value['Type'] ?></td>
                    <td><?= $value['Category'] ?></td>
                    <td><?= $value['AuthorID'] ?></td>
                    <td><?= $value['CreatedOn'] ?></td>
                    <td><?= $value['Summary'] ?></td>
                    <td><?= $value['Content'] ?></td>
                    <td><?= $value['VideoLink'] ?></td>
                    <td><?= $value['UpdatedOn'] ?></td>
                    <td><?= $value['Image'] ?></td>
                    <td><?= $value['Level'] ?></td>
                    <td><a href="<?=
                        base_url() . 'admin/manage_posts/restore_post/'
                        . $post_id
                        ?>" onclick="return confirm('确定恢复吗？')">Restore</a></td>
                    <td><a href="<?=
                        base_url() . 'admin/manage_posts/perm_delete_post/'
                        . $post_id
                        ?>" onclick="return confirm('确定删除吗？')">Delete</a></td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="posts_pagination"><?= $pagination; ?></div>
<p><a href="<?= site_url('admin/manage_posts') ?>">回到文章管理</a></p>