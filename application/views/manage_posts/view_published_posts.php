<p><a href="<?= site_url('admin/manage_posts/add_post') ?>">发布新文章</a></p>
<p><a href="<?= site_url('admin/manage_posts/show_deleted_posts') ?>">回收站</a></p>
<?php
    if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');}
?>

<?php if(isset($published_posts_list)&&!empty($published_posts_list)): ?>
<h2>所有用户所发表的文章</h2>
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
        foreach($published_posts_list as $key => $value):                 
            $post_id = $value['PostID'];
        ?>
            <tr>
                <td><a href="<?= base_url() . 'admin/manage_posts/edit_post/'
                             . $post_id ?>"><?= $value['Title']?></a></td>
                <td><?= $value['Type']?></td>
                <td><?= $value['Category']?></td>
                <td><?= $value['AuthorID']?></td>
                <td><?= $value['CreatedOn']?></td>
                <td><?= $value['Summary']?></td>
                <td><?= $value['Content']?></td>
                <td><?= $value['VideoLink']?></td>
                <td><?= $value['UpdatedOn']?></td>
                <td><?= $value['Image']?></td>
                <td><?= $value['Level']?></td>
                <td><a href="<?= base_url() . 'admin/manage_posts/delete_post/'
                             . $post_id?>" onclick="return confirm('是否确定删除文章？');">Delete</a></td>
            </tr>
        <?php
         endforeach;
        ?>
    </tbody>
</table>
<?php endif; ?>

<div class="posts_pagination"><?= $pagination; ?></div>