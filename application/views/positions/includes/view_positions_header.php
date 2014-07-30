<section class="sidebar-first">
    <aside class="sidebar-first-block">
        <div class="job-search-bar">
            <form class="form-inline" role="form" action="<?= base_url() ?>positions/show_positions" method="GET">
                <div class="form-group">
                    <label class="sr-only" for="job-keywords">职位关键字：</label>
                    <input type="text" name="position_search" id="job-keywords" placeholder="输入职位关键字">
                </div>
                <button type="submit" class="btn btn-red">搜索</button>
                
            </form>
        </div>
        <div class="job-filter">
            <form role="form" action="<?php echo base_url() ?>positions/show_positions" method="GET">
                <div class="col-sm-8">
                    <div class="title"><?= lang('job_type') ?>:</div>

                    <?php $_GET['JobType'] = isset($_GET['JobType']) ? $_GET['JobType'] : array(); ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="fulltime" name="JobType[]" <?php if(in_array('fulltime', $_GET['JobType'])) echo "checked='true'";?> /><?= lang('fulltime') ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="parttime" name="JobType[]" <?php if(in_array('parttime', $_GET['JobType'])) echo "checked='true'";?> /><?= lang('parttime') ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="internship" name="JobType[]" <?php if(in_array('internship', $_GET['JobType'])) echo "checked='true'";?> /> <?= lang('internship') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="contract" name="JobType[]" <?php if(in_array('contract', $_GET['JobType'])) echo "checked='true'";?> /> <?= lang('contract') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>        
                            <input type="checkbox" value="other" name="JobType[]" <?php if(in_array('other', $_GET['JobType'])) echo "checked='true'";?> /> <?= lang('other') ?><br>
                        </label>
                    </div>
                </div>


                <div class="col-sm-8">
                    <div class="title"><?= lang('country') ?>:</div>
                    <?php $_GET['Country'] = isset($_GET['Country']) ? $_GET['Country'] : array(); ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="us" name="Country[]" <?php if(in_array('us', $_GET['Country'])) echo "checked='true'";?> /> <?= lang('us') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>     
                            <input type="checkbox" value="cn" name="Country[]" <?php if(in_array('cn', $_GET['Country'])) echo "checked='true'";?> /> <?= lang('cn') ?><br>
                        </label>
                    </div>
                </div>


                <div class="col-sm-8">
                    <div class="title"><?= lang('field') ?>:</div>
                    <?php $_GET['Field'] = isset($_GET['Field']) ? $_GET['Field'] : array();?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="IT" name="Field[]" <?php if(in_array('IT', $_GET['Field'])) echo "checked='true'";?>/> <?= lang('IT') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="finance" name="Field[]" <?php if(in_array('finance', $_GET['Field'])) echo "checked='true'";?> /> <?= lang('finance') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="marketing" name="Field[]" <?php if(in_array('marketing', $_GET['Field'])) echo "checked='true'";?> /> <?= lang('marketing') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="design" name="Field[]" <?php if(in_array('design', $_GET['Field'])) echo "checked='true'";?> /> <?= lang('design') ?><br>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="HR" name="Field[]" <?php if(in_array('HR', $_GET['Field'])) echo "checked='true'";?> /> <?= lang('HR') ?><br>
                        </label>
                    </div>
                </div> 
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-red"><?= lang('submit') ?></button>
                </div>
                <?php //if (isset($_GET)) print_r($_GET); ?>
            </form>
        </div>
    </aside>
    
</section>

<div class="center-right-block">
    <section id="content">