<div class="modal-form-holder">

<div id="modal-header">
	 <div class="row">
	   <h3 class="ttl ttl3"><?php echo lang('projects.'.$action.'.title'); ?></h3>
	 </div>
</div>

<div class="row">

	<div id="form_container">
		<div class="form-holder">

			<?php echo form_open('admin/projects/'.$action, array('id' => 'create_form')); ?>

				<div class="row">
					<label for="name"><?php echo lang('projects.label.name'); ?></label>
					<?php echo form_input('name', set_value('name', isset($project) ? $project->name : ''), 'class="txt"'); ?>

					<div class="row add-bottom">
						<label class="twelve columns" for="client_id"><?php echo lang('projects.label.client'); ?></label>
						<div class="twelve columns">
							<span class="sel-item"><?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', isset($project) ? $project->client_id : 0)); ?></span>
						</div>
						<!--  Hidden the "Add a Client" button until it can be improved upon.
							  Right now clicking it brings the user to a new page, losing any
							  information they've filled in on the New Project form. Bad UX!
						<div class="three columns">
							<p style="margin-top:5px;"><?php echo anchor('admin/clients/create', '<span>Add a Client</span>', 'class="blue-btn"'); ?></p>
						</div>-->
					</div>


					<div class="row add-bottom">
						<div class="six columns">
							<label for="due_date"><?php echo __('settings:currency');?></label>
							<?php if ($action == 'create'): ?>
								<span class="sel-item">
									<?php echo form_dropdown('currency', $currencies, set_value('currency',  isset($project) ? $project->currency_code : ''), 'id="currency"'); ?>
								</span>
							<?php else: ?>
								<?php echo $project->currency_code ? $project->currency_code : Currency::code(); ?>
							<?php endif; ?>

						</div><!-- /6-->

						<div class="six columns">
							<label for="rate"><?php echo lang('projects.label.rate'); ?></label>
							<?php echo form_input('rate', set_value('rate', isset($project) ? $project->rate : '0.00'), 'id="rate" class="txt"'); ?>
						</div>
					</div>

					<div class="row add-bottom">
						<div class="six columns">
							<label for="projected_hours"><?php echo __('projects:projected_hours'); ?></label>
							<?php echo form_input('projected_hours', set_value('projected_hours', isset($project) ? $project->projected_hours : '0'), 'id="projected_hours" class="txt"'); ?>
						</div><!-- /6 -->

						<div class="six columns">
							<label for="due_date"><?php echo lang('projects.label.due_date'); ?></label>
							<?php echo form_input('due_date', format_date(set_value('due_date', isset($project) ? $project->due_date : time())), 'id="due_date" class="datePicker txt"'); ?>
						</div>
					</div>


					<label for="description"><?php echo lang('projects.label.description'); ?></label>
					<?php echo form_textarea(array(
						'name' => 'description',
						'id' => 'description',
						'value' => set_value('description', isset($project) ? $project->description : ''),
						'rows' => 4,
						'cols' => 50
					)); ?>

					<div class="row">
						<label class="four columns" for="is_viewable"><?php echo lang('projects.label.is_viewable'); ?></label>
						<div class="eight columns">
							<?php echo form_checkbox(array(
								'name' => 'is_viewable',
								'name' => 'is_viewable',
								'value' => 1,
								'checked' => (isset($project) ? ($project->is_viewable == 1) : TRUE)
							)); ?>
						</div>
					</div>

					<?php assignments('projects', (isset($project) ? $project->id : 0)); ?>

					<br />

					<?php if (isset($project)): ?>
						<input type="hidden" name="id" value="<?php echo $project->id; ?>" />
					<?php endif; ?>
				</div>

				<a href="#" class="blue-btn" onclick="return $('#create_form').submit();"><span><?php echo lang('projects.button.'.$action); ?></span></a>
			</div>

		</form>
</div></div>

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
			return false;
		}
		else
		{
			setTimeout("window.location.reload()", 2000);
		}
	}

	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>
