<script>
   
time_entries = <?php echo json_encode((object) $time_entries_for_billing);?>;
expenses = <?php echo json_encode((object) $expenses_for_billing);?>;
projects_per_client = <?php echo json_encode((object) $projects_per_client)?>;
project_order_per_client = <?php echo json_encode((object) $project_order_per_client)?>;
is_editing_invoice = true;

</script>
<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php if($invoice->type == 'ESTIMATE'): ?>
					<?php echo __('estimates:editestimate', array($invoice->invoice_number )) ?>
				<?php else: ?>
					<?php echo __('invoices:editinvoice', array($invoice->invoice_number)) ?>
				<?php endif; ?></h2>
		<?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
  <script>invoice_unique_id = '<?php echo $invoice->unique_id;?>';</script>

	<div class="form-holder">
		<?php echo form_open_multipart('admin/invoices/edit/'.$invoice->unique_id, 'id="create-invoice"'); ?>

	<div class="three columns push-nine side-bar-wrapper">
		<div class="panel">
		  
        <?php // Client Select ?>		    
   			<div class="row">
					<label for="lb06">Client</label>
					<div class="sel-item">
						<?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', $invoice->client_id), 'id="client"'); ?>
					</div>
					<p><a href="<?php echo site_url('admin/clients/create'); ?>" title="<?php echo __('clients:add'); ?>" class="blue-btn"><span><?php echo __('clients:add'); ?></span></a></p>
				</div><!-- /row end -->
                                <div class="row">
                           <label for="lb06">Project</label>
                           <div class="sel-item dropdown-arrow">
                                   <select data-original-edit-value="<?php echo $invoice->project_id?>" name="project_id" id='project_id'>
                                       <option value="">-- Not associated with a project --</option>
                                       <?php foreach ($projects as $project_dropdown_item): ?>
                                           <option value="<?php echo $project_dropdown_item->id ?>" <?php echo set_select('project_id', $project_dropdown_item->id, $project_dropdown_item->id == $invoice->project_id) ?>><?php echo $project_dropdown_item->name ?></option>
                                       <?php endforeach ?>
                                   </select>
                               </div>
                       </div><!-- /row end -->
		  
		    <?php // Invoice Type ?>
		    <input type='hidden' name='type' value='<?php echo $invoice->type;?>' />
				
				<div class="row">
					<label for="invoice_number"><?php echo __('invoices:number'); ?></label>
					<?php echo form_input('invoice_number', set_value('invoice_number', $invoice->invoice_number), 'id="invoice_number" class="txt"'); ?>
				</div><!-- .row -->
				
				<?php // Date of creation ?>
		    <div class="row">
				  <label for="date_entered"><?php echo __('invoices:date_entered');?></label>
				  <?php echo form_input('date_entered', set_value('date_entered', format_date($invoice->date_entered)), 'id="date_entered" class="text txt datePicker"'); ?>
			  </div>
			   
				<?php // Show in client area ?>
		   	<div class="row">
					<label for="is_recurring"><?php echo __('invoices:is_viewable') ?></label>
					<div class="sel-item">
						<?php echo form_dropdown('is_viewable', array(__('global:no'), __('global:yes')), set_value('is_viewable', $invoice->is_viewable), 'id="is_viewable"'); ?>
					</div>
		   	</div><!-- /row-->
				
		   	<?php // Recurring ?>
				<?php if (!$invoice->is_recurring or ($invoice->recur_id == $invoice->id)) :?>
  				<div class="row">
  					<label for="is_recurring">Recurring?</label>
  					<div class="sel-item">
  						<?php echo form_dropdown('is_recurring', array(__('global:no'), __('global:yes')), set_value('is_recurring', $invoice->is_recurring), 'id="is_recurring"'); ?>
  					</div>
  				  
    				<div id="recurring-options" class="twelve columns" style="display:none">
      				<div class="row">
                  <label>&nbsp;</label>
                  <p class="description"><?php echo __('global:you_need_pancake_cron_job')?><br /><?php echo __('global:if_you_dont_know_how_to_set_it_up')?></p>
              </div>
              
    					<div class="row">
    						<label for="frequency">Frequency</label>
    						<div class="sel-item">
                   <?php echo form_dropdown('frequency', array('w' => __('global:week'), 'm' => __('global:month'), 'q' => __('global:quarterly'), 's' => __('global:every_six_months'), 'y' => __('global:year'), 'b' => __('global:biyearly'),), set_value('frequency', $invoice->frequency), 'id="frequency"'); ?>
    						</div>
    					</div>
    
    					<div class="row">
    						<label for="auto_send">Auto Send?</label>
    						<div class="sel-item">
    							<?php echo form_dropdown('auto_send', array('No', 'Yes'), set_value('auto_send', $invoice->auto_send), 'id="auto_send"'); ?>
    						</div>
    					</div>
    
              		<div class="row">
    				    <label for="send_x_days_before">Send</label>
    						<div class="three columns" style="margin-left: 0;"><?php echo form_input('send_x_days_before', set_value('send_x_days_before', $invoice->send_x_days_before), 'id="send_x_days_before" class="text txt"'); ?></div>
                			<div class="nine columns send_x_days_before_label">days before invoice is due</div>
    					</div><!-- /row -->
    				</div><!-- /recurring-->
    		    </div><!-- /row -->
				<?php else:?>
				  <div class="row">
						<label>Recurring?</label>
						<label class="cannot_change_recurrence_settings">You cannot change the recurrence settings of an invoice that is a recurrence of another invoice.</label>
					</div>
				<?php endif;?>
					
        	<input type="hidden" name="due_date" value="0" />
		</div><!-- /panel -->
	</div><!-- /three -->

		<div class="nine columns pull-three content-wrapper"> 
		  <?php // description ?>
		  <div class="row">
				<label for="description"><?php echo __('global:description') ?></label>
				<?php
					echo form_textarea(array(
						'name' => 'description',
						'id' => 'description',
						'value' => set_value('description', $invoice->description),
						'rows' => 4,
						'cols' => 50
					));
				?>
		  </div><!-- /row end -->
		  
		  <?php // List items ?>
		  <div id="DETAILED-wrapper" class="type-wrapper row">
				<label for="nothing">Line Items</label>
				<table class="pc-table" id="invoice-items">
					<thead>
						<tr>
							<th class="name-head"><?php echo __('items:name') ?></th>
							<th class="qty-head"><?php echo __('items:qty_hrs') ?></th>
						  <th class="amount-head"><?php echo __('items:rate') ?></th>
							<th class="tax-head"><?php echo __('items:tax_rate') ?></th>
							<th class="type-head"><?php echo __('items:type') ?></th>
				  		<th class="cost-head"><?php echo __('items:cost') ?></th>
					  	<th class="actions-head"><?php echo __('global:actions') ?></th>
						</tr>
					</thead>
                                                          <tfoot>
                                                              <tr>
                                                                  <td class="name-head" colspan="7">
                                                                    <div class="difference">
                                                                        <?php echo __('reports:total_amount') ?>: <span class="symbol"><?php echo Currency::symbol(); ?></span><span class="value"></span>
                                                                    </div>
                                                                  </td>
                                                              </tr>
                                                          </tfoot>
					
					<tbody class="make-it-sortable">
					  <?php foreach ($invoice->items as $item): ?>
					    <tr class="parent-line-item-table-row">
					      <td colspan="7" class="parent-line-item-table-cell">
					        <table class="sub-invoice-table">
                    <tr class="details">
  						        <td class="name-row"><input type="text" name="invoice_item[name][]" data-item-type="<?php echo isset($item['type']) ? $item['type'] : 'standard'; ?>" class="item_name" value="<?php echo form_prep($item['name']); ?>" /></td>
							        <td class="qty-row"><input type="text" name="invoice_item[qty][]" class="item_quantity" value="<?php echo $item['qty']; ?>" /></td>
							        <td class="amount-row"><input type="text" name="invoice_item[rate][]" class="item_rate"  value="<?php echo $item['rate']; ?>"  /></td>
							        <td class="tax-row"><span class="sel-item"><?php echo form_dropdown('invoice_item[tax_id][]', Settings::tax_dropdown(), isset($item['tax_id']) ? $item['tax_id'] : 0, 'class="tax_id"'); ?></span></td>
						          <td class="type-row">
                                                              <input type="hidden" class='item_time_entries' name="invoice_item[item_time_entries][]" value="<?php echo (isset($item['id']) and isset($item_time_entries[$item['id']])) ? $item_time_entries[$item['id']] : ''; ?>">
                                                              <input type="hidden" class='item_type_id' name="invoice_item[item_type_id][]" value="<?php echo invoice_item_type_id($item); ?>"><span class="sel-item"><?php echo form_dropdown('invoice_item[type][]', Item_m::type_dropdown(), isset($item['type']) ? $item['type'] : 'standard', ''); ?></span></td>
							       <td class="cost-row">
								       <input type="hidden" name="invoice_item[total][]" value="<?php echo number_format($item['total'], 2); ?>" />
								       <span class="item_cost"><?php echo number_format($item['total'], 2); ?></span>
							       </td>
  								   <td class="actions-row">
  									  <a href="#" class="icon sort" style="margin:0; cursor:move;" title="<?php echo __('global:sort') ?>"><?php echo __('global:sort') ?></a>
  									  <a href="#" class="icon delete" style="margin:0;"><?php echo __('global:remove') ?></a>
  								   </td>
  						    </tr>
  						      <tr class="description">
  								    <td colspan="7">
  									    <textarea name="invoice_item[description][]" class="item_description"><?php echo $item['description']; ?></textarea>
  								    </td>
  						      </tr>
                  </table>
                </td>
              </tr>
			      <?php endforeach; ?>
			    </tbody>
		    </table>
		    <p><a class="blue-btn" href="#" id="add-row"><span><?php echo __('items:add') ?></span></a></p>
		  </div><!-- /row end -->
		   
		  <?php // Notes ?>
		  <div class="row">
				<label for="lb08"><?php echo __('global:notes') ?></label>
				<div class="textarea">
					<?php
						echo form_textarea(array(
							'name' => 'notes',
							'id' => 'notes',
							'value' => set_value('notes', $invoice->notes),
							'rows' => 4,
							'cols' => 50
						));
					?>
				</div>
	    </div><!-- /row end -->

		  <?php // File upload?>
	    <div class="row">
			  <label for="nothing"><?php echo __('invoices:files'); ?></label>
				<table class="pc-table" style="width: 100%;">
					<thead>
						<tr>
							<th><?php echo __('invoices:file_name'); ?></th>
										<th><?php echo __('invoices:date_created'); ?></th>
										<th><?php echo __('invoices:size'); ?></th>
							<th>Remove?</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($files as $file): ?>
						<tr>
							<td><a href="<?php echo site_url('uploads/'.$file['real_filename']); ?>" target="_blank"><?php echo $file['orig_filename']; ?></a></td>
							<td><?php echo date("M d, Y h:i:s a", filemtime('uploads/'.$file['real_filename'])); ?></td>
							<td><?php echo filesize('uploads/'.$file['real_filename']); ?></td>
							<td style="text-align: center"><input type="checkbox" name="remove_file[]" class="remove_file" value="<?php echo $file['id']; ?>" /></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div>
					<ul id="file-inputs">
						<li><?php echo form_upload('invoice_files[]'); ?></li>
					</ul>
						<div class="submit-holder">
						  <p> <a class="blue-btn" href="#" id="add-file-input"> <span><?php echo __('global:add_more'); ?></span> </a> </p>
						</div>
				</div>
			</div><!-- /row end -->
				
				
			<div id="SIMPLE-wrapper" class="type-wrapper row">
				<label for="amount"><?php echo __('invoices:amount') ?> (<?php echo $invoice->currency_code ? $invoice->currency_code : Currency::symbol(); ?>)</label>
				<?php echo form_input('amount', set_value('amount', $invoice->amount), 'class="txt"'); ?>
			</div><!-- /row end -->

                        <div class="hide-estimate">
                        <div class="gateway-items row">
                            <?php $this->load->view('invoices/partial_input_container', array('action' => 'edit', 'currency_code' => $invoice->currency_code, 'parts' => isset($invoice->partial_payments[1]) ? $invoice->partial_payments : array('key' => 1))); ?>
                            <?php require_once APPPATH . 'modules/gateways/gateway.php'; ?>

                            <label><?php echo lang('gateways:paymentmethods') ?></label>

                            <?php if (!empty($gateways)) : ?>
                                <?php $checked = Gateway::get_item_gateways('INVOICE', $invoice->id); ?>
                                <?php $first = true;
                                foreach ($gateways as $gateway) : ?>
                                    <div class="gateway <?php echo!$first ? 'not-first' : null; ?>">
                                        <input type="checkbox" name="gateways[<?php echo $gateway['gateway']; ?>]" id="gateways-<?php echo $gateway['gateway']; ?>" <?php echo $checked[$gateway['gateway']] ? 'checked="checked"' : ''; ?> value="1" />
                                        <label for="gateways-<?php echo $gateway['gateway']; ?>"><?php echo $gateway['title']; ?></label>
                                    </div>
                                    <?php $first = false;
                                endforeach; ?>

                            <?php else: ?>
                                <p><?php echo __('invoices:no_payment_gateways_enabled', array(site_url('admin/settings'))) ?></p>
                        <?php endif; ?>
                        </div>
                            </div>
                        
                        <?php assignments(set_radio('type', 'ESTIMATE', ($invoice->type == 'ESTIMATE')) ? 'estimates' : 'invoices', $invoice->id); ?>
				
		    <div class="row">
				<label for="nothing">&nbsp;</label>
				<a href="#" class="blue-btn" onclick="$('#create-invoice').submit();"><span><?php echo __('global:save'); ?>&rarr;</span></a>
		    </div>      
        
      		<input type="submit" class="hidden-submit" />
		</div><!-- /nine -->

		<?php echo form_close(); ?>

	</div><!-- /form-holder -->
</div><!-- /row -->


<?php
//	asset::js('jhtmlarea-0.7.0.min.js', array(), 'invoice');
	asset::js('invoice-form.js', array(), 'invoice');
//	asset::css('jHtmlArea.css', array(), 'invoice');
	echo asset::render('invoice');
?>