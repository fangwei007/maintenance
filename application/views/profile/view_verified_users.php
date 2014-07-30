<section class="left-content" >
<ol class="breadcrumb_pipe">
    <li class="<?= ($role_type === 'industry') ? 'active' : ''?>"><a href="<?= base_url() . 'profile/verified_users/industry'?>"><?= lang('industry') . lang('official_account')?></a></li>
    <li class="<?= ($role_type === 'school') ? 'active' : ''?>"><a href="<?= base_url() . 'profile/verified_users/school'?>"><?= lang('school') . lang('official_account')?></a></li>
    <li class="<?= ($role_type === 'client') ? 'active' : ''?>"><a href="<?= base_url() . 'profile/verified_users/client'?>"><?= lang('client') . lang('official_account')?></a></li>
</ol>
    

<ul class="user-ulist">
    <?php
        if(!empty($users)){
        foreach($users as $u): 
    ?>
    <li>
        <a href="<?= base_url() . 'profile/user_profile/' . $u['Nickname']?>">
        <div class="user-list-headpic">
            <img src="<?= base_url() . 'assets/images/users_avatar/' . insert_before_extension($u['Avatar'], '_large')?>" alt="user avatar" />
        </div>
        </a>
        <div class="user-list-body">
            <span class="author"><a href="<?= base_url() . 'profile/user_profile/' . $u['Nickname']?>"><?= isset($u['Nickname']) ? $u['Nickname'] : ''?></a></span>
            <p>
                <?php if($this->session->userdata('user_id') !== $u['UserID']){ ?>
                    <?php if($this->session->userdata('logged_in')){ ?>
                        <?php if(empty($u['Follow'])){ ?>
                        <span class="button-title-danger" onclick="follow('<?= $u['UserID']?>', this, 0);"><?= lang('follow')?></span>
                        <?php }else{ ?>
                        <span class="button-title" onclick="follow('<?= $u['UserID']?>', this, 1);"><?= lang('unfollow')?></span>
                        <?php } ?>
                    <?php }else{ ?>
                        <span class="button-title-danger log-in"><?= lang('follow')?></span>
                    <?php } ?>
                <?php } ?>
            </p>
        </div>
    </li>
    <?php 
        endforeach;
        echo $pagination;
        }else{
            echo lang('no_post');
        }
    ?>
    
</ul>
    
</section>
<?php $this->load->view('profile/includes/view_profile_footer');?>