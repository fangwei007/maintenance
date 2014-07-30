<div class="margin-bot"><span class="setting-title"><?= lang('follower_follwing')?></span></div>
<?php $this->load->view('my_account/includes/view_follower_bar');?>
<ul class="user-ulist">
    <?php
        if(!empty($my_followers)){
        foreach($my_followers as $u): 
    ?>
    <li>
        <a href="<?= base_url() . 'profile/user_profile/' . $u['Nickname']?>">
        <div class="user-list-headpic">
            <img src="<?= base_url() . 'assets/images/users_avatar/' . insert_before_extension($u['Avatar'], '_large')?>" alt="user avatar" />
        </div>
        </a>
        <div class="user-list-body">
            <span class="author"><a href="<?= base_url() . 'profile/user_profile/' . $u['Nickname']?>"><?= isset($u['Nickname']) ? $u['Nickname'] : ''?></a></span>
            <p><span class="button-title" onclick="follow('<?= $u['UserID']?>', this, 1);"><?= lang('unfollow')?></span></p>
        </div>
    </li>
    <?php 
        endforeach;
        echo $pagination;
        }else{
            echo lang('no_follow');
        }
    ?>
    
</ul>