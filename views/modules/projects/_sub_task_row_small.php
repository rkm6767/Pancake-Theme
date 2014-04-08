<div class="<?php echo ((bool) $task['completed']) ? 'completed' : 'incomplete'; ?>">
    <div class="row task-info">
		    <div class="twelve columns">
			  	  <div class="row">				      
				      <div class="seven columns mobile-four">
				      <div style="float: left; margin: 13px 14px 0 0;"> <input type="checkbox" class="complete-check" value="1" <?php echo ((bool) $task['completed'] ? 'checked="checked"' : '') ?> onclick="Tasks.toggleStatus('<?php echo $task['id']; ?>');return false;" /></div>
				          <div class="task-user" style="float: left; margin: -5px 14px 0 0;">
						      <img src="<?php echo get_gravatar($task['assigned_user_email'], '30') ?>" class="task-user-pic user-icon" />
						      <div class="task-status red"></div>
					      </div><!-- /task-user -->
				      
					  	  <?php if( $task['status_title'] ): ?>
				               <span class="tag status-<?php echo $task['status_id'] ?>" style="color: <?php echo $task['font_color'] ?>; background: <?php echo $task['background_color'] ?>; text-shadow: <?php echo $task['text_shadow'] ?>; -webkit-box-shadow: <?php echo $task['box_shadow'] ?>; -moz-box-shadow:<?php echo $task['box_shadow'] ?>; box-shadow: <?php echo $task['box_shadow'] ?>" ><?php echo $task['status_title'] ?></span>
						  <?php endif ?>
		
				          <h4 class="task-title"><?php echo $task['name'] ?></h4>
				      </div><!-- /nine -->
				      
				       <div class="one columns mobile-one" style="margin-top: 12px;">
				      	<strong><?php echo $task['tracked_hours'] ?>h</strong>
				      </div>
				      
				      <div class="four columns mobile-three" style="margin-top: 14px;">
				      	<div class="row">
				      		<div class="seven columns mobile-two">
				      			<div class="timer small-timer add-bottom" <?php timer($timers, $task['id']);?>>
									<div class="track-time" data-task-id="<?php echo $task['id'];?>" data-project-id="<?php echo $project->id ?>" data-time-start="<?php echo $task['entry_started'] ? strtotime(date('Y-m-d', $task['entry_started_date']).' '.$task['entry_started_time']).'000' : '' ?>">
											
											<p class="time-ticker timer-time">00:00:00</p>
								
										    <p class="task-buttons">
									  		   <a class="play blue-btn small-btn <?php echo $task['entry_started'] ? 'running' : '' ?>" href="#" data-start="<?php echo __('global:start') ?>" data-stop="<?php echo __('global:stop') ?>"><span style="padding: 3px 5px;">Start</span></a>
									  		   <a class="stop blue-btn small-btn" href="#"><span style="padding: 3px 5px;">Stop</span></a>
										    </p>
										
									</div><!-- /track -->
								</div><!-- /timer -->	
				      		</div>
				      
				      		<div class="five columns movile-two">
				      			<div style="float:right;">
						      		<ul class="task-icons">
						      		  <li><a class="task-icon notes" title="Task Notes" href="#" data-pancake-modal-id="notesModal-<?php echo $task['id'] ?>">Notes</a></li>
						      			<li><a class="task-icon settings fire-ajax" title="Edit Task" href="<?php echo site_url('admin/projects/tasks/edit/'.$task['id'])?>">Edit</a></li>
						      			<li><?php echo anchor('admin/projects/times/view_entries/task/'.$task['id'], __('tasks:view_entries'), array('class' => 'fire-ajax task-icon time')) ?></li>
						      			<li><a class="task-icon delete" title="Delete Task" href="#" onclick="$('#delete-task-<?php echo $task['id']; ?>').submit();"></a></li>
						      		</ul><!-- /end list -->
						      		<form action="<?php echo site_url('/admin/projects/tasks/delete/'.$task['id']); ?>" method="post" class="confirm-form" id="delete-task-<?php echo $task['id']; ?>"></form>
				      			</div>
				      			<br class="clear" />
				      		</div>
				      	</div>
				      </div><!-- /four -->
			  	  </div><!-- /row -->
		      </div><!-- /12 -->
      </div><!-- /row /task-info -->

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

<div id="notesModal-<?php echo $task['id'] ?>" class="hide">
    
    <div id="modal-header">
        <h3 class="ttl ttl3"><?php echo $task['name'] ?>: Notes</h3>
    </div>
    
    <?php echo auto_typography($task['notes']) ?>
</div>