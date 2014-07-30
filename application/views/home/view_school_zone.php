<?php if(!empty($school_zone_list)){ ?>
              <?php foreach($school_zone_list as $s):?>
                <figure class="sidebar-first-block-content2">
                    <a href="<?= base_url() . 'profile/user_profile/' . $s['Nickname']?>">
                        <img src="<?= base_url() . 'assets/images/users_avatar/' . insert_before_extension($s['Avatar'], '_medium')?>" alt="images" />
                        <figcaption><?= $s['Nickname']?></figcaption>
                    </a>
                </figure>
              <?php endforeach; ?>
          <?php }else{
              echo "暂无内容";
          } ?>