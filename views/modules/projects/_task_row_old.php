<?php if(!isset($milestone)): $milestone = false; endif; ?>
<div class="row <?php echo ((bool) $task['completed']) ? 'completed' : 'incomplete'; ?>">
    <span class="blue-dot" <?php if($milestone && $milestone->color): ?>style="background: <?php echo $milestone->color; ?>;"<?php endif; ?>></span>

		<div class="ten columns">
		    <div class="row task-info">
		        <div class="twelve columns mobile-four">
		            <div class="row">
		                <div class="eleven columns mobile-three">
  		                  <?php if( $task['status_title'] ): ?>
  		                      <span class="tag status-<?php echo $task['status_id'] ?>" style="color: <?php echo $task['font_color'] ?>; background: <?php echo $task['background_color'] ?>; text-shadow: 1px 1px <?php echo $task['text_shadow'] ?>; -webkit-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; -moz-box-shadow:0px 1px 1px 0px <?php echo $task['box_shadow'] ?>; box-shadow: 0px 1px 1px 0px <?php echo $task['box_shadow'] ?>" ><?php echo $task['status_title'] ?></span>
  		                  <?php endif ?>

  		                  <h4 class="task-title"><?php echo $task['name'] ?></h4>
		                </div><!-- /11 -->
		                <div class="one column mobile-one">
  		                  <div class="task-user">
    		                    <img src="<?php echo get_gravatar($task['assigned_user_email'], '40') ?>" class="user-icon" />
    		                    <div class="task-status red"></div>
    		                </div><!-- /task-user-->
    		            </div><!-- /1 -->

    		            <br class="clear" />

    		            <div class="twelve columns">
      		              <?php echo auto_typography($task['notes']) ?>
      		          </div><!-- /12 -->
      		      </div><!-- /ROW -->
 		        </div><!-- /ten -->
		    </div><!-- /row /task-info -->

		    <div class="row task-details">
  		      <div class="three columns mobile-two">
                <a class="task-icon settings fire-ajax" title="Edit Task" href="<?php echo site_url('admin/projects/tasks/edit/'.$task['id'])?>"></a>
                <?php echo anchor('admin/projects/times/view_short_entries/task/'.$task['id'], __('tasks:view_entries'), array('class' => 'fire-ajax task-icon time')) ?>
                <a class="task-icon discus" href="<?php echo site_url('/admin/projects/tasks/discussion/' . $task['id']); ?>">discus</a>
                <a class="task-icon delete" title="Delete Task" href="#" onclick="$('#delete-task-<?php echo $task['id']; ?>').submit();"></a>
                <form action="<?php echo site_url('/admin/projects/tasks/delete/'.$task['id']); ?>" method="post" class="confirm-form" id="delete-task-<?php echo $task['id']; ?>"></form>
  		    </div><!-- /three -->

  		    <div class="three columns mobile-two">
              <strong>Due:</strong> <?php echo format_date($task['due_date']) ?>
  		    </div><!-- /three -->

  		    <div class="three columns mobile-two">
              <strong>Tracked:</strong> <?php echo $task['tracked_hours'] ?>
  		    </div>

  		    <div class="three columns mobile-two">
              <strong>Completed?</strong> <input type="checkbox" class="complete-check" value="1" <?php echo ((bool) $task['completed'] ? 'checked="checked"' : '') ?> onclick="Tasks.toggleStatus('<?php echo $task['id']; ?>');return false;" />
  		    </div>

		    </div><!-- /row /task-details -->
  		</div><!-- /ten columns-->

      <div class="timer large-timer" <?php timer($timers, $task['id']);?>>
		      <div class="two columns track-time " data-task-id="<?php echo $task['id'];?>" data-project-id="<?php echo $project->id ?>" data-time-start="<?php echo $task['entry_started'] ? strtotime(date('Y-m-d', $task['entry_started_date']).' '.$task['entry_started_time']).'000' : '' ?>">

  		            <span class="time-ticker timer-time mobile-two">00:00:00</span>

  		            <p class="task-buttons mobile-two">
    		              <span class="task-btn-back btn-left"><a class="task-btn play timer-button <?php echo $task['entry_started'] ? 'running' : '' ?>" href="#" data-start="<?php echo __('global:start') ?>" data-stop="<?php echo __('global:stop') ?>" >P</a></span>

    		              <span class="task-btn-back btn-right"><a class="task-btn stop timer-button" href="#">S</a></span>
    		          </p>
    		  </div><!-- /two -->
	  	</div><!-- /timer -->


  <!-- left over from what was originally here (not replaced) -->
	<div class="row hide">
		<div class="twelve columns">
				<?php echo anchor(Settings::get('kitchen_route').'/'.get_client_unique_id_by_id($project->client_id).'/comments/task/'.$task['id'], 'Comments ('.get_count('task_comments', $task['id']).')') ?> |
				<?php echo anchor('admin/projects/times/view_entries/task/'.$task['id'], __('tasks:view_entries'), array('class' => 'modal')) ?>

				<?php if (can('create', get_client('projects', $project->id), 'project_tasks') && $task['parent_id'] == null): ?>
				<a href="<?php echo site_url('admin/projects/tasks/create/'.$project->id . '?parent_id=' . $task['id']); ?>" class="fire-ajax"><span><?php echo __('tasks:create_sub') ?></span></a> |
				<?php endif; ?>


		    <?php if (can('delete', get_client('project_tasks', $task['id']), 'project_tasks', $task['id'])): ?>
				  <?php echo anchor('admin/projects/tasks/get_delete_form/'.$task['id'], __('global:delete'), array('class' => 'remove fire-ajax')) ?>
				<?php endif ?>
		</div><!-- /eight columns -->
	</div><!-- /row -->
</div><!-- /row -->
