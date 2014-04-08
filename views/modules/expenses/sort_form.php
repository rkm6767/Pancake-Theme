<div class="modal-form-holder">

<div id="form_container">

<div id="modal-header">
	 <div class="row">
	   <h3 class="ttl ttl3"><?php echo __('expenses:filter'); ?></h3>
	 </div>
</div>

		<div class="form-holder">

			<?php echo form_open('admin/expenses/sort/', array('id' => 'add_time', 'method' => 'get')); ?>

					
					<div class="row">
					
						<div class="two columns mobile-three">
								<h4>Choose Suppliers</h4>
									<?php foreach($suppliers as $supplier): ?>
										
										<?php echo form_checkbox('suppliers[]', $supplier->id, TRUE); ?> <?php echo $supplier->name ?> <br />
									<?php endforeach ?>
						</div>

						<div class="four columns mobile-three">
								<h4>Choose Categories</h4>
								<?php foreach ($categories as $category): ?>
									<?php foreach($category->categories as $subcat): ?>
										<?php echo form_checkbox('categories[]', $subcat->id, TRUE); ?> <?php echo $subcat->name ?> <br />
									<?php endforeach ?>
								<?php endforeach ?>
							</span>
						</div>

						<?php /* Task Select */ ?>
						<div class="two columns mobile-three">
							<span class="sel-item">
								<select name="project_id">
										<option value="">Choose Project</option>
									<?php foreach($projects as $project): ?>
										<option value="<?php echo $project->id ?>"><?php echo $project->name ?></option>
									<?php endforeach ?>
								</select>          
							</span>                     
						</div>
						
					</div><!-- /row -->
					
					  <div class="row no-bottom">
					    <div class="six columns">
						    <label for="start_time"><?php echo __('expenses:start_date'); ?></label>
						    <?php echo form_input('start_time','', 'id="start_time" class="txt six columns datePicker"'); ?>
					    </div>

					    <div class="six columns">
					    <label for="end_time"><?php echo __('expenses:end_date'); ?></label>
					    <?php echo form_input('end_time','', 'id="end_time" class="txt six columns datePicker"'); ?>
					    </div><!-- /12 -->
						</div><!-- /row -->
					

					
					<div class="row">
						<a href="#" class="blue-btn" onclick="$('#add_time').submit(); return false;"><span>Sort</span></a>
					</div>
					

         <input type="submit" class="hidden-submit" />
		</div><!-- /form-holder -->
		
		<?php echo form_close(); ?>
			
  </div><!-- /form-container-->
<a class="close-reveal-modal">&#215;</a>
</div><!-- /modal-form-holder -->

<?php echo asset::js('jquery.ajaxform.js'); ?>
<script type="text/javascript">



	
	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>