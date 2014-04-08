<div class="modal-form-holder">
  
<div id="form_container">
  <div id="modal-header">
	 <div class="row">
	   <h3 class="ttl ttl3"><?php echo __('tasks:'.$action) ?> - <?php echo $project->name ?></h3>
	 </div>
  </div>
		
		<div class="form-holder">

			<?php echo form_open('admin/projects/tasks/'.($action == 'create' ? 'create/'.$project->id : 'edit/'.$task->id), array('id' => $action.'_form')); ?>

	  		<div class="row">
				<label for="name"><?php echo __('global:name') ?></label>
				<?php echo form_input('name', set_value('name'), 'class="txt"'); ?>
			</div>
  		
	  		<div class="row">
		  		<div class="row">
					<div class="four columns">
						<label for="rate"><?php echo __('tasks:rate') ?> (<?php echo $project->currency_code ? $project->currency_code : Currency::symbol(); ?>)</label>
						<?php echo form_input('rate', set_value('rate', isset($project) ? $project->rate : ''), 'class="txt"'); ?>
					</div>
		      
					<div class="four columns">
				    	<label for="projected_hours"><?php echo __('projects:projected_hours') ?></label>
				    	<?php echo form_input('projected_hours', set_value('projected_hours', isset($task) ? $task->projected_hours : ''), 'class="txt"'); ?>
					</div>
		  		
					<div class="four columns">
						<label for="due_date"><?php echo __('projects:due_date') ?></label>
						<?php echo form_input('due_date', set_value('due_date') ? format_date(set_value('due_date')) : '', 'id="due_date" class="datePicker txt"'); ?>
					</div>
		  		</div>
	  		
		  		<div class="row">
		  			<div class="six columns">  
				  		<?php if ( ! empty($milestone_id)): ?>
				  			<?php echo form_hidden('milestone_id', $milestone_id) ?>
				  		<?php else: ?>
							<label for="milestone_id"><?php echo __('milestones:milestone') ?></label>
							<span class="sel-item"><?php echo form_dropdown('milestone_id', $milestones_select, set_value('milestone_id')); ?></span>
						<?php endif; ?>
		  			</div>
		  			
		  			<div class="six columns">
						<label for="parent_task_id"><?php echo __('tasks:task_parent') ?></label>
						<span class="sel-item"><?php echo form_dropdown('parent_task_id', $tasks_select, $parent_task_id); ?></span>
					</div>
		  		</div>
  
  		    	<div class="row">
  		    		<div class="six columns">
  		    			<label for="assigned_user_id"><?php echo __('milestones:assigned_user') ?></label>
  		    			<span class="sel-item"><?php echo form_dropdown('assigned_user_id', $users_select, set_value('assigned_user_id', isset($task) ? $task->assigned_user_id : ''), 'class="txt"'); ?></span>
  		    		</div>
  		    	
  
  		    		<div class="six columns">
	  		    		<label for="status_id"><?php echo __('projects:status_id') ?></label>
	  		    		<span class="sel-item"><?php echo form_dropdown('status_id', $task_statuses, set_value('status_id', isset($task) ? $task->status_id : '')); ?></span>
	  		    	</div>
  		    	</div>
  		    </div>
  
  		    <div class="row">
				<label for="notes"><?php echo __('global:notes') ?></label>
				<?php echo form_textarea('notes', set_value('notes'), 'id="notes" class="txt"'); ?>
			</div>
  		
	  		<div class="row">
					<label for="is_viewable" style="float:left;"><?php echo __('tasks:is_viewable'); ?></label>
					<span style="float:left; margin-left:14px;"><?php echo form_checkbox(array(
					  'name' => 'is_viewable',
						'name' => 'is_viewable',
						'value' => 1,
						'checked' => (isset($task) ? ($task->is_viewable == 1) : TRUE)
					)); ?></span>
			</div>
                    
                        <?php assignments('project_tasks', isset($task) ? $task->id : 0)?>
  		
			<div class="row">
		    	<input type="hidden" name="project_id" value="<?php echo $project->id; ?>" />
				<a href="#" class="blue-btn" onclick="$('#<?php echo $action ?>_form').submit(); return false;">
					<span><?php echo __("global:save_task"); ?></span>
				</a>
			</div><!-- /row -->
  		
      <input type="submit" class="hidden-submit" />

   	</div><!-- /form-holder-->
			  
		<?php echo form_close(); ?>

	</div> <!-- /form-container -->
<a class="close-reveal-modal">&#215;</a>
</div><!-- /modal-form-holder -->

<?php echo asset::js('jquery.ajaxform.js'); ?>
<script type="text/javascript">
	$('#create_form').ajaxForm({
		dataType: 'json',
		success: showResponse
	});

	function showResponse(data)  {

		$('.notification').remove();

	    if (typeof(data.error) != 'undefined')
		{
			$('#form_container').before('<div class="notification error">'+data.error+'</div>');
		}
		else
		{
			$('#form_container').html('<div class="notification success">'+data.success+'</div>');
			setTimeout("window.location.reload()", 2000);
		}
	}

	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>