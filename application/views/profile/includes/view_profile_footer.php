<section class="sidebar-right">	
	
    <aside class="sidebar-right-block">
        <a href="#"><span class="title-cn">更多文章</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_articles)) {
                      foreach($sidebar_articles as $a){
                ?>
                <li><a href="<?= base_url() . "posts/show_post/" . $a['PostID']?>"><?= $a['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>
    </aside>
    
    <aside class="sidebar-right-block">
        <a href="#"><span class="title-cn">更多活动</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_events)) {
                      foreach($sidebar_events as $e){
                ?>
                <li><a href="<?= base_url() . "posts/show_post/" . $e['PostID']?>"><?= $e['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>
    </aside>
    
    <aside class="sidebar-right-block">
        <a href="#"><span class="title-cn">更多职位</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_positions)) {
                      foreach($sidebar_positions as $s){
                ?>
                <li><a href="<?= base_url() . "positions/show_position/" . $s['PositionID']?>"><?= $s['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>
    </aside>

</section>	<!-- End of right bar container -->