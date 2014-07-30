<ul class="position-ulist">
    
    <?php 
    if(!empty($positions)){
        foreach($positions as $p):
    ?>
            <li>
                <div class="position-list-body">
                    <div class="title"><a href="<?= base_url() . 'positions/show_position/' . $p['PositionID']?>" target="_blank"><?= isset($p['Title']) ? $p['Title'] : ''?></a></div></h3>
                    <p class="post-info-block">
                        <span class="author"><?= lang('posted_by')?> <a href="<?= base_url() . 'profile/user_profile/' . $p['Nickname']?>"><?= isset($p['Nickname']) ? $p['Nickname'] : ''?></a></span>
                        <span><?= isset($p['CreatedOn']) ? readable_time_format($p['CreatedOn'], 'mdhi') : ''?></span>
                    </p>
                    <div class="preview"><a href="<?= base_url() . 'positions/show_position/' . $p['PositionID']?>" target="_blank"><?= isset($p['Description']) ? truncate_string($p['Description'], '100') : ''?></a></div>
                    <p><a href="<?= base_url() . 'positions/show_position/' . $p['PositionID']?>" target="_blank"><span class="button-title"><?= lang('read_all')?></span></a></p>
                </div>
            </li>

        <?php endforeach; ?>
        <?=$pagination; ?>
    <?php }else{
        echo lang('no_position');
    } ?>

</ul>

