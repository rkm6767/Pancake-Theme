<?php

// Page for Project Overview Area

?>

<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo lang('projects:alltitle'); ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
  <div class="nine columns content-wrapper">
  <?php if (!IS_AJAX): ?>

  	<div class="invoice-block">

  		<div id="ajax_container"></div>

  	</div>

  	<?php endif; ?>


  	<?php if ( ! $projects): ?>
  		<div class="no_object_notification">
  	    <h4><?php echo lang('projects:noprojecttitle'); ?></h4>
  		<p><?php echo lang('projects:noprojecttext'); ?></p>
  		<p class="call_to_action">
  			<?php if ($archived_count > 0): ?>
  				<a class="blue-btn" href="<?php echo site_url('admin/projects/archived'); ?>"><span><?php echo lang('projects:archive'); ?></span></a>
  			<?php endif; ?>
  			<a class="blue-btn fire-ajax" id="create_project" href="<?php echo site_url('admin/projects/create'); ?>"><span><?php echo lang('projects:add'); ?></span></a>
  		</p>
  		</div>
  	<?php else: ?>

		  <?php $this->load->view('projects/_projects_row', array('rows' => $projects)); ?>


  		<div class="pagination">
  			<?php echo $this->pagination->create_links(); ?>
  		</div>

  	<?php endif; ?>

  </div><!-- /nine columns content-wrapper-->

  <div class="three columns side-bar-wrapper">
      <div class="panel">
          <div class="row">
              <h4 class="sidebar-title">Projects</h4>
              <p>Track milestones, tasks and time for various projects.</p>
          </div>
          <div class="row">
              <ul class="btns-list side-bar-btns">
                  <li class="add"><a li_class="add" class="create-project fire-ajax" id="create_project" href="<?php echo site_url("admin/projects/create");?>"><span>Create Project</span></a></li>
                  <li class="add"><a li_class="add" class="create-project-template fire-ajax" id="create_from_project" href="<?php echo site_url("admin/projects/templates")?>"><span>Create from Template</span></a></li>
                  <?php if ($template_count > 0): ?>
                    <li class="delete"><a li_class="delete" class="delete-project-templates fire-ajax" id="delete_project_templates" href="<?php echo site_url("admin/projects/delete_templates")?>"><span>Delete Project Template</span></a></li>
                  <?php endif; ?>
              </ul>
          </div>
          <div class="row" style="margin-top: -12px;">
              <ul class="side-bar-btns">
                  <li class="view-archive"><a href="<?php echo site_url('admin/projects/archived'); ?>"><span><?php echo lang('projects:archive'); ?></span></a></li>
              </ul>
          </div>
      </div><!-- /panel -->
  </div><!-- /three columns side-bar-wrapper-->
</div><!-- row -->

<?php echo asset::js('jquery.history.js'); ?>
<script type="text/javascript">
	var client_id = <?php echo isset($client->id) ? $client->id : 'null';?>;

	$.history.init(function(hash){
	    if(hash == "create") {
		$(document).ready(function() {
		    $('#create_project').click();
		});
	    } else {
	    }
	},
	{ unescape: ",/" });

	$('.projectItem').wookmark({
		container: $('#projectholder'),
		offset: 0,
		autoResize: true
	});
</script>