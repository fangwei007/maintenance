<div class="pull-right">
<?php if ($this->session->userdata('logged_in')) { ?>
    <?php if (empty($position->Stow)) { ?>
        <span class="button-title-danger" onclick="watch_list('<?= $position->PositionID ?>', this, 0, 'position');"><?= lang('stow') ?></span>
    <?php } else { ?>
        <span class="button-title" onclick="watch_list('<?= $position->PositionID ?>', this, 1, 'position');"><?= lang('unstow') ?></span>
    <?php } ?>
<?php } else { ?>
    <span class="button-title-danger log-in"><?= lang('stow') ?></span>
<?php } ?>
</div>

