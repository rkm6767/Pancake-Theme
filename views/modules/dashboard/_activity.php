<?php
$client_activity_x = isset($client_activity_x) ? $client_activity_x : 5;
$CI = get_instance();
$CI->load->model('notifications/notification_m');
?>
<div class="panel radius" id="client-activity">
    <?php if (!isset($view_all) or $view_all): ?>
    <header>
        <h4><i class="fi-ticket"></i> <?php echo __("dashboard:client_activity"); ?></h4>
    </header>
    <?php endif; ?>
    <ol class="activity">
        <?php foreach ($CI->notification_m->get_latest_client_activity($client_activity_x) as $notification): ?>
            <li class="<?php echo $notification->dashboard_class; ?>">
                <?php echo $notification->dashboard_message; ?>
            </li>
        <?php endforeach; ?>
    </ol>
    <?php if (!isset($view_all) or $view_all): ?>
    <a href="<?php echo site_url("admin/dashboard/all_client_activity") ?>" class="view-more"><?php echo __("dashboard:view_all_client_activity"); ?>  <i class="fi-arrow-right"></i></a>
    <?php endif; ?>
</div>