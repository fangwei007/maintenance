<div class="margin-bot"><span class="setting-title"><?= lang('published_post')?></span></div>
<?php $this->load->view('my_account/includes/view_inbox_bar');?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
?>

<?php if(!empty($published_posts_list)){ ?>
    <?php
    foreach($published_posts_list as $key => $value):                 
        $post_id = $value['PostID'];
    ?>
    <div class="article-preview-block">
        <div class="posts-toolbar">
            <a target="_blank" href="<?php echo base_url() . 'posts/show_post/' . $post_id ?>"><?= lang('preview')?></a>
            <a href="<?php echo base_url() . 'my_account/edit_post/' . $post_id ?>"><?= lang('edit')?></a>
            <a href="<?php echo base_url() . 'my_account/delete_post/' . $post_id ?>"><?= lang('delete')?></a>
        </div>
        <div class="clearfix">
            <div class="article-title pull-left"><a href="<?php echo base_url() . 'my_account/edit_post/'
                             . $post_id ?>"><?= $value['Title']?></a>
            </div>
            <div class="pull-right"><?= lang($value['Category']) . lang($value['Type'])?></div>
        </div>

        <div class="author-date-bar">
            <ul>
            <li><?= readable_time_format($value['CreatedOn'],'ymd')?></li>
<!--                <li>241 Like | 84 Shares</li>-->
            </ul>
        </div>   
        <div class="content-preview"><?= $value['Summary']?></div>

    </div>
    <?php
     endforeach;
    ?>

<?php echo $pagination; ?>
<?php }else{
    echo lang('no_post');
} ?>

