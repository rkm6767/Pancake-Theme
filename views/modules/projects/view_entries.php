<?php
/*
 * View Time Sheet Entries Page
 * Version 2 (Created: 06th January 2013)
 */
?>

<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo __('tasks:entries') ?></h2>
	   <?php echo $template['partials']['search']; ?>
	 </div>
</div>



<?php /* Add Time */ ?>
<div id="add-time-form" class="row form-holder">
	<h4 class="twelve columns add-bottom">Add Hours To <?php echo anchor('admin/projects/view/'.$project->id, $project->name); ?></h4>

	<?php echo form_open('admin/projects/times/add_hours/' . $project_id, array('id' => 'add_time')); ?>

		<?php /* Time */ ?>
		<div class="one columns mobile-two">
	      <input type="text" name="hours" class="txt" placeholder="Hours" />
		</div>

		<?php /* Date */ ?>
		<div class="three columns mobile-two">
				<div class="row">
						<label class="three columns" for="date"><?php echo lang('times.label.date'); ?></label>
						<div class="nine columns sort-time">
							<a id="date-today" href="#" class="date-btn current">Today</a>
							<a id="date-yesterday" href="#" class="date-btn">Yesterday</a>
							<a id="date-other" href="#" class="date-btn">Other</a>
							<input type="hidden" name="day" value="today" id="date-day" />
						</div>
						<?php
						echo form_input('date', ($date = set_value('date', isset($time) ? $time->date : time())) ? format_date($date) : '', 'id="date" class="datePicker nine columns hide"'); ?>
				</div><!-- /row -->
		</div><!-- /3 -->

		<div class="three columns mobile-two">
		<div class=" row">
	      	<label class=" five columns">Start Time</label>
			<div class="seven columns">
				<input type="text" name="start_time" class="txt timePicker" placeholder="now" />
			</div><!-- /nine columns -->
	    </div>
		</div><!-- /3 -->








		<?php /* Task Select */ ?>
		<div class="three columns mobile-four">
				<div class="row">
						<label class="three columns" for="task_id"><?php echo lang('times.label.task_id'); ?></label>
						<div class="nine columns end">
								<?php $this->load->view('projects/task_select', array(
										'project_id' => $project_id,
										'task_id' => isset($time) ? $time->task_id : (isset($task_id) ? $task_id : 0),
								)); ?>
						</div><!-- /5 -->
				</div><!-- /row -->
		</div><!-- /3 -->

		<?php /* Notes */ ?>



		<?php /* Submit */ ?>
		<div class="two columns" style="margin-top: 2px;">
				<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
				<a href="#" class="blue-btn" onclick="$('#add_time').submit(); return false;"><span><?php echo lang('times.create.title'); ?></span></a>
				<input type="submit" class="hidden-submit" />
		</div>




			<div class="twelve columns mobile-four">
					<?php echo form_textarea('note', set_value('note'), 'rows="4" placeholder="notes" class="txt add-time-note"'); ?>
			</div>

	<?php echo form_close(); ?>
</div><!-- /row -->


<?php if (count($entries)): ?>
<?php /* Start Filters */ ?>
<div id="sort-entries-fields" class="row">

				<h3><?php echo __('timesheet:entries') ?></h3>
                                <a href='<?php echo site_url('timesheet/'.$project->unique_id);?>' class='blue-btn'>View timesheet (for clients)</a>
                                <br /><br />

						<div class="twelve columns">
							<!-- <p class="sort-time">
								<strong>Sort by:</strong>
								<a class="sort-box" href="#">Date</a>
								<a class="sort-box" href="#">User</a>
								&nbsp;
								<strong>in order of:</strong>
								<a class="sort-box" href="#">Ascending</a>
								<a class="sort-box" href="#">Decending</a>
							</p> -->

		              </div><!-- /12 -->
</div><!-- /sort-entries-fiels -->



