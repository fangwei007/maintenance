<script src="<?=  base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
<section class="sidebar-left">	
    <aside class="sidebar-first-block">
        <?php if(in_array($this->session->userdata('role'), $this->config->item('manage_users'))): ?>
        <a href="<?= base_url(); ?>admin/manage_users"><div class="button-title">管理用户</div></a><br/>
        <?php endif; ?>
        
        <?php if(in_array($this->session->userdata('role'), $this->config->item('manage_posts'))): ?>
        <a href="<?= base_url(); ?>admin/manage_posts"><div class="button-title">管理发布</div></a><br/>
        <a href="<?= base_url(); ?>admin/manage_positions"><div class="button-title">管理职位</div></a><br/>
        <?php endif; ?>

    </aside>	

</section>

<section class="right-content" >