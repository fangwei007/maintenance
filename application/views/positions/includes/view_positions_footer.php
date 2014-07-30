</section><!-- End of content -->

<section class="sidebar-second">
    
    <aside class="sidebar-second-block">
        <a href="#"><span class="title-cn">更多文章</span>|<span class="title-en">Read More</span></a> 
        <div class="sidebar-first-list-block">
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
        </div>	
    </aside>
	
    <aside class="sidebar-second-block">
        <a href="#"><span class="title-cn">更多活动</span>|<span class="title-en">Read More</span></a>  
        <div class="sidebar-first-list-block">
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
        </div>	
    </aside>

</section>	<!-- End of sidebar-second -->

</div><!-- End of center-right-block -->

