<script>
   
time_entries = <?php echo json_encode((object) $time_entries_for_billing);?>;
expenses = <?php echo json_encode((object) $expenses_for_billing);?>;
projects_per_client = <?php echo json_encode((object) $projects_per_client)?>;
project_order_per_client = <?php echo json_encode((object) $project_order_per_client)?>;
is_editing_invoice = false;

</script>
<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo isset($estimate) ? lang('estimates:createnew') : lang('invoices:newinvoice'); ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
<?php $_POST = reconvert_dates($_POST); ?>
<script>invoice_unique_id = '<?php echo $unique_id;?>';</script>
<?php if (!isset($iframe) or !$iframe) :?><?php endif;?>

<?php echo form_open_multipart('admin/invoices/create/'.((!isset($iframe) or !$iframe) ? '' : 'iframe'), 'id="create-invoice"'); ?>
  <input type="hidden" name="unique_id" value="<?php echo $unique_id;?>">

	<div class="three columns push-nine side-bar-wrapper">
		<div class="panel form-holder">
       <?php if (!isset($iframe) or !$iframe) :?>
			   <div class="row">
				   <label for="lb06">Client</label>
				   <div class="sel-item dropdown-arrow">
  				   <?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', isset($client_id) ? $client_id : (isset($project) ? (int) $project->client_id : '')), 'id="client"'); ?>
  				 </div>
                                   <?php if (is_admin()): ?>
  				 <div style="margin-bottom: 16px;"><a href="<?php echo site_url('admin/clients/create'); ?>" title="<?php echo __('clients:add'); ?>" class="blue-btn"><span><?php echo __('clients:add'); ?></span></a></div>
                                 <?php endif;?>
  		   </div><!-- /row end -->
                   <div class="row">
                           <label for="lb06">Project</label>
                           <div class="sel-item dropdown-arrow">
                                   <select name="project_id" id='project_id' data-original-edit-value="<?php echo (isset($project) ? (int) $project->id : 0)?>">
                                       <option value="">-- Not associated with a project --</option>
                                       <?php foreach ($projects as $project_dropdown_item): ?>
                                           <option value="<?php echo $project_dropdown_item->id ?>" <?php echo set_select('project_id', $project_dropdown_item->id, $project_dropdown_item->id == (isset($project) ? (int) $project->id : 0)) ?>><?php echo $project_dropdown_item->name ?></option>
                                       <?php endforeach ?>
                                   </select>
                               </div>
                       </div><!-- /row end -->
       <?php else: ?>
         <input type="hidden" name="client_id" value="<?php echo (isset($client_id) ? $client_id: ''); ?>">
       <?php endif;?>
                <input type='hidden' name='type' value='<?php echo isset($estimate) ? 'ESTIMATE' : 'DETAILED'?>' />

			<div class="row">
				<label for="invoice_number"><?php echo __('invoices:number'); ?></label>
				<?php echo form_input('invoice_number', set_value('invoice_number', isset($invoice_number) ? $invoice_number : ''), 'id="invoice_number" class="txt"'); ?>
			</div>

			<div class="row">
				<label for="date_entered"><?php echo __('invoices:date_entered');?></label>
				<?php echo form_input('date_entered', set_value('date_entered', format_date(time())), 'id="date_entered" class="text txt datePicker"'); ?>
			</div>

			<div class="row">
				<label for="is_recurring"><?php echo __('invoices:is_viewable') ?></label>
				<div class="dropdown-arrow">
					<?php echo form_dropdown('is_viewable', array(__('global:no'), __('global:yes')), set_value('is_viewable'), 'id="is_viewable"'); ?>
				</div>
			</div>

			<div class="row hide-estimate">
				<label for="is_recurring"><?php echo __('invoices:is_recurring') ?></label>
				<div class="dropdown-arrow">
					<?php echo form_dropdown('is_recurring', array(__('global:no'), __('global:yes')), set_value('is_recurring'), 'id="is_recurring"'); ?>
				</div>
			</div>

			<div id="recurring-options" style="display:none">

         <label>&nbsp;</label>
         <p class="description"><?php echo __('global:you_need_pancake_cron_job')?><br /><?php echo __('global:if_you_dont_know_how_to_set_it_up')?></p>

					<label for="frequency">Frequency</label>
					<div class="dropdown-arrow">
						<?php echo form_dropdown('frequency', array('w' => __('global:week'), 'm' => __('global:month'), 'q' => __('global:quarterly'), 's' => __('global:every_six_months'), 'y' => __('global:year'), 'b' => __('global:biyearly'),), set_value('frequency', 'm'), 'id="frequency"'); ?>
					</div>

					<label for="auto_send">Auto Send?</label>
					<div class="dropdown-arrow">
						<?php echo form_dropdown('auto_send', array(__('global:no'), __('global:yes')), set_value('auto_send', 1), 'id="auto_send"'); ?>
					</div>

					<label for="send_x_days_before">Send</label>
						<?php echo form_input('send_x_days_before', set_value('send_x_days_before', Settings::get('send_x_days_before')), 'id="send_x_days_before" class="text txt"'); ?>
          <label class="send_x_days_before_label">days before invoice is due</label>
			</div>

                        <input type="hidden" name="due_date" value="0" />



			<div class="row">
				<label for="currency"><?php echo __('settings:currency');?></label>
				<div class="dropdown-arrow">
                	<select id="currency" name="currency">
	                    <?php foreach ($currencies as $code => $currency) : ?>
	                        <?php $selected = (isset($project) and $project->currency_code == $code) ? true : (($code == '0') ? true : false); ?>
	                        <option value="<?php echo $code;?>" data-symbol="<?php echo Currency::symbol($code);?>" <?php echo set_select('currency', $code, $selected); ?>><?php echo $currency;?></option>
	                    <?php endforeach; ?>
	                </select>
				</div>
			</div>

		</div><!-- /panel -->
	</div><!-- /three columns side-bar-wrapper -->

	<div class="nine columns pull-three content-wrapper">		
		<div class="form-holder">
				<fieldset>
		      <?php if (!isset($iframe) or !$iframe) :?>
  					<div class="row">
  						<label for="description"><?php echo __('global:description') ?></label>
  						<?php
  							echo form_textarea(array(
  								'name' => 'description',
  								'id' => 'description',
  								'value' => set_value('description', isset($project) ? $project->description : ''),
  								'rows' => 4,
  								'cols' => 50
  							));
  						?>
  					</div><!-- /row end -->
          <?php else: ?>
              <input type="hidden" name="description" value="">
          <?php endif;?>

          <!-- item list -->
					<div id="DETAILED-wrapper" class="type-wrapper row">
					  <label for="nothing"><?php echo __('items:line_items') ?></label>
						  <table id="invoice-items">
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
							    <?php foreach ($items as $item): ?>
                    <tr class="parent-line-item-table-row">
	                    <td colspan="7" class="parent-line-item-table-cell">
		                    <table class="sub-invoice-table">
			                    <tr class="details">
								  <td class="name-row"><input type="text" class="item_name" name="invoice_item[name][]" data-item-type='<?php echo isset($item['type']) ? $item['type'] : 'standard'; ?>' value="<?php echo form_prep($item['name']); ?>" /></td>
								  <td class="qty-row"><input type="text" name="invoice_item[qty][]" class="item_quantity" value="<?php echo $item['qty']; ?>" /></td>
								  <td class="amount-row"><input type="text" name="invoice_item[rate][]" class="item_rate" value="<?php echo $item['rate']; ?>" /></td>
								  <td class="tax-row tax-dropdown"><span class="dropdown-arrow"><?php echo form_dropdown('invoice_item[tax_id][]', Settings::tax_dropdown(), isset($item['tax_id']) ? $item['tax_id'] : Settings::get('default_tax_id'), 'class="tax_id"'); ?></span></td>
								  <td class="type-row"><input type="hidden" class='item_time_entries' name="invoice_item[item_time_entries][]" value="<?php echo isset($item['item_time_entries']) ? $item['item_time_entries'] : ''; ?>"><input type="hidden" class='item_type_id' name="invoice_item[item_type_id][]" value="<?php echo invoice_item_type_id($item); ?>"><span class="dropdown-arrow"><?php echo form_dropdown('invoice_item[type][]', Item_m::type_dropdown(), isset($item['type']) ? $item['type'] : 'standard', ''); ?></span></td>
								  <td class="cost-row">
									  <input type="hidden" name="invoice_item[total][]" class="item_cost" value="<?php echo number_format($item['total'], 2); ?>" />
									  <span class="item_cost"><?php echo number_format($item['total'], 2); ?></span>

										<?php
											if ( ! empty($item['entries'])):
											foreach ($item['entries'] as $entry):
										 	echo form_hidden('entries[][]', $entry->id);
											endforeach;
											endif;
										?>
								  </td>
								  <td class="actions-row">
									  <a href="javascript:void(0)" class="icon sort" style="margin:0; cursor:move;" title="<?php echo __('global:sort') ?>"><?php echo __('global:sort') ?></a>
									  <a href="javascript:void(0)" class="icon delete" style="margin:0;"><?php echo __('global:remove') ?></a>
								  </td>
								</tr>
								<tr class="description">
									<td colspan="7">
										<textarea name="invoice_item[description][]" rows="2" class="item_description" placeholder="Description"><?php echo $item['description']; ?></textarea>
									</td>
								</tr>
                        </table>
	                    </td>
		                </tr>
								<?php endforeach; ?>
				      </tbody>
				    </table>

						<a class="blue-btn" href="#" id="add-row"><span><?php echo __('items:add') ?></span></a> <br/><br />
				  </div><!-- /row end -->

						<?php if (!isset($iframe) or !$iframe) :?>
						<div class="row">
							<label for="lb08"><?php echo __('global:notes') ?></label>
							<div class="textarea">
								<?php
									echo form_textarea(array(
										'name' => 'notes',
										'id' => 'notes',
										'value' => set_value('notes', Settings::get('default_invoice_notes')),
										'rows' => 4,
										'cols' => 50
									));
								?>
							</div>
						</div><!-- /row end -->
						
		        <?php else: ?>
		            <input type="hidden" name="notes" value="">
		        <?php endif;?>

						<div class="row hide-estimate">
							<label for="nothing"><?php echo __('invoices:files'); ?></label>
							<table class="pc-table" style="width: 100%">
								<thead>
									<tr>
										<th><?php echo __('invoices:file_name'); ?></th>
										<th><?php echo __('invoices:date_created'); ?></th>
										<th><?php echo __('invoices:size'); ?></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<div>
								<?php echo __('global:upload_files'); ?>: 
								<ul id="file-inputs">
									<li><?php echo form_upload('invoice_files[]'); ?></li>
								</ul>
								<div class="submit-holder">
										<a class="blue-btn" href="#" id="add-file-input"><span><?php echo __('global:add_more'); ?></span></a>
								</div> <br/>
							</div>
						</div><!-- /row end -->
		        
		        <div id="SIMPLE-wrapper" class="type-wrapper row">
							<label for="amount">Amount (<span id="symbol"><?php echo Currency::symbol(); ?></span>)</label>
							<?php echo form_input('amount', set_value('amount'), 'class="txt"'); ?>
						</div><!-- /row end -->
		        
		        <?php $this->load->view('invoices/partial_input_container', array('action' => 'create', 'parts' => array('key' => 1))); ?>

                                                <div class="hide-estimate">
		   			<div class="gateway-items row">
		          <?php require_once APPPATH.'modules/gateways/gateway.php'; ?>
		          <?php $checked = Gateway::get_item_gateways('INVOICE', 0); ?>

							<label><?php echo lang('gateways:paymentmethods')?></label>

							<?php if ($gateways): ?>
			                    <?php $first = true; foreach ($gateways as $gateway) : ?>
			                    <div class="gateway <?php echo !$first ? 'not-first' : null; ?>">
			                        <input type="checkbox" name="gateways[<?php echo $gateway['gateway'];?>]" id="gateways-<?php echo $gateway['gateway'];?>" <?php echo $checked[$gateway['gateway']] ? 'checked="checked"' : '';?> value="1" />
			                        <label for="gateways-<?php echo $gateway['gateway'];?>"><?php echo $gateway['title'];?></label>
			                    </div>
			                    <?php $first = false; endforeach; ?>
							<?php else: ?>
								<p><?php echo __('invoices:no_payment_gateways_enabled', array(site_url('admin/settings'))) ?></p>
							<?php endif; ?>
		        </div>
                                                    </div>
                                                
                                                <?php assignments((set_radio('type', 'ESTIMATE') OR isset($estimate)) ? 'estimates' : 'invoices'); ?>

						<div class="row">
							<label for="nothing">&nbsp;</label>
							<a href="#" class="blue-btn" onclick="$('#create-invoice').submit(); return false;"><span><?php echo __('global:save') ?> &rarr;</span></a>
						</div><!-- /row -->
					</fieldset>
		    
					<input type="submit" class="hidden-submit" />
			  </div><!-- /form-holder end -->
	</div><!-- /nine columns content-wrapper -->
	<?php echo form_close(); ?>

</div>


<br style="clear: both;" />

<script type="text/javascript">
	$('select#currency').change(function(){
		$('span#symbol, .currencySymbol').html(this.value != 0 ? this.value : '<?php echo Currency::symbol(); ?>');
	}).change();
</script>

<?php
//	asset::js('jhtmlarea-0.7.0.min.js', array(), 'invoice');
asset::js('invoice-form.js', array(), 'invoice');
//	asset::css('form.css', array(), 'invoice');
//	asset::css('jHtmlArea.css', array(), 'invoice');
echo asset::render('invoice');
?>