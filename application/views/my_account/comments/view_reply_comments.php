<?php
    if (!empty($comments)) {
        foreach ($comments as $c):
            ?>
            <div class="comment-preview-block">
                <a href="<?= base_url() . 'profile/user_profile/' . $c['Replyer']?>"><?= $c['Replyer']?></a> 回复了我：
                <?= truncate_string($c['Body'], 200)?>
                <p>原文： </p>
                <div class="comment-post-title">
                    <a href="<?= base_url() . (($c['PostType'] === 'post') ? 'posts/show_post/' : 'positions/show_position/') . $c['PostID'] ?>">
                        <?= isset($c['PostTitle']) ? $c['PostTitle'] :'' ?>
                    </a>
                </div>
                <p><?= readable_time_format($c['InsertDate']) ?></p>

            </div>
            
<?php
        endforeach;
        echo $pagination;
    }else {
        echo lang('no_comment');
    }
?>