<!--
Author: Wei Fang
Date: Mar. 9th
Function: 根据收藏类型分别显示不同标题链接
-->
<?php $this->load->view('my_account/includes/view_watch_list_bar'); ?>
    <?php
    if (!empty($my_watch_list_posts)) {
        foreach ($my_watch_list_posts as $wl):
            ?>
            <div class="article-preview-block">
                <div class="clearfix">
                    <div class="article-title pull-left">
                        <a href="<?= base_url() . 'posts/show_post/' . $wl['PostID'] ?>">
                            <?= $wl['Title']; ?>
                        </a>
                    </div>
                    <p><span class="button-title" onclick="watch_list('<?= $wl['PostID'] ?>', this, 1,'post');"><?= lang('unstow') ?></span></p>
                </div>
                <div class="author-date-bar">
                    <ul>
                    <li><?= readable_time_format($wl['CreatedOn'],'ymd')?></li>
        <!--                <li>241 Like | 84 Shares</li>-->
                    </ul>
                </div>   
                <div class="content-preview"><a href="<?= base_url() . 'posts/show_post/' . $wl['PostID']  ?>"><?= $wl['Summary']; ?></a></div>

            </div>
            
            <?php
        endforeach;
        echo $pagination;
    }else {
        echo lang('no_follow');
    }
    ?>