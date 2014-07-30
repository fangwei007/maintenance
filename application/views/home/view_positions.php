<ul>
    <?php if(!empty($career_list)){ ?>
        <?php foreach($career_list as $c):?>
        <li><a href="<?= base_url() ?>positions/show_position/<?= $c['PositionID'] ?>"><?= $c['Title']?></a></li>
        <?php endforeach; ?>
    <?php }else{
        echo "暂无内容";
    } ?>
</ul>