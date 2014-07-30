<section class="sidebar-first">
    <div class="scoll-fixed-left-block"><!-- set the div to be fixed when scrolling down-->
        <aside class="sidebar-first-block">
          <a href="/positions/show_positions"><div class="button-title">创业招募</div></a>
          <div class="sidebar-first-block-content">
            <?php $this->load->view('home/view_positions')?>
          </div>
        </aside>
        <!-- / sidebar-first-block -->

        <aside class="sidebar-first-block">
            <a href="/profile/verified_users/industry"><div class="button-title">热门初创公司</div></a>
            <?php $this->load->view('home/view_industry_zone')?>
        </aside>
        <!-- / sidebar-first-block --> 

<!--        <aside class="sidebar-first-block">
            <a href="/profile/verified_users/school"><div class="button-title">学校官方空间</div></a>
            <?php $this->load->view('home/view_school_zone')?>
        </aside>-->
        <!-- / sidebar-first-block --> 
    </div>
    <aside class="sidebar-first-block">
        <a href="/profile/verified_users/client"><div class="button-title">创业达人</div></a>
        <?php $this->load->view('home/view_person_zone')?>
    </aside><!-- / sidebar-first-block --> 
    
</section><!-- / sidebar-first -->


<div class="center-right-block">
    <section id="content">
<!--        <nav>
          <span class="button-title">最新</span> <span class="button-title">最热</span> <span class="button-title">我的关注</span>
        </nav>/nav-->
        <div id="articles-wrapper" class="clearfix">
            <?php $this->load->view('home/view_articles')?>
        </div>
        <div id="load-more" style="display:none;"><center>读取更多文章中...</center></div>
<!--        <div id="view-all" style="display:none;"><center>更多往期文章</center></div>-->
    </section><!-- / content中间 -->

    <section class="sidebar-second">
<!--        <div class="scoll-fixed-right-block">
            <aside class="sidebar-second-block">
              <div class="button-title">比橙视频专区</div>
              <?php $this->load->view('home/view_videos')?>
            </aside>
        </div>-->
        <!-- / sidebar-second-block -->

        <aside class="sidebar-second-block">
          <div class="button-title">创业活动</div>
          <?php $this->load->view('home/view_events')?>
        </aside><!-- / sidebar-second-block -->
      
    </section><!-- / sidebar-second --> 

</div> <!-- / center-right-block --> 
  

<script type="text/javascript">
// set the infinite scrolling
var timeout;
$(window).scroll(function(){ 
//    console.log($(document).height() - ($(window).scrollTop() + $(window).height()));
    clearTimeout(timeout);//set the timeout to prevent trigger event mutiple times
    timeout = setTimeout(function(){
        if($(document).height() - ($(window).scrollTop() + $(window).height()) < 50){
            if($(".articles-cell").length >= <?= $this->config->item("home_total_articles")?>){
                $('div#load-more').hide();
//                $('div#view-all').show();
            }else{
                $('div#load-more').show();
                var pathname = "<?= base_url() ?>home/load_more_articles/" + $(".articles-cell").length;
             $.ajax({
                 url: pathname,
                 success: function(html)
                 {
                   if(html){
                     $("#articles-wrapper").append(html);
                     $('div#load-more').hide();
                   }else{
                     $('div#load-more').html('<center>已显示全部文章</center>');
                    }
                  }
              });
             }
        }
        
        //set the sidebar to fix
//        if($(window).scrollTop() < 700){
//            $('.scoll-fixed-left-block').removeClass("scroll-to-left-fixed");
//        }else{
//            $('.scoll-fixed-left-block').addClass("scroll-to-left-fixed");
//        }
    },500);
    
});
</script>