<div class="modal-form-holder">
  
<div id="form_container">
<div id="modal-header">
    <div class="row">
        <h3 class="ttl ttl3"><?php echo __('expenses:edit_supplier'); ?></h3>
    </div>
</div>

        <div class="form-holder">
            <?php echo form_open('admin/expenses/edit_supplier/' . $action, 'id="supplier-mod"'); ?>


                     <div class="row">
	
	                    <div class="two columns">
                             <label for="title"><?php echo __('global:name') ?></label>
                        </div>

                        <div class="nine columns end">			  
                            <?php echo form_input('name', set_value('name'), 'id="name" class="txt"'); ?>
                        </div>

                     </div>

                    <div class="row">	
                        <div class="two columns">
                            <label for="subject"><?php echo __('global:description') ?></label>
                        </div>

                        <div class="nine columns end">			  
                            <?php echo form_input('description', set_value('description'), 'id="description" class="txt"'); ?>
                        </div>	
                    </div>

                    <div class="row">	
                        <div class="two columns">
                            <label for="address"><?php echo __('global:notes') ?></label>
                        </div>

                        <div class="nine end columns">								
                            <?php
                            echo form_textarea(array(
                                'name' => 'notes',
                                'id' => 'notes2',
                                'value' => set_value('notes'),
                                'rows' => 50,
                                'cols' => 30
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="row">	
                        <div class="two columns">
                            <label for="address"><?php echo __('global:deleted') ?></label>
                        </div>

                        <div class="nine end columns">								
                            <?php
                            echo form_checkbox(array(
                                'name' => 'deleted',
                                'id' => 'deleted',
                                'value' => 1,
								'checked' => set_value('deleted', $supplier->deleted)

                            ));
                            ?>


                        </div>
                    </div>
					

                     

                    <div class="row">
							<div class="eight columns">

							</div><!-- /eight columns -->
							<div class="four columns">
								<p><a href="#" class="blue-btn" onclick="$('#supplier-mod').submit();"><span><?php echo __('expenses:edit_supplier'); ?>&rarr;</span></a></p>
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