<div class="margin-bot"><span class="setting-title"><?= lang('deleted_position')?></span></div>
<?php $this->load->view('my_account/includes/view_inbox_bar');?>

<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
?>

<?php if (!empty($deleted_positions_list)){ ?>
    <?php
    foreach ($deleted_positions_list as $key => $value):
        $position_id = $value['PositionID'];
        ?>
        <div class="article-preview-block">
            <div class="clearfix">
                <div class="article-title pull-left"><?= $value['Title']?>
                </div>
                <div class="pull-right"><a href=<?= base_url() . 'my_account/restore_position/' . $position_id?>><?= lang('restore')?></a>
                    <a onclick="return confirm('<?=  lang('confirm_delete_msg')?>');"href=<?= base_url() . 'my_account/perm_delete_position/'. $position_id ?>><?= lang('perm_delete')?></a>
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
    <?php endforeach; ?>

    <?php echo $pagination; ?>
<?php }else{
    echo lang('no_deleted_post');
} ?>


