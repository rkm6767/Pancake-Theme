<div class="panel radius">
    <?php if (!isset($view_all) or $view_all): ?>
        <header>
            <img src="<?php echo get_gravatar($current_user->email, 48) ?>" alt="<?php echo $current_user->first_name; ?> <?php echo $current_user->last_name; ?>" class="avatar" />
            <h4><i class="fi-checkbox"></i> <?php echo __("dashboard:my_tasks") ?></h4>
        </header>
    <?php endif; ?>

    <ol class="task-list">
        <?php foreach ($my_upcoming_tasks as $task): ?>
            <li id="task-row-<?php echo $task['task_id']; ?>" class="<?php echo isset($timers[$task['task_id']]) ? 'hover' : '' ?> task-item dashboard-task-item">
                <input type="checkbox" class="complete-check" value="1" <?php echo ((bool) $task['completed'] ? 'checked="checked"' : '') ?> data-task-id="<?php echo $task['task_id']; ?>" />
                <a href='<?php echo site_url("admin/projects/view/{$task['project_id']}"); ?>'><label class="task-name"><?php echo $task['task_name']; ?></label></a>
                <span class="task-info">
                    <span class="task-timer timer" <?php timer($timers, $task['task_id']); ?>>
                        <span class="track-time" data-task-id="<?php echo $task['task_id']; ?>" data-project-id="<?php echo $task['project_id'] ?>" data-time-start="<?php echo isset($task['entry_started']) && $task['entry_started'] ? strtotime(date('Y-m-d', $task['entry_started_date']) . ' ' . $task['entry_started_time']) . '000' : '' ?>">
                            <span class="time time-ticker timer-time">00:00:00</span>
                            <a href="#" class="<?php echo isset($task['entry_started']) && $task['entry_started'] ? 'pause' : 'play' ?> timer-button" title="<?php echo __('global:start') ?>" data-start="<?php echo __('global:start') ?>" data-stop="<?php echo __('global:stop') ?>"><i class="fi-play"></i><i class="fi-pause"></i></a>
                            <a href="#" class="stop timer-button" title="<?php echo __('global:stop') ?>"><i class="fi-stop"></i></a>
                        </span>
                    </span>
                    <span class="task-project"><a href="<?php echo site_url("admin/projects/view/{$task['project_id']}"); ?>"><?php echo $task['project_name']; ?></a></span>
                </span>
                <?php if ($task['status_title']): ?>
                    <span class="task-tag tag-<?php echo $task['status_id'] ?>" style="color: <?php echo $task['font_color'] ?>; background: <?php echo $task['background_color'] ?>; text-shadow: 1px 1px <?php echo $task['text_shadow'] ?>; -webkit-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; -moz-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; box-shadow: 0px 1px 1px 0px <?php echo $task['box_shadow'] ?>" ><?php echo $task['status_title'] ?></span>
                <?php endif ?>
            </li>
        <?php endforeach; ?>
    </ol>
    <?php if (!isset($view_all) or $view_all): ?>
        <a href="<?php echo site_url("admin/dashboard/all_my_tasks") ?>" class="view-more"><?php echo __("dashboard:view_all_my_tasks") ?> <i class="fi-arrow-right"></i></a>
        <?php endif; ?>
</div>