<div class="modal-form-holder">
  
  <div id="modal-header">
	 <div class="row">
	   <h3 class="ttl ttl3"><?php echo __('items:add_expense_to_project') ?></h3>
   </div>
  </div>
  
  <div id="form_container">
	
	
		<div class="form-holder">
          <?php echo form_open('admin/expenses/create', 'id="expense-mod"'); ?>

		
		<input type="hidden" name="project_id" value="<?php echo $project->id ?>" id="project_id">


                   <div class="row">
	
	                    <div class="two columns">
                           <label for="name">Expense Name</label>
                      </div>

                      <div class="nine columns end">			  
                          <?php echo form_input('name', set_value('name'), 'id="name" class="txt"'); ?>
                      </div>

                   </div>

                  <div class="row">
  
                      <div class="two columns">
                           <label for="rate">Amount</label>
                      </div>

                      <div class="nine columns end">            
                          <?php echo form_input('rate', set_value('rate'), 'id="rate" class="txt"'); ?>
                      </div>

                   </div>

                   <div class="row">
  
                      <div class="two columns">
                           <label for="rate">Supplier</label>
                      </div>

                      <div class="nine columns end">            
                          <select name="supplier_id">
                              <option value="">Choose Supplier</option>
                          <?php foreach($suppliers as $supplier): ?>
                              <option value="<?php echo $supplier->id ?>" <?php echo set_select('supplier_id', $supplier->id, '') ?>><?php echo $supplier->name ?></option>
                          <?php endforeach ?>
                          </select>
                      </div>

                   </div>

                   <div class="row">
  
                      <div class="two columns">
                           <label for="rate">Category</label>
                      </div>

                      <div class="nine columns end">            
                          <select name="category_id">
                          <?php foreach ($categories as $category): ?>
                              <optgroup label="<?php echo $category->name ?>">
                              <?php foreach($category->categories as $subcat): ?>
                                  <option value="<?php echo $subcat->id ?>" <?php echo set_select('category_id', $subcat->id, '') ?>><?php echo $subcat->name ?></option>
                              <?php endforeach ?>
                              </optgroup>
                          <?php endforeach ?>
                          </select>
                      </div>

                   </div>

                   <div class="row">
  
                      <div class="two columns">
                           <label for="rate">Project</label>
                      </div>

                      <div class="nine columns end">            
                         	<input type="text" name="" value="<?php echo $project->name ?>" id="" disabled>
                          </select>
                      </div>

                   </div>

                   <div class="row">
  
                      <div class="two columns">
                           <label for="due_date2">Due Date</label>
                      </div>

                      <div class="nine columns end">            
                         <?php echo form_input('due_date', set_value('due_date'), 'id="due_date2" class="datePicker txt"'); ?>
                      </div>

                   </div>

                  <div class="row">	
                      <div class="two columns">
                          <label for="description"><?php echo __('global:description') ?></label>
                      </div>

                      <div class="nine end columns">								
                          <?php
                          echo form_textarea(array(
                              'name' => 'description',
                              'id' => 'description',
                              'value' => set_value('description'),
                              'rows' => 50,
                              'cols' => 30
                          ));
                          ?>
                      </div>
                  </div>

					
					

                   

                  <div class="row">
							<div class="eight columns">

							</div><!-- /eight columns -->
							<div class="four columns">
								<p><a href="#" class="blue-btn" onclick="$('#expense-mod').submit();"><span><?php echo __('expenses:edit_expense'); ?>&rarr;</span></a></p>
							</div><!-- /four columns -->
                          
                  </div>



          <input type="submit" class="hidden-submit" />

			<?php echo form_close(); ?>
      </div><!-- /form holder-->



<?php 

/*
	
	
		<div class="form-holder">
  		<?php echo form_open('admin/projects/add_expense/' . $project->id, 'id="item-mod"'); ?>

			<div class="row">
				<label for="name"><?php echo lang('items:name') ?>:</label>
				<?php echo form_input('name', set_value('name'), 'id="name" class="txt"'); ?>
			</div><!-- /6 -->
  			  
			<div class="row no-bottom">
			  <div class="row no-bottom">
  				<div class="four columns">
    				<label for="qty"><?php echo lang('items:qty_hrs') ?></label>
    				<?php echo form_input('qty', set_value('qty', 1), 'id="qty" class="txt numeric"'); ?>
  				</div><!-- /4 -->
  				
  				<div class="four columns">
    				<label for="rate"><?php echo lang('items:rate') ?></label>
    				<?php echo form_input('rate', set_value('rate', '0.00'), 'id="rate" class="txt numeric"'); ?>
  				</div><!-- /4 -->
  				
	  			<div class="four columns">
					<label for="tax_id"><?php echo lang('items:tax_rate') ?>:</label>
					<span class="sel-item">
						<?php echo form_dropdown('tax_id', Settings::tax_dropdown(), set_value('tax_id'), 'class="tax_id"'); ?>
					</span>
	
					<?php if (!$type): ?>
						<label for="type"><?php echo lang('items:type') ?>:</label>
						<span class="sel-item">
							<?php echo form_dropdown('type', Item_m::type_dropdown(), set_value('type'), 'class="type"'); ?>
						</span>
					<?php else: ?>
						<input type="hidden" name="type" value="expense" />
					<?php endif; ?>
				</div>
			  </div>
			</div><!-- /row -->

			<div class="row">
				<label for="description"><?php echo lang('global:description') ?>:</label>
				<?php echo form_textarea(array(
					'name' => 'description',
					'id' => 'description',
					'value' => set_value('description'),
					'rows' => 2,
					'cols' => 30,
					'class' => 'add-bottom'
				)); ?>
			</div>

			<p><a href="#" class="blue-btn" onclick="$('#item-mod').submit(); return false;"><span><?php echo lang('global:save'); ?></span></a></p>
	    <input type="submit" class="hidden-submit" />

		</div>
    <?php echo form_close(); ?>
  </div>
</div><!-- /row -->!!!!!!

*/
?>






<a class="close-reveal-modal">&#215;</a>
</div><!-- /modal-form-holder -->

<?php asset::js('invoice-form.js', array(), 'invoice'); ?>

<script>
	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>