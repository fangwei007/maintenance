<ul>
    <?php if(!empty($career_list)){ ?>
        <?php foreach($career_list as $c):?>
        <li><?= $c['Title']?></li>
        <?php endforeach; ?>
    <?php }else{
        echo "暂无内容";
    } ?>
</ul>