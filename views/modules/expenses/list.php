<!-- Add and List Expenses -->

<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo __('expenses:expenses') ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<!-- Add Expense form -->
<div id="add-time-form" class="row form-holder">
	<h4 class="twelve columns add-bottom"><?php echo __('expenses:add') ?></h4>

	<br class="clear" />

        <?php if (is_admin()): ?>
	<div class="twelve columns">
		<div class="help add-bottom">
			<p style="margin: 10px 0;">Before you can add any expenses you need to go and create some <a href="<?php echo site_url('admin/expenses/suppliers'); ?>">suppliers</a> and <a href="<?php echo site_url('admin/expenses/categories');?>">categories</a>.</p>		
                </div>
	</div>
        <?php endif; ?>

	<?php echo form_open('admin/expenses/create/', array('name'=>'add_expense', 'id'=>'add_expense')); ?>

		<div class="two columns mobile-three">
	      <input type="text" name="name" class="txt" placeholder="Expense Name" />
		</div>

		<div class="two columns mobile-three">
	      <input type="text" name="rate" class="txt" placeholder="How Much?" />
		</div>

		<div class="two columns mobile-three">
			<span class="sel-item">
				<select name="category_id">
					<option value="">Choose Category</option>
					<?php foreach ($categories as $category): ?>

					<?php if ( ! empty($category->categories)): ?>
					<optgroup label="<?php echo $category->name ?>">
					<?php foreach($category->categories as $subcat): ?>
						<option value="<?php echo $subcat->id ?>"><?php echo $subcat->name ?></option>
					<?php endforeach ?>
					</optgroup>
					<?php else: ?>
					<option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
					<?php endif; ?>

					<?php endforeach ?>
				</select>
			</span>
		</div>

		<div class="two columns mobile-three">
			<span class="sel-item">
				<select name="supplier_id">
					<option value="">Choose Supplier</option>
					<?php foreach($suppliers as $supplier): ?>
						<option value="<?php echo $supplier->id ?>"><?php echo $supplier->name ?></option>
					<?php endforeach ?>
				</select>
			</span>
		</div>

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

		<div class="two columns mobile-three">
			<div class="sort-time">
				<a id="date-other" href="#" class="date-btn" style="float: left">Due Date</a>
			</div>
			<div class="float: right;"><?php echo form_input('date', ($date = set_value('due_date', isset($time) ? $time->date : time())) ? format_date($date) : '', 'id="date" class="datePicker nine columns hide"'); ?></div>
		</div>

		<div class="twelve columns mobile-four" style="margin-top: -0px;">
			<?php echo form_textarea('description', set_value('description'), 'rows="4" placeholder="Description" class="txt add-time-note"'); ?>
		</div>
        
                <div class="twelve columns mobile-four" style="margin-top: -0px;">
                    <?php assignments('project_expenses'); ?>
                </div>

		<div class="two columns mobile-four" style="margin-top: 20px;margin-bottom: 10px;">
			<a href="#" class="blue-btn" onclick="$('#add_expense').submit(); return false;"><span>Save Expense</span></a>
			<input type="submit" class="hidden-submit" />
		</div>

	<?php echo form_close(); ?>
</div><!-- /row -->



<!-- Filters -->
<div id="sort-entries-fields" class="row">

	<h3 class="twelve columns"><?php echo __('timesheet:entries') ?></h3>

			<div class="twelve columns">
				<p class="sort-time">
					<?php echo anchor('/admin/expenses/sort_form/', 'Sort Entries',  array('class' => ' fire-ajax')) ?>
				</p>

          </div><!-- /12 -->
</div><!-- /sort-entries-fiels -->



<!-- Expense List -->
<div class="row">
	<div class="height_transition twelve columns">
	    <div class="view_entries_table">

	        <table id="view-entries" class="listtable pc-table table-activity" style="width: 100%;">
	            <thead>
					<th class="cell1"></th>
					<th class="cell3"><?php echo __('global:name') ?></th>
	            	<th class="cell2"><?php echo __('expenses:amount') ?></th>
					<th class="cell2"><?php echo __('expenses:category') ?></th>
	            	<th class="cell2"><?php echo __('expenses:supplier') ?></th>
	            	<th class="cell3"><?php echo __('projects:due_date') ?></th>
	            	<th class="cell5"><?php echo __('global:notes') ?></th>
	            </thead>

	            <tbody>
	                <?php foreach ($expenses as $entry): ?>
                    <tr data-id="<?php echo $entry->id ?>">

                        <td data-title="<?php echo __("global:actions"); ?>" class="cell1 pic">
                    		<?php echo anchor('admin/expenses/edit/'.$entry->id, 'Edit', array('class' => 'fire-ajax edit-entry timesheet-icon edit')) ?>
                        	<?php echo anchor('admin/expenses/delete/'.$entry->id, 'Delete', array('class' => 'delete-entry timesheet-icon delete confirm-delete')) ?>
                    	</td>

                    	<td data-title="<?php echo __('global:name') ?>" class="cell3">
	                    	<span class="time-sheet-name"><?php echo $entry->name; ?></span>
						</td>

                        <td data-title="<?php echo __('expenses:amount') ?>" class="cell2">
                        	<?php if ($entry->rate) echo Currency::format($entry->rate); ?>
                        </td>

						<td data-title="<?php echo __('expenses:category') ?>" class="cell2">
							<?php if ($entry->category_id) echo $entry->category_name; ?>
						</td>

						<td data-title="<?php echo __('expenses:supplier') ?>" class="cell2">
							<?php if ($entry->supplier_id) echo $entry->supplier_name; ?>
						</td>

                        <td data-title="<?php echo __('projects:due_date') ?>" class="cell">
                        	<?php if ($entry->due_date) echo format_date($entry->due_date); ?>
                        </td>

						<td data-title="<?php echo __('global:notes') ?>" class="cell5 time_note">
							<small><?php if ($entry->description) echo auto_typography($entry->description); ?></small>
						</td>

                    </tr>
	                <?php endforeach; ?>
					<tr>
						<td class="hide-for-small" colspan="2" style="text-align:right">
							Total:
						</td>
                                                <td data-title="<?php echo __('invoices:total'); ?>" colspan="5">
							<?php echo Currency::format($total); ?>
	                    </td>
	                </tr>
	            </tbody>
	        </table>
	    </div>

	</div>
