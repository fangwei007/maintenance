<div class="margin-bot"><span class="setting-title"><?= lang('published_position')?></span></div>
<?php $this->load->view('my_account/includes/view_inbox_bar');?>
<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
?>

<?php if(!empty($published_positions_list)){ ?>
    <?php
    foreach($published_positions_list as $key => $value):                 
        $position_id = $value['PositionID'];
    ?>
    <div class="article-preview-block">
        <div class="posts-toolbar">
            <a target="_blank" href="<?php echo base_url() . 'positions/show_position/' . $position_id ?>"><?= lang('preview')?></a>
            <a href="<?php echo base_url() . 'my_account/edit_position/' . $position_id ?>"><?= lang('edit')?></a>
            <a href="<?php echo base_url() . 'my_account/delete_position/' . $position_id ?>"><?= lang('delete')?></a>
        </div>
        <div class="clearfix">
            <div class="article-title pull-left"><a href="<?php echo base_url() . 'my_account/edit_position/'
                             . $position_id ?>"><?= $value['Title']?></a>
            </div>
        </div>
        <div class="author-date-bar">
            <ul>
            <li><?= readable_time_format($value['CreatedOn'],'ymd')?></li>
<!--                <li>241 Like | 84 Shares</li>-->
            </ul>
        </div>   
        <div class="content-preview"><?= $value['Description']?></div>

    </div>
    <?php
     endforeach;
    ?>

<?php echo $pagination; ?>
<?php }else{
    echo lang('no_post');
} ?>

