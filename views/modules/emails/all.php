<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo lang('emailtemplates:email_templates') ?></h2>
		<?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
	<div class="nine columns content-wrapper">
  		<?php if (empty($templates)): // If there aren't invoices ?>

    		<div class="no_object_notification">
    			<h4><?php echo lang('invoices:noinvoicetitle') ?></h4>
    			<p><?php echo lang('invoices:noinvoicebody') ?></p>
    			<p class="call_to_action"><a class="blue-btn" id="create_project" href="<?php echo site_url('admin/invoices/create'); ?>" title="<?php echo lang('invoices:newinvoice') ?>"><span><?php echo lang('invoices:newinvoice') ?></span></a></p>
    		</div><!-- /no_object_notification -->

      <?php else: // else we do the following ?>

        <div class=" thirty-days invoice-group">

	<table width="100%">
		<thead>
		<tr>
		<th><?php echo __('emailtemplates:name') ?></th>
		<th><?php echo __('emailtemplates:subject') ?></th>
		<th><?php echo __('emailtemplates:days') ?></th>
		<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>


			<?php foreach($templates as $email): ?>


				<tr>
					<td>
						<?php echo $email->name ?>
					</td>
					<td>
						<?php echo stripslashes($email->subject) ?>
					</td>
					<td>
					<?php echo $email->days ?>
					</td>
					<td>
						<a href="<?php echo site_url('/admin/emails/edit/'.$email->id ) ?>" class="blue-btn">
				          <span><?php echo lang('global:edit') ?></span>
				        </a>
					&nbsp;
						<a href="<?php echo site_url('/admin/emails/delete/'.$email->id) ?>" class="blue-btn">
				          <span><?php echo lang('global:delete') ?></span>
				        </a>
					</td>
				</tr>

			<?php endforeach ?>
			</table>

			<a href="<?php echo site_url('/admin/emails/create/') ?>" class="blue-btn">
	          <span><?php echo lang('emailtemplates:create_template') ?></span>
	        </a>


        </div>


      <?php endif; ?>
	</div><!-- /nine columns content-wrapper -->

	<div class="three columns side-bar-wrapper">
		<div class="panel">

			<h4 class="sidebar-title"><?php echo __('global:quick_links') ?></h4>
			<ul class="side-bar-btns">
				<li class="add"><a id="manage_email_template" href="<?php echo site_url('admin/emails/create'); ?>" title="<?php echo lang('emailtemplates:create') ?>"><span><?php echo lang('emailtemplates:create_template') ?></span></a></li>
				<li class="add"><a id="email_reminders" href="<?php echo site_url('admin/invoices/reminders'); ?>" title="<?php echo lang('reminders:reminders') ?>"><span><?php echo lang('reminders:reminders') ?></span></a></li>
			</ul>




			<div class="filters">
				<div class="form-holder row">

				</div><!-- /form-holder -->
			</div><!-- /filters -->
		</div><!-- /panel -->
	</div><!-- /three columns side-bar-wrapper -->
</div><!-- /row -->





