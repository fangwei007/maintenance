<?php if(!empty($industry_zone_list)){ ?>
    <?php foreach($industry_zone_list as $i):?>
      <figure class="sidebar-first-block-content2">
          <a href="<?= base_url() . 'profile/user_profile/' . $i['Nickname']?>">
            <img src="<?= base_url() . 'assets/images/users_avatar/' . insert_before_extension($i['Avatar'], '_medium')?>" alt="images" />
            <figcaption><?= $i['Nickname']?></figcaption>
          </a>
      </figure>
    <?php endforeach; ?>
<?php }else{
    echo "暂无内容";
} ?>