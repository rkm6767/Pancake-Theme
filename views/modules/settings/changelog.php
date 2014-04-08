<!--TELL_JS_IT_LOADED_OK--><?php if ($conflicted_files != array()) : ?>
    <div class="conflicted">
        <p class="conflict-warning">Pancake will have to overwrite <?php echo count($conflicted_files); ?> files that you have modified manually!</p>
        <ul>
            <?php foreach ($conflicted_files as $file => $operation) : ?>
                <li><small><?php echo $operation == 'M' ? '[You modified]' : '[You deleted]'; ?> <?php echo $file; ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div><!-- /conflictted -->

    <p class="conflict-reviewfiles"><?php echo __('update:review_files'); ?><br /> <br /><?php echo __('update:ifyourenotsurecontactus') ?></p>
<?php endif; ?>

<?php if (($update->write or $update->ftp)) : ?>

    <div class="cf">
        <a href="<?php echo site_url('admin/upgrade/update'); ?>" class="button upgrade-btn" data-loading-text="Updating, please wait. This page will refresh once the update has finished." ><span><?php echo __('settings:updatenow'); ?></span></a>
    </div>
<?php else: ?>
    <p class="youneedtoconfigurefirst"><?php echo __('settings:youneedtoconfigurefirst'); ?></p>
<?php endif; ?> <!-- /changelog -->

<h4 class="whatschanged"><?php echo __('update:whatschanged', array($latest_version)); ?></h4>

<div class="changelog"><?php echo $changelog; ?></div>