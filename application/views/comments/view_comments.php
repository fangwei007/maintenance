<?php if(!empty($comments)){
        foreach($comments as $c){
?>
        <div class="media comment-cell">
            <a class="pull-left" href="#">
                <img class="media-object" src="<?= base_url().'assets/images/users_avatar/'.insert_before_extension($c['Avatar'],'_medium')?>" alt="<?= $c["Nickname"]?>">
            </a>
            <div class="media-body">
                <div class="media-heading comment-user-name">
                    <a href="<?= base_url().'profile/user_profile/'.$c["Nickname"]?>"><?= $c["Nickname"]?></a>
                    <?php if(isset($c['ReplyToName'])):?>
                    <?= lang('reply')?> <a href="<?= base_url().'profile/user_profile/'.$c["ReplyToName"]?>"><?= $c["ReplyToName"]?></a>
                    <?php endif; ?>
                </div>
                <div class="comment-body"><?= $c["Body"]?></div>
                <div class="comment-toolbar">
                    <div class="comment-time"><?= readable_time_format($c["InsertDate"])?></div>
                    <?php if(cur_user_id() === $c['UserID'] || in_array(cur_user_role(), $this->config->item('manage_posts'))):?>
                        <span onclick="delete_comment(<?= $c["CommentID"] . ",'" . $c["PostType"] . "'," . $c["PostID"]?>);"><?= lang('delete')?></span>
                    <?php endif; ?>
                    <?php if(cur_user_id()){ ?>
                        <span onclick="show_reply_area(<?= $c['CommentID']?>);"><?= lang('reply')?></span>
                    <?php }else{ ?>
                        <span class="log-in"><?= lang('reply')?></span>
                    <?php } ?>
                </div>
                
                <div class="comment-area" id="reply-<?= $c['CommentID']?>" style="display:none">
                    <form id="submit-comment-form-<?= $c['CommentID']?>" method="POST" action="<?= base_url() . "comments/add_comment/" . $c["PostID"] . "/" . $c["PostType"]?>">
                        <input type="hidden" name="reply_to_comment" value="<?= $c['CommentID']?>" />
                        <input type="hidden" name="reply_to_user" value="<?= $c['UserID']?>" />
                        <textarea placeholder="回复<?= $c["Nickname"]?>:" name="comment"></textarea>
                        <div class="pull-right"><button onclick="reply_comment(<?= $c['CommentID']?>);" class="btn btn-default"><?= lang('reply')?></button></div>
                    </form>
                </div>
                
            </div>
        </div>
        <?php } ?>
<?php }else{ ?>
    <?= lang("no_comment") ?>
<?php } ?>

