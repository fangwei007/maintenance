<div class="post-toolbar">
    <?php if(in_array(get_user_session('role'),$this->config->item('manage_posts'))){ ?>
        <a href="<?= base_url() . 'admin/manage_posts/edit_post/' . $post->PostID?>"><span class="button-title"><?= lang('edit')?></span></a>  
    <?php }elseif(isset($author_info->UserID)&&get_user_session('user_id') === $author_info->UserID){ ?>
        <a href="<?= base_url() . 'my_account/edit_post/' . $post->PostID?>"><span class="button-title"><?= lang('edit')?></span></a>
    <?php } ?> 
        
    <?php if ($this->session->userdata('logged_in')) { ?>
        <?php if (empty($post->Stow)) { ?>
            <span class="button-title-danger" onclick="watch_list('<?= $post->PostID ?>', this, 0, 'post');"><?= lang('stow') ?></span>
        <?php } else { ?>
            <span class="button-title" onclick="watch_list('<?= $post->PostID ?>', this, 1, 'post');"><?= lang('unstow') ?></span>
        <?php } ?>
    <?php } else { ?>
        <span class="button-title-danger log-in"><?= lang('stow') ?></span>
    <?php } ?>
</div>