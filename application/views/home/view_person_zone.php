<?php if(!empty($person_zone_list)){ ?>
              <?php foreach($person_zone_list as $p):?>
                <figure class="sidebar-first-block-content2">
                    <a href="<?= base_url() . 'profile/user_profile/' . $p['Nickname']?>">
                        <img src="<?= base_url() . 'assets/images/users_avatar/' . insert_before_extension($p['Avatar'], '_medium')?>" alt="images" />
                        <figcaption><?= $p['Nickname']?></figcaption>
                    </a>
                </figure>
              <?php endforeach; ?>
          <?php }else{
              echo "暂无内容";
          } ?>