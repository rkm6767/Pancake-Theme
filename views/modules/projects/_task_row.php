<?php
if (!isset($milestone)): $milestone = false;
endif;
?>
<div class="row <?php echo ((bool) $task['completed']) ? 'completed' : 'incomplete'; ?>">
    <div class="user-dot" <?php if ($milestone && $milestone->color): ?>style="border:2px solid <?php echo $milestone->color; ?>;"<?php endif; ?>><img src="<?php echo get_gravatar($task['assigned_user_email'], '40') ?>" /></div>
    <div class="twelve columns">
        <div class="row task-info">
            <div class="eight columns mobile-four">
                <div class="row">
                    <div class="twelve columns mobile-four">
                        <?php if ($task['status_title']): ?>
                            <span class="tag status-<?php echo $task['status_id'] ?>" style="color: <?php echo $task['font_color'] ?>; background: <?php echo $task['background_color'] ?>; text-shadow: 1px 1px <?php echo $task['text_shadow'] ?>; -webkit-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; -moz-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; box-shadow: 0px 1px 1px 0px <?php echo $task['box_shadow'] ?>" ><?php echo $task['status_title'] ?></span>
                        <?php endif ?>

                        <h4 class="task-title"><?php echo $task['name'] ?></h4>
                    </div><!-- /11 -->
                </div><!-- /ROW -->
            </div><!-- /ten -->

            <div class="timer large-timer" <?php timer($timers, $task['id']); ?>>
                <div class="four columns track-time " data-task-id="<?php echo $task['id']; ?>" data-project-id="<?php echo $project->id ?>" data-time-start="<?php echo $task['entry_started'] ? strtotime(date('Y-m-d', $task['entry_started_date']) . ' ' . $task['entry_started_time']) . '000' : '' ?>">

                    <span class="time-ticker timer-time">00:00:00</span>
                    <span class="task-buttons">
                        <a class="task-btn play timer-button <?php echo $task['entry_started'] ? 'running' : '' ?>" href="#" data-start="<?php echo __('global:start') ?>" data-stop="<?php echo __('global:stop') ?>" >P</a>
                        <a class="task-btn stop timer-button" href="#">S</a>
                    </span>
                </div><!-- /three -->
            </div>
        </div><!-- /row /task-info -->

        <div class="row task-details">
            <div class="three columns mobile-two">
                <a class="task-icon notes" title="Task Notes" href="#" data-pancake-modal-id="notes-<?php echo $task['id'] ?>">Notes</a>
                <a class="task-icon time" title="<?php echo __('tasks:view_entries'); ?>" href="<?php echo site_url('admin/projects/times/view_entries/task/' . $task['id']); ?>"><?php echo __('tasks:view_entries'); ?></a>
                <a class="task-icon discus" title="Discuss Task" href="<?php echo site_url('/admin/projects/tasks/discussion/' . $task['id']); ?>">discus</a>
                <?php if (can('update', get_client('project_tasks', $task['id']), 'project_tasks', $task['id'])): ?><a class="task-icon settings fire-ajax" title="Edit Task" href="<?php echo site_url('admin/projects/tasks/edit/' . $task['id']) ?>"></a><?php endif; ?>
                <?php if (can('delete', get_client('project_tasks', $task['id']), 'project_tasks', $task['id'])): ?><a class="task-icon delete" title="Delete Task" href="#" onclick="$('#delete-task-<?php echo $task['id']; ?>').submit();"></a><?php endif; ?>
                <form action="<?php echo site_url('/admin/projects/tasks/delete/' . $task['id']); ?>" method="post" class="confirm-form" id="delete-task-<?php echo $task['id']; ?>"></form>
            </div><!-- /three -->

            <div class="three columns mobile-two">
                <strong>Due:</strong> <?php echo format_date($task['due_date']) ?>
            </div><!-- /three -->

            <div class="three columns mobile-two">
                <strong>Tracked:</strong> <?php echo format_hours($task['tracked_hours']) ?>
            </div>

            <div class="three columns mobile-two">
                <strong>Completed?</strong> <input type="checkbox" class="complete-check" value="1" <?php echo ((bool) $task['completed'] ? 'checked="checked"' : '') ?> onclick="Tasks.toggleStatus('<?php echo $task['id']; ?>');
                        return false;" />
            </div>

        </div><!-- /row /task-details -->
    </div><!-- /ten columns-->
</div>

<div id="notes-<?php echo $task['id'] ?>"  class='hide'>
    <div id="modal-header">
        <h3 class="ttl ttl3"><?php echo $task['name'] ?>: Notes</h3>
    </div>
    <?php echo auto_typography(htmlspecialchars($task['notes'])) ?>
</div>
