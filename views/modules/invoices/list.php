<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo $list_title; ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
<?php echo form_open(uri_string()); ?>

    <div class="three columns push-nine side-bar-wrapper" style="margin-top: 0px;">
        <div class="panel form-holder">
            <h4 class="sidebar-title"><?php echo __('global:quick_links') ?></h4>
            <ul class="side-bar-btns">
                <?php if (can_for_any_client('create', 'invoices')): ?>
                    <li class="add"><a id="create_project" href="<?php echo site_url('admin/invoices/create'); ?>" title="<?php echo lang('invoices:create') ?>"><span><?php echo lang('invoices:create') ?></span></a></li>    
                <?php endif ?>
            </ul>

            <h4 class="sidebar-title"><?php echo lang('clients:filter') ?></h4>
            <p><span class="dropdown-arrow"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="this.form.submit()"'); ?></span></p>
        </div><!-- /panel -->
    </div><!-- /three columns side-bar-wrapper -->

    <div class="nine columns pull-three content-wrapper">

      <?php if (empty($invoices)): ?>
      
  			<div class="invoice-block">
  				<div  class="no_object_notification">
  				<h4><?php echo $client_id ? __('invoices:noinvoicesforthefilteredclient', array(trim(str_ireplace('(0)', '', $clients_dropdown[$client_id])))) : lang('invoices:noinvoicetitle') ?></h4>
  				<p><?php echo lang('invoices:noinvoicebody') ?></p>
  				</div><!-- /no_object_notification -->
  			</div><!-- /invoice-block -->
  			
  		<?php else: ?>
 
  			<div class="table-area thirty-days invoice-group">
  				<?php $this->load->view('reports/table', array('rows' => $invoices)); ?>
  			</div><!-- /table-area -->
  
  			<div class="pagination">
  				<?php echo $this->pagination->create_links(); ?>
  			</div><!-- /pagination -->

  		<?php endif; ?>

  </div><!-- /nine columns content-wrapper -->
<?php echo form_close(); ?>

</div><!-- /form -->
