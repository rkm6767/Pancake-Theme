<?php 
/*
 * View Time Sheet Entries Page
 * Version 2 (Created: 06th January 2013)
 */
?>

<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo __('expenses:expenses') ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>



<?php /* Add Time */ ?>	
<div id="add-time-form" class="row form-holder">
	<h4 class="twelve columns add-bottom"><?php echo __('expenses:add_supplier') ?></h4>
	
	<?php echo form_open('admin/expenses/suppliers/', array('name'=>'add_supplier', 'id'=>'add_supplier')); ?>
	
		<?php /* Time */ ?>
		
		<div class="four columns mobile-three">
	      <input type="text" name="name" class="txt" placeholder="Supplier Name" />
		</div>
		
		<div class="eight columns mobile-three">
	      <input type="text" name="description" class="txt" placeholder="Description" />
		</div>
		
		
	
			<div class="twelve columns mobile-four">
					<?php echo form_textarea('notes', set_value('notes'), 'rows="4" placeholder="Notes" class="txt add-time-note"'); ?>
			</div>
			
			<?php /* Submit */ ?>
			<div class="two columns" style="margin-top: 2px;">
					
					<a href="#" class="blue-btn" onclick="$('#add_supplier').submit(); return false;"><span><?php echo __('expenses:add_supplier') ?></span></a>
					<input type="submit" class="hidden-submit" />
			</div>
		
	<?php echo form_close(); ?>
</div><!-- /row -->



<?php /* Start Filters */ ?>




<?php /* Start Time Sheet */ ?>
<div class="row">
<div class="height_transition twelve columns">
    <div class="view_entries_table">

	
        <table id="view-entries" class="listtable pc-table table-activity" style="width: 100%;">
            <thead>
            	<tr>
            		<td colspan="5">
            			<button type="button" class="blue-btn toggle-deleted" data-toggle="button">Show / Hide Deleted</button>
            		</td>
            	</tr>
            	<tr>
					<th class="cell1"></th>
	            	<th class="cell4"><?php echo __('expenses:supplier') ?></th>
					<th class="cell4"><?php echo __('global:description') ?></th>
	            	<th class="cell5"><?php echo __('global:notes') ?></th>	
            	</tr>
            </thead>

            <tbody>
                <?php foreach ($suppliers as $entry): ?>

                    <tr data-id="<?php echo $entry->id ?>" class="<?php echo $entry->deleted ? 'deleted hide' : '' ?>">
	
                    	<td class="cell1 pic">
                    		
						<?php echo anchor('/admin/expenses/edit_supplier/'. $entry->id, 'Edit Supplier',  array('class' => 'edit-entry timesheet-icon edit fire-ajax')) ?>
							
                    	</td>

						<td class="cell4">
							<?php if($entry->name): ?>
								<?php echo $entry->name ?>
								<?php if($entry->deleted): ?>
									<small>(deleted)</small>
								<?php endif; ?>
							<?php endif ?>
						</td>

						<td class="cell4 time_note">
							<?php if($entry->description): ?>
								<small><?php echo auto_typography($entry->description) ?></small>
							<?php endif ?>
						</td>
						
						<td class="cell5">
							<?php if($entry->notes): ?>
								<?php echo $entry->notes ?>
							<?php endif ?>
						</td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    


		</div>
</div>
