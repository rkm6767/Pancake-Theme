<div class="modal-form-holder">

<div id="form_container">
<div id="modal-header">
    <div class="row">
        <h3 class="ttl ttl3"><?php echo __('expenses:edit_expense'); ?></h3>
    </div>
</div>


        <div class="form-holder">

            <?php echo form_open('admin/expenses/' . $action, 'id="expense-mod"'); ?>

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
                             <label for="rate">Category</label>
                        </div>

                        <div class="nine columns end">
                            <select name="category_id">
                                <option value="">Choose Category</option>
                                <?php foreach ($categories as $category): ?>
                                <?php if ( ! empty($category->categories)): ?>
                                <optgroup label="<?php echo $category->name; ?>">
                                    <?php foreach ($category->categories as $subcat): ?>
                                    <option value="<?php echo $subcat->id; ?>" <?php echo set_select('category_id', $subcat->id, ($subcat->id == $expense->category_id)); ?>><?php echo $subcat->name; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <?php else: ?>
                                <option value="<?php echo $category->id; ?>" <?php echo set_select('category_id', $category->id, ($category->id == $expense->category_id)); ?>><?php echo $category->name; ?></option>
                                <?php endif; endforeach; ?>
                            </select>
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
                                <option value="<?php echo $supplier->id ?>" <?php echo set_select('supplier_id', $supplier->id, $supplier->id == $expense->supplier_id) ?>><?php echo $supplier->name ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>

                     </div>

                     <div class="row">

                        <div class="two columns">
                             <label for="rate">Project</label>
                        </div>

                        <div class="nine columns end">
                            <select name="project_id">
                                <option value="">Choose Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?php echo $project->id ?>" <?php echo set_select('project_id', $project->id, $project->id == $expense->project_id) ?>><?php echo $project->name ?></option>
                            <?php endforeach ?>
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

                    <?php assignments('project_expenses', str_ireplace('edit/', '', $action)); ?>




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


</div> <!-- /form-container -->
<a class="close-reveal-modal">&#215;</a>
</div><!-- /modal-form-holder -->

<script type="text/javascript">

    // fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>