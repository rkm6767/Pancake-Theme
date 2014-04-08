<div id="modal-form-holder" class="add_hours_container">
		<div id="modal-header">
			<div class="row">
					<h3 class="ttl ttl3"><?php echo lang('items:'.$action_type); ?></h3>
			</div>
		</div>

	 <div class="form-holder row">
  	 <?php echo form_open('admin/items/'.$action, 'id="item-mod"'); ?>
		   <fieldset class="add_item">
					<div class="row">
						<!-- Add item: Name -->
					  <div class="twelve columns add-bottom">
					    <label for="name" class="use-label"><?php echo lang('items:name') ?>:</label>
						  <?php echo form_input('name', set_value('name'), 'id="name" class="txt"'); ?>
					  </div><!-- /six name -->
					</div><!-- /row -->
					
					<div class="row">
						<!-- Add item: Quantity -->
					  <div class="six columns add-bottom">
						  <label for="qty" class="use-label"><?php echo lang('items:qty_hrs') ?></label>
						  <?php echo form_input('qty', set_value('qty', 1), 'id="qty" class="txt numeric"'); ?>
					  </div><!-- /six qty -->
			   		
			   		<!-- Add item: Rate -->
			   		<div class="six columns add-bottom">
							<label for="rate" class="use-label"><?php echo lang('items:rate') ?></label>
							<?php echo form_input('rate', set_value('rate', '0.00'), 'id="rate" class="txt numeric"'); ?>
						</div><!-- /six rate -->
					</div><!-- /row -->
		
					<div class="row">
						<!-- Add item: Description -->
						<div class="twelve columns add-bottom">
							<label for="description" class="use-label"><?php echo lang('global:description') ?>:</label>
							<?php echo form_textarea(array(
								'name' => 'description',
								'id' => 'description',
								'value' => set_value('description'),
								'rows' => 2,
								'cols' => 30
							)); ?>
						</div><!-- /twelve -->
					</div><!-- /row-->
		
					<div class="row">
						<!-- Add item: Tax Rate -->
						<div class="six columns add-bottom">
							<label for="tax_id"><?php echo lang('items:tax_rate') ?>:</label>
							<span class="sel-item"><?php echo form_dropdown('tax_id', Settings::tax_dropdown(), set_value('tax_id'), 'class="tax_id"'); ?></span>
						</div><!-- /six tax -->
		
						<div class="six columns add-bottom">
							<!-- Add item: Type -->
							<label for="type"><?php echo lang('items:type') ?>:</label>
							<span class="sel-item"><?php echo form_dropdown('type', Item_m::type_dropdown(), set_value('type'), 'class="type"'); ?></span>
						</div><!-- /six type -->
					</div><!-- /row -->
					
					<br class="clear" />
		
					<p><a href="#" class="blue-btn" onclick="$('#item-mod').submit(); return false;"><span><?php echo lang('items:'.$action_type); ?></span></a></p>
		  
		  </fieldset>
	    
	    <input type="submit" class="hidden-submit" />
    <?php echo form_close(); ?>
  </div><!-- /form-holder -->
</div><!-- /modal-window -->