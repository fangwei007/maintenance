<?php
    if (!empty($comments)) {
        foreach ($comments as $c):
            ?>
            <div class="comment-preview-block">
                <p>我发布的：</p>
                <div class="comment-post-title">
                    <a href="<?= base_url() . (($c['PostType'] === 'post') ? 'posts/show_post/' : 'positions/show_position/') . $c['PostID'] ?>">
                        <?= $c['Title']; ?>
                    </a>
                </div>
                <div class="comment-meta">收到评论(<?= $c['total_comments']?>)条 </div>

            </div>
            
<?php
        endforeach;
        echo $pagination;
    }else {
        echo lang('no_comment');
    }
?>