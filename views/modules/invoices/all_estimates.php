<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo lang('estimates:alltitle') ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
  <?php echo form_open(uri_string()); ?>
  

    <div class="three columns push-nine side-bar-wrapper" style="margin-top: 0px;">
        <div class="panel form-holder">
            <h4 class="sidebar-title"><?php echo __('global:quick_links') ?></h4>
            <ul class="side-bar-btns">
                <?php if (can_for_any_client('create', 'estimates')): ?>
                    <li class="add"><a id="create_project" href="<?php echo site_url('admin/estimates/create'); ?>" title="<?php echo __('estimates:create') ?>"><span><?php echo __('estimates:create') ?></span></a></li>    
                <?php endif ?>
            </ul>
                <label for="client_id"><?php echo __('clients:filter');?></label>
                <span class="dropdown-arrow"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="this.form.submit()"'); ?></span>
            
        </div><!-- /panel -->
    </div><!-- /three columns side-bar-wrapper -->

    <div class="nine columns pull-three content-wrapper">
  		<?php if (empty($invoices)): ?>
  
    		<div class="no_object_notification">
    	   	<h4><?php echo $client_id ? __('estimates:noestimatesforthefilteredclient', array(trim(str_ireplace('(0)', '', $clients_dropdown[$client_id])))) : lang('estimates:noestimatetitle') ?></h4>
    	   	<p><?php echo lang('estimates:noestimatebody') ?></p>
    	   	<p class="call_to_action"><a href="<?php echo site_url('admin/estimates/create_estimate'); ?>" class="blue-btn"><span><?php echo lang('estimates:createnew') ?></span></a></p>
    		</div><!-- /no_object_notification -->
  
  		<?php else: ?>
  
  			<div id="project_container">
  				<div class="table-area thirty-days invoice-group">
  				    <?php $this->load->view('reports/table', array('rows' => $invoices)); ?>
  				</div>
  			</div>
  
  		  <div class="pagination">
  		    <?php echo $this->pagination->create_links(); ?>
  		  </div>
  
  		<?php endif; ?>
  </div><!-- /nine columns content-wrapper -->
  
  <?php echo form_close(); ?>

</div><!-- /row -->

<div class="invoice-block">
	<br style="clear: both;" />
</div>


