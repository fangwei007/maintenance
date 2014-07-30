<nav id="main-menu" role="navigation">
        <ul>
            <li class="<?= !isset($type) ? 'active' : ''?>"><a href="<?=  base_url(); ?>">首页 HOME</a></li>                        
            <li class="<?= isset($type) ? active_page($type, 'article') : ''?>"><a href="<?=  base_url(); ?>posts/show_posts/start_up/article">创业资讯 ARTICLES</a></li>
            <li class="<?= isset($type) ? active_page($type, 'event') : ''?>"><a href="<?=  base_url(); ?>posts/show_posts/start_up/event">创业活动 EVENTS</a></li>
            <li class="<?= isset($type) ? active_page($type, 'video') : ''?>"><a href="<?=  base_url(); ?>posts/show_posts/start_up/video">视频电影 VIDEOS</a></li>

<!--            <li class="<?= isset($category) ? active_page($category, 'study') : ''?>"><a href="#">比橙留学 EDUCATION</a>
                <ul>
                    <div class="main-menu-dropdown">
                        <li><a href="<?=  base_url(); ?>posts/show_posts/study/article">留学资讯</a></li>  
                        <li><a href="<?=  base_url(); ?>posts/show_posts/study/video">视频专区</a></li>  
                        <li><a href="<?=  base_url(); ?>posts/show_posts/study/event">活动资讯</a></li>  
                        <li><a href="<?=  base_url(); ?>profile/verified_users/school">学校官方空间</a></li>
                    </div>
                </ul>
            </li>
            <li class="<?= isset($category) ? active_page($category, 'career') : ''?>"><a href="#">比橙求职 CAREER</a>
                <ul>
                    <div class="main-menu-dropdown">
                        <li><a href="<?=  base_url(); ?>posts/show_posts/career/article">求职资讯</a></li>  
                        <li><a href="<?=  base_url(); ?>posts/show_posts/career/video">求职视频</a></li>
                        <li><a href="<?=  base_url(); ?>posts/show_posts/career/event">求职活动</a></li>
                        <li><a href="<?=  base_url(); ?>positions/show_positions/">职位分享</a></li>  
                        <li><a href="<?=  base_url(); ?>profile/verified_users/industry">企业官方空间</a></li>
                    </div>
                </ul>
            </li>

            <li class="<?= isset($category) ? active_page($category, 'start_up') : ''?>"><a href="#">比橙创业 START-UP</a>
                <ul>
                    <div class="main-menu-dropdown">
                        <li><a href="<?=  base_url(); ?>posts/show_posts/start_up/article">创业资讯</a></li>
                        <li><a href="<?=  base_url(); ?>posts/show_posts/start_up/video">创业视频</a></li>
                        <li><a href="<?=  base_url(); ?>posts/show_posts/start_up/event">创业活动</a></li>  
                    </div>
                </ul>
            </li>-->

        </ul>
</nav>