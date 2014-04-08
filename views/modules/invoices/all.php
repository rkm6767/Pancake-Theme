<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo lang('invoices:all') ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
	<div class="three columns push-nine side-bar-wrapper" style="margin-top: 0px;">
		<div class="form-holder panel">

			<h4 class="sidebar-title"><?php echo __('global:quick_links') ?></h4>
			<ul class="side-bar-btns">
				<?php if (can_for_any_client('create', 'invoices')): ?>
					<li class="add"><a href="<?php echo site_url('admin/invoices/create'); ?>" title="<?php echo lang('invoices:create') ?>"><span><?php echo lang('invoices:create') ?></span></a></li>	
				<?php endif ?>
			</ul>

			<div class="filters">
				<?php echo form_open(uri_string()); ?>
					<h4 class="sidebar-title"><?php echo lang('clients:filter') ?></h4>
					<p><span class="dropdown-arrow"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="this.form.submit()"'); ?></span></p>
				<?php echo form_close(); ?>
			</div><!-- /filters -->
		</div><!-- /panel -->
	</div><!-- /three columns side-bar-wrapper -->

	<div class="nine columns pull-three content-wrapper">
  		<?php if (empty($invoices)): // If there aren't invoices ?>

    		<div class="no_object_notification">
    			<h4><?php echo $client_id ? __('invoices:noinvoicesforthefilteredclient', array(trim(str_ireplace('(0)', '', $clients_dropdown[$client_id])))) : lang('invoices:noinvoicetitle') ?></h4>
    			<p><?php echo lang('invoices:noinvoicebody') ?></p>
    			<p class="call_to_action"><a class="blue-btn" href="<?php echo site_url('admin/invoices/create'); ?>" title="<?php echo lang('invoices:newinvoice') ?>"><span><?php echo lang('invoices:newinvoice') ?></span></a></p>
    		</div><!-- /no_object_notification -->

      <?php else: // else we do the following ?>

        <div class="table-area thirty-days invoice-group">
      		<?php $this->load->view('reports/table', array('rows' => $invoices)); ?>
        </div>

        <div class="pagination">
      		<?php echo $this->pagination->create_links(); ?>
        </div>

      <?php endif; ?>
	</div><!-- /nine columns content-wrapper -->

</div><!-- /row -->





