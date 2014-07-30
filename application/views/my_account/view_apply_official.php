<?php $this->load->view('my_account/includes/view_apply_official_header'); ?>

<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php if (isset($status)) { ?>
    <?php
    switch ($status) {
        case 'N':
            echo '<div class="alert alert-success">申请已发送，在进入审核之前可以对内容进行修改！</div>';
            break;
        case 'A':
            echo '<div class="alert alert-success">审核中...</div>';
            break;
        case 'F':
            echo '<div class="alert alert-success">审核失败，以下是失败反馈信息：</div>';
            break;
        case 'S':
            echo '<div class="alert alert-success">恭喜，审核通过</div>';
            break;

        default:
            break;
    }
} else {
    ?>
    <h2>申请用户必须为激活账户，个人资料完善，必须用企业或学校的官方邮箱注册 ！</h2>
<?php } ?>
<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>my_account/apply_official" method="POST">

    <div class="row form-row">
        <label for="input-application" class="col-sm-1 control-label" <?php  if (isset($status) && $status === 'S') echo "style='display:none'";?>><?php
            if (isset($status) && $status === 'F')
                echo '信息反馈';
            else
                echo '申请内容';
            ?></label>
        <div class="col-sm-8">
            <textarea name="application" id="input-bio" class="form-control" rows="6" <?php  if (isset($status) && $status === 'S') echo "style='display:none'";?>><?php
                if (isset($status)) {
                    switch ($status) {
                        case 'F':
                            echo $feedback;
                            break;
                        case 'S':
                            break;
                        default:
                            echo $note;
                            break;
                    }
                }
                ?></textarea>
        </div>
    </div>

    <div class="col-sm-offset-5"><?php
        if (!isset($status)) {
            ?>
            <input type="submit" name="submit" value="申请" class="btn btn-default"/>
        <?php } else if ($status === 'N') { ?>
            <input type="submit" name="update" value="更新" class="btn btn-default"/>
        <?php } else ;?>
    </div>
</form>

<script language="javascript">
//set the help info   
    $('#nickname-tips').popover({
        trigger: 'hover ',
        placement: 'bottom',
        content: '显示的名字里只能含有中文，数字和英文大小写字母，不能包含有特殊字符包括：空格~!@#$%^&*等'
    });

    $('#web-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content: 'http://或https://开头的网址'
    });
</script>