<?php /* Start Time Sheet */ ?>
<div class="row">
<div class="height_transition">
    <div class="view_entries_table">
        <table id="view-entries" class="listtable pc-table table-activity" style="width: 100%;">
            <?php 
                $total_duration = array();
                foreach ($entries as $entry) {
                    if (!isset($total_duration[$entry->task_id])) {
                        $total_duration[$entry->task_id] = 0;
                    }
                    $total_duration[$entry->task_id] += $entry->minutes * 60;
                }
                
                reset($total_duration);
                $first_task = key($total_duration);
                $total_tasks = count($total_duration);
                
                ?>
            <thead>
				<th class="cell1"></th>
            	<th class="cell2"><?php echo __('timesheet:user') ?></th>
                <?php if ($total_tasks > 1): ?>
                <th class="cell2"><?php echo __('global:task') ?></th>
            	<?php endif;?>
                <th class="cell3"><?php echo __('timesheet:date') ?></th>
            	<th class="cell4"><?php echo __('timesheet:duration') ?></th>
            	<th class="cell5"><?php echo __('global:notes') ?></th>
                <th class="cell5"><?php echo __('global:invoice') ?></th>
            </thead>
            <tfoot>
                <tr>
                    <td colspan='2' rowspan='<?php echo $total_tasks?>' class='align-right'>Total logged time</td>
                    <?php if ($total_tasks > 1): ?><td class='align-right'><?php echo isset($tasks_select[$first_task]) ? $tasks_select[$first_task] : __('tasks:no_task'); ?></td><?php endif;?>
                    <td colspan='<?php echo ($total_tasks > 1) ? 5 : 4 ?>'><?php echo format_seconds($total_duration[$first_task])?></td>
                </tr>
                <?php unset($total_duration[$first_task]); ?>
                <?php foreach($total_duration as $task_id => $total): ?>
                <tr>
                    <td class='align-right'><?php echo isset($tasks_select[$task_id]) ? $tasks_select[$task_id] : __('tasks:no_task'); ?></td>
                    <td colspan='<?php echo ($total_tasks > 1) ? 5 : 4 ?>'><?php echo format_seconds($total)?></td>
                </tr>
                <?php endforeach; ?>
            </tfoot>
            <tbody>
                <?php foreach ($entries as $entry): ?>

                    <tr data-id="<?php echo $entry->id ?>">

                    	<td class="cell1 pic">

												 <a href="#" class="edit-entry timesheet-icon edit" onclick="start_edit_time(<?php echo $entry->id; ?>); return false;" title="Edit">Edit</a>
                         <a href="#" class="delete-entry timesheet-icon delete" title="Delete">Delete</a>

                    	</td>

                    	<td class="cell2 user">
	                    	<img src="<?php echo get_gravatar($entry->email, '40'); ?>" class="members-pic" /> <span class="time-sheet-name"><?php echo $entry->first_name . " " . $entry->last_name; ?></td>

                                <?php if ($total_tasks > 1): ?><td><?php echo isset($tasks_select[$entry->task_id]) ? $tasks_select[$entry->task_id] : __('tasks:no_task'); ?></td><?php endif;?>
                                
                        <td class="cell3 date">
                            <span><?php echo format_date($entry->date); ?></span>
                            <?php echo form_input('date', format_date($entry->date), 'id="date-' . $entry->id . '" class="datePicker txt" style="display:none;"') ?>
                        </td>

                        <td class="cell4 duration"><?php echo format_seconds($entry->minutes * 60); ?>
	                        <small>(
	                         <span class="start_time">
	                         	<strong>From:</strong>
                                        <span><?php echo format_time(strtotime($entry->start_time)); ?></span>
	                        	 <?php echo form_input('start_time', $entry->start_time, 'style="display:none;"') ?>
	                         </span>

	                         <span class="end_time">
	                         	<strong>To:</strong>
	                        	 <span><?php echo format_time(strtotime($entry->end_time)); ?></span>
	                        	 <?php echo form_input('end_time', $entry->end_time, 'style="display:none;"') ?>
	                         </span>)
	                        </small>
                        </td>
												<td class="cell5 time_note">
													<?php if($entry->note): ?>
														<small><?php echo auto_typography($entry->note) ?></small>
													<?php endif ?>
												</td>
                                                                                                
                                                                                                <td class="cell6 time_invoice">
													<?php if ($entry->invoice_item_id > 0): ?>
                                                                                                            <small><?php echo build_invoice_item_id_link($entry->invoice_item_id); ?></small>
                                                                                                        <?php else: ?>
                                                                                                            <small>Not billed yet.</small>
                                                                                                        <?php endif ?>
												</td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="form_container" class="form-holder">
        <?php foreach ($entries as $time): ?>
            <div style="display:none;" class="row edit-entry edit-entry-<?php echo $time->id; ?>">
	            	<!-- Pancake Team: Update this here -->
	            	<h5 class="twelve columns">Editing time entry:</h5>

                <?php echo form_open('admin/projects/times/edit/' . $time->id, array('class' => 'edit_time', 'id'=>'edit_time_'.$time->id )); ?>

                <!-- Start time -->
                <div class="three columns mobile-two">
                		<div class="row">
                				<label class="four columns" for="start_time"><?php echo lang('times.label.start_time'); ?></label>
                				<?php echo form_input('start_time', set_value('start_time', isset($time) ? $time->start_time : ''), 'id="start_time" class="txt five columns"'); ?>
                				 <div class="three columns time"></div>
                		</div>
                </div>

                <!-- End Time -->
                <div class="three columns mobile-two">
                		<div class="row">
                				<label class="four columns" for="end_time"><?php echo lang('times.label.end_time'); ?></label>
                				<?php echo form_input('end_time', set_value('end_time', isset($time) ? $time->end_time : date('H:i')), 'id="end_time" class="txt five columns"'); ?>
                				<div class="three columns time"></div>
                		</div><!-- /row -->
                </div><!-- /3 -->

                <!-- Date -->
                <div class="three columns mobile-two">
                		<div class="row">
                				<label class="four columns" for="date"><?php echo lang('times.label.date'); ?></label>
                				<?php echo form_input('date', ($date = set_value('date', isset($time) ? $time->date : time())) ? format_date($date) : '', 'id="date" class="datePicker five columns end"'); ?>
                		</div><!-- /row -->
                </div><!-- /3 -->

                <!-- Task Dropdown -->
                <div class="three columns mobile-two">
                		<div class="row">
                				<label class="three columns" for="task_id"><?php echo lang('times.label.task_id'); ?></label>
                				<div class="nine columns end">
                						<?php $this->load->view('projects/task_select', array(
                								'project_id' => $project_id,
                								'task_id' => isset($time) ? $time->task_id : 0,
                						)); ?>
                				</div><!-- /5 -->
                		</div><!-- /row -->
                </div><!-- /3 -->

                <!-- Notes -->
                <div class="twelve columns">
                		<label for="note"><?php echo lang('times.label.notes'); ?></label>
                		<?php echo form_textarea('note', set_value('note',$time->note), 'class="txt add-time-note add-bottom"'); ?>
                </div>

                <!-- Submit -->
                <div class="twelve columns">
                	<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
                		<a href="#" class="blue-btn" onclick="$('#edit_time_<?php echo $time->id; ?>').submit(); return false;"><span><?php echo __('tasks:edit_entry'); ?></span></a>
                		<input type="submit" class="hidden-submit" />
                </div>
           	</div><!-- /none -->
			</form>
        	<?php endforeach; ?>
    	  </div>
		</div>
</div>
<?php else: ?>
<div id="sort-entries-fields" class="row">
    <h3><?php echo __('timesheet:no_entries') ?></h3>
</div>
<?php endif;?>
































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

            var row = $(this).closest('tr');
            var id = row.data('id');

            $.post(baseURL +'admin/projects/times/ajax_delete_entry', {
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
    			day.val('today');
    			break;
    		case 'date-yesterday':
    			date.addClass('hide');
    			day.val('yesterday');
    			break;
    		case 'date-other':
    			date.removeClass('hide');
    			day.val('other');
    			break;
    	}
    }

    setDateValue();

</script>