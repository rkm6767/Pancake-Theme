<?php
# Avoid "$is_milestone is not set" errors with a default value.
$is_milestone = isset($is_milestone) ? $is_milestone : false;
?>

<div class="project">
    <header>
        <div class="project-tools">
            <span class="project-due-date">
                <strong>Due:</strong> <?php echo format_date($is_milestone ? $project->target_date : $project->due_date); ?>
            </span>
            <span class="completion">
                <?php echo $is_milestone ? get_instance()->project_milestone_m->get_completion_percent($project->id) : $completion_percent; ?>% Complete
            </span>
            <?php if (!$is_milestone): ?>
                <?php if (can('update', $project->client_id, 'projects', $project->id)): ?>
                    <a href="<?php echo site_url('admin/projects/edit/' . $project->id); ?>" title="<?php echo __('global:edit') ?>" class="fire-ajax"><i class="fi-widget"></i></a>
                <?php endif ?>
                <?php if (can('delete', $project->client_id, 'projects', $project->id)): ?>
                    <a href="<?php echo site_url('admin/projects/delete/' . $project->id); ?>" title="<?php echo __('global:delete') ?>" class="fire-ajax"><i class="fi-x"></i></a>
                <?php endif ?>

                <?php if (can('update', $project->client_id, 'projects', $project->id)): ?>
                    <?php if (!$project->is_archived): ?>
                        <a href="<?php echo site_url('admin/projects/archive/' . $project->id); ?>" title="<?php echo __('projects:archive_proj') ?>"><i class="fi-archive"></i></a>
                    <?php else: ?>
                        <a href="<?php echo site_url('admin/projects/unarchive/' . $project->id); ?>" title="<?php echo __('projects:unarchive_proj') ?>"><i class="fi-archive"></i></a>
                    <?php endif ?>
                <?php endif; ?>
            <?php else: ?>
                <?php if (can('update', get_client('projects', $project->project_id), 'projects', $project->project_id)): ?>
                    <a href="<?php echo site_url('admin/projects/milestones/edit/' . $milestone->id); ?>" title="<?php echo __('milestones:edit') ?>" class="fire-ajax"><i class="fi-widget"></i></a>
                    <a href="<?php echo site_url('admin/projects/milestones/delete/' . $milestone->id); ?>" title="<?php echo __('milestones:delete') ?>"><i class="fi-x"></i></a>
                <?php endif ?>  
            <?php endif; ?>
        </div>
        <h3 class="project-title"><?php echo $project->name; ?></h3>

    </header>
    <div class='project-tasks-jquery-load-container'>
        <ol class="project-tasks container">
            <?php $task_i = 1; ?>
            <?php foreach ($milestones as $milestone): ?>
                <?php $has_tasks = ($milestone->tasks && count($milestone->tasks)); ?>
                <ol class='sortable milestone project-tasks <?php echo $has_tasks ? 'has-tasks' : 'not-has-tasks' ?>' data-border-color='<?php echo $milestone->color; ?>' style="<?php echo $milestone->color ? "border-color: {$milestone->color};" : ''; ?>" data-milestone-id='<?php echo $milestone->id; ?>'>
                    <?php if ($has_tasks): ?>
                        <?php foreach ($milestone->tasks as $task): ?>
                            <?php
                            $this->load->view("_task_row_4.1", array(
                                'is_subtask' => false,
                                'border_color' => $milestone->color,
                                'task' => $task,
                                'i' => $task_i
                            ));
                            ?>
                            <?php $task_i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            <?php endforeach; ?>
            <?php if (!$is_milestone): ?>
                <ol class='sortable not-milestone project-tasks'>
                    <?php foreach ($tasks as $task): ?>
                        <?php
                        $this->load->view("_task_row_4.1", array(
                            'is_subtask' => false,
                            'border_color' => '',
                            'task' => $task,
                            'i' => $task_i
                        ));
                        ?>
                        <?php $task_i++; ?>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </ol>
    </div>
    <ol class="project-tasks">
        <li class="task-item task-new">
            <form method='post' class='form-holder the-task the-new-task task-quickadd' data-project-id='<?php echo $is_milestone ? $project->project_id : $project->id; ?>' action='<?php echo site_url('admin/projects/tasks/quick_add') ?>'>
                <span class="task-number"><i class="fi-plus"></i></span>
                <span class="task-title-add"><input type="text" class='task-quickadd-name' name="task" placeholder="Add New Task" value="" /></span>
                <?php if (!$is_milestone): ?>
                    <?php if (count($milestones_select) > 1): ?>
                        <span class="task-milestone-add">
                            <span class="sel-item dropdown-arrow">
                                <?php echo form_dropdown('milestone_id', $milestones_select); ?>
                            </span>
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    <input type='hidden' name='milestone_id' value='<?php echo $project->id ?>'>
                <?php endif; ?>
                <?php if (count($users_select) > 2): ?>
                    <span class="task-assignee-add">
                        <span class="sel-item dropdown-arrow">
                            <?php echo form_dropdown('assigned_user_id', $users_select); ?>
                        </span>
                    </span>
                <?php endif; ?>
            </form>
        </li>
    </ol>
</div>

<?php foreach ($milestones as $milestone): ?>
    <?php if ($milestone->tasks && count($milestone->tasks)): ?>
        <?php foreach ($milestone->tasks as $task_i => $task): ?>
            <?php $this->load->view("_task_modal", array('task' => $task)); ?>
            <?php if ($task['subtasks'] && count($task['subtasks'])): ?>
                <?php foreach ($task['subtasks'] as $subtask): ?>
                    <?php $this->load->view("_task_modal", array('task' => $task)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php foreach ($tasks as $task): ?>
    <?php $this->load->view("_task_modal", array('task' => $task)); ?>
    <?php if ($task['subtasks'] && count($task['subtasks'])): ?>
        <?php foreach ($task['subtasks'] as $subtask): ?>
            <?php $this->load->view("_task_modal", array('task' => $task)); ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>