</div><!-- /row -->



<script>

    function start_edit_time(id) {
        $('.view_entries_table').fadeOut(function() {
            $('.edit-entry-'+id).show();
        });
    }

    function submit_edit_time(id) {

        var visible = $('.edit-entry-'+id);

        if (visible.find('.undefined').length > 0) {
            visible.find('.undefined').siblings('input').focus();
            return false;
        } else {
            var startTime = visible.find('.start_time_input').val();
            if(!isNaN(startTime)) startTime += ':00';
            startTime = Date.parse(startTime).toString('HH:mm');

            var endTime = visible.find('.end_time_input').val();
            if(!isNaN(endTime)) endTime += ':00';
            endTime = (Date.parse(endTime).toString('HH:mm'));
        }

        var date = $('[name=date-'+id+']').val();
        var note = visible.find('[name=note]').val();
        var task_id = visible.find('[name=task_id]').val();
        $.post('<?php echo site_url('admin/projects/times/ajax_set_entry') ?>', {
                'id' : id,
                'start_time' : startTime,
                'end_time' : endTime,
                'date' : date,
                'note': note,
                'task_id': task_id
            });

        close_reveal();
    }

    jQuery(function($) {

        $('.start_time_input, .end_time_input').each(function () {

	    var val = $(this).val();
	    if (!isNaN(val))
		// add minutes to numeric value otherwise it will be interpreted as a date
		val = val + ':00';
	    var dt = Date.parse(val);
	    if (dt !== null) {
		$(this).siblings('.time').removeClass('undefined');
	    } else {
		$(this).siblings('.time').addClass('undefined');
	    }
	    dt = (dt !== null) ? dt.toString('hh:mm tt') : 'not a valid time';
	    $(this).siblings('.time').html(dt);
	});

	$('.start_time_input, .end_time_input').keyup(function (e) {
	    var val = $(this).val();
	    if (!isNaN(val))
		// add minutes to numeric value otherwise it will be interpreted as a date
		val = val + ':00';
	    var dt = Date.parse(val);
	    if (dt !== null) {
		$(this).siblings('.time').removeClass('undefined');
	    } else {
		$(this).siblings('.time').addClass('undefined');
	    }
	    dt = (dt !== null) ? dt.toString('hh:mm tt') : 'not a valid time';
	    $(this).siblings('.time').html(dt);
	});

        $('.start_time span, .end_time span, .date span').live('click', function() {
            $(this).hide().siblings('input').show();
        });

        $('.start_time input, .end_time input, .date input').live('blur change', function(e) {

            var input = this;
            var row = $(this).closest('tr');

            $.post('<?php echo site_url('admin/projects/times/ajax_set_entry') ?>', {
                'id' : row.data('id'),
                'start_time' : $('.start_time input', row).val(),
                'end_time' : $('.end_time input', row).val(),
                'date' : $('.date input', row).datepicker( "getDate" ).getTime()
            }, function(data) {

                $(input).hide().siblings('span').text(input.value).show();

                $('.duration', row).text(data.new_duration);

            }, 'json');

        });

        $('.delete-entry').click(function() {
			if(!confirm('Are you sure?')) return false;

            var row = $(this).closest('tr');
            var id = row.data('id');

            $.post(baseURL +'admin/expenses/ajax_delete_entry', {
                'id' : row.data('id'),
            }, function() {
                row.slideUp('slow');
            });

            return false;
        });
    })

	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });

    // show/hide date on click of "other"
	  /*$('#date-other').click(function() {
		    if ($('#date').hasClass('hide')) {
	    			$('#date').removeClass('hide');
	    			return false;
	    	} else {
		    		$('#date').addClass('hide');
		    		return false;
	    	}
	    }
	  );*/

	var currentDateBtn = $('.date-btn.current').attr('id');

    $('.date-btn').click(function(e){
    	e.preventDefault();

    	var id = $(this).attr('id');
    	if(currentDateBtn != id){
    		$('#'+currentDateBtn).removeClass('current');
    		$(this).addClass('current');
    		currentDateBtn = id;
    	}

    	setDateValue();
    });

    function setDateValue(){
    	var date = $('#date');
    	var day = $('#date-day');

    	switch(currentDateBtn){
    		case 'date-today':
    			date.addClass('hide');
    			//day.val('today');
    			break;
    		case 'date-yesterday':
    			date.addClass('hide');
    			//day.val('yesterday');
    			break;
    		case 'date-other':
    			date.removeClass('hide');
    			//day.val('other');
    			break;
    	}
    }

    setDateValue();

</script>