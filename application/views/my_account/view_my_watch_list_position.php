<!--
Author: Wei Fang
Date: Mar. 9th
Function: 根据收藏类型分别显示不同标题链接
-->
<?php $this->load->view('my_account/includes/view_watch_list_bar'); ?>
    <?php
    if (!empty($my_watch_list_positions)) {
        foreach ($my_watch_list_positions as $wl):
            ?>
            <div class="article-preview-block">
                <div class="clearfix">
                    <div class="article-title pull-left">
                        <a href="<?= base_url() . 'positions/show_position/' . $wl['PositionID'] ?>">
                            <?= $wl['Title']; ?>
                        </a>
                    </div>
                    <p><span class="button-title" onclick="watch_list('<?= $wl['PositionID'] ?>', this, 1,'position');"><?= lang('unstow') ?></span></p>
                </div>
                <div class="author-date-bar">
                    <ul>
                    <li><?= readable_time_format($wl['CreatedOn'],'ymd')?></li>
                    </ul>
                </div>   
                <div class="content-preview"><a href="<?= base_url() . 'positions/show_position/' . $wl['PositionID']  ?>"><?= truncate_string($wl['Description'], 30); ?></a></div>

            </div>
            <?php
        endforeach;
        echo $pagination;
    }else {
        echo lang('no_follow');
    }
    ?>