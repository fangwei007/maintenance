<!-- Left bar container -->
<?php 
$sess_name = ($this->session->userdata('nickname')) ? $this->session->userdata('nickname') : $this->session->userdata('email');
$sess_avatar = ($this->session->userdata('avatar')) ? $this->session->userdata('avatar') : $this->config->item('default_avatar');
?>
<script src="<?=  base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
<section class="sidebar-left">	
	
    <aside class="sidebar-first-block">
        <!-- Author image  -->
        <a href="#">
            <div style="margin-bottom:20px; height:170px; background-image:url('<?=  base_url();?>assets/images/users_avatar/<?= insert_before_extension($sess_avatar, '_large')?>'); background-repeat:no-repeat;"></div>
        </a>

        <div class="clearfix">
        <div class="sidebar-article-author"><?= $sess_name;?></div>
        </div>

        <a href="<?= base_url(); ?>my_account/edit_my_profile"><div class="button-title">编辑我的个人资料</div></a><br/>
        <a href="<?= base_url(); ?>my_account/add_post"><div class="button-title">发布新内容</div></a><br/>
        <?php if($this->session->userdata('status') === 'N'): ?>
        <a href="<?= base_url(); ?>my_account/activate_account"><div class="button-title-danger">激活账户</div></a>
        <?php endif; ?>
    </aside>	
    <!-- / sidebar-article-author-block -->
   
    <aside class="sidebar-first-block">
        	<a href="#"><span class="title-cn">更多文章</span>|<span class="title-en">Read More</span></a>

		<div class="sidebar-first-list-block">
			<ul>
				<li><a href="#" class="first-article-preview">&nbsp;倒计时100天：自我挑战</a></li>
				<li><a href="#">&nbsp;人都应该有梦，有梦就别怕痛</a></li>
				<li><a href="#">&nbsp;H1b回国签证攻略</a></li>
				<li><a href="#">&nbsp;如果你想进美国4A广告公司</a></li>
				<li><a href="#">&nbsp;小编的心理学历程</a></li>
				<li><a href="#">&nbsp;如果你不是真的热爱--写给奋战在求职一线的战友们</a></li>
			</ul>
		</div>	
	</aside>
    <!-- / sidebar-article-list-block -->
    
	<aside class="sidebar-article-list-block">
        <a href="#"><span class="title-cn">猜你喜欢</span>|<span class="title-en">Recommend</span></a>  
		<div class="sidebar-first-list-block">
			<ul>
				<li><a href="#">&nbsp;五十个专业找工作网站</a></li>
				<li><a href="#">&nbsp;时间管理之番茄工作法</a></li>
				<li><a href="#">&nbsp;雇主能强迫你辞职吗</a></li>
				<li><a href="#">&nbsp;招聘经理透露12点最糟糕的简历错误</a></li>
				<li><a href="#">&nbsp;5个投资银行面试者必须要搞定的面试问题</a></li>
			</ul>
		</div>	
 	</aside>
    <!-- / sidebar-article-list-block -->
      
	<aside class="sidebar-first-ads-block">
		<div class="left-ads"><img class="article-ads" src="images/ads.jpg" alt="ads" /></div>  
		<div class="left-ads"><img class="article-ads" src="images/ads1.jpg" alt="ads" /></div> 
  	    <div class="left-ads"><img class="article-ads" src="images/ads2.jpg" alt="ads" /></div>      
	</aside>
</section>	
<!-- End of left bar container -->

<!--article container-->

<section class="right-content" >
