<section class="comment-block">

    <?php if(!$this->session->userdata('logged_in')){?>     
    <div class="add-comment-area">
        请先<a href="#" class="log-in"><b>登录</b></a>发表评论
    </div>
    <?php }else{ ?>             
    <div class="comment-area">
        <form id="submit-comment-form" method="POST" action="<?= base_url() . "comments/add_comment/" . $position->PositionID ."/position"?>">
            <div id="comment-error"></div>
            <textarea placeholder="留下您的评论" name="comment"></textarea>
            <div class="pull-right"><input class="btn btn-default" type="submit" name="submit" value="发表评论" /></div>
        </form>
    </div>
    <?php } ?>
    
    <!--Comment title-->
    <div class="comment-title"><span class="title-cn">热门评论</span>|<span class="title-en">Comment</span></div>

    <div class="comment-content clearfix"></div>
    <div id="load-more" style="display:none;"><center>读取更多评论中...</center></div>
    <!--end of comment content-->

</section>

<script type="text/javascript">
    ajax_load_view('.comment-content', '/comments/show_comments/<?= $position->PositionID?>/position');
    //set comments scrolling load
    $(window).scroll(function(){
        if($(window).scrollTop() === $(document).height() - $(window).height() && $(".comment-cell").length > 0){
            $('div#load-more').show();
            var pathname = "<?= base_url() ?>comments/load_more_comments/<?= $position->PositionID?>/position/" + $(".comment-cell").length;
         $.ajax({
             url: pathname,
             success: function(html)
             {
               if(html){
                 $(".comment-content").append(html);
                 $('div#load-more').hide();
               }else{
                 $('div#load-more').html('<center>已显示全部评论</center>');
                }
             }
          });
        }
    });
</script>