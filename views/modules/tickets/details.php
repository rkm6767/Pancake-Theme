<?php 
/*
 * View Time Sheet Entries Page
 * Version 2 (Created: 06th January 2013)
 */
?>

<div id="header">
	<div class="row">
	    <h2 class="ttl ttl3"><?php echo __('tickets:all_tickets') ?></h2>
		<?php echo $template['partials']['search']; ?>
	</div>
</div>

<div class="row">
	<form action="" class="form-holder eight columns">
		<div class="row">
			<div class="six columns">
			    <label for="client"><?php echo __('tickets:select_client'); ?></label>
			    <span class="sel-item">
					<select id="client" name="client">
						<option value="">Client Name</option>
					</select>
			    </span>
			</div>

			<div class="six columns">
			    <label for="user"><?php echo __('tickets:assign_to_user'); ?></label>
			    <span class="sel-item">
					<select id="user" name="user">
						<option value="">Lee</option>
					</select>
			    </span>
			</div>

			<div class="twelve columns">
				<label for="subject"><?php echo __('tickets:ticket_subject'); ?></label>
				<input type="text" id="subject" name="subject">
			</div>

			<div class="twelve columns">
				<label for="body"><?php echo __('tickets:ticket_message'); ?></label>
				<div class="textarea ticket">
					<?php
						echo form_textarea(array(
							'name' => 'body',
							'class' => 'ticket_comment',
							'id' => 'body',
							'value' => '',
							'rows' => 7,
							'cols' => 50
						));
					?>
				</div>
			</div>

			<div class="six columns">
			    <label for="priority"><?php echo __('tickets:ticket_priority'); ?></label>
			    <span class="sel-item">
					<select id="priority" name="priority">
						<option value="">High</option>
					</select>
			    </span>
			</div>

			<div class="six columns end">
			    <label for="status"><?php echo __('tickets:ticket_status'); ?></label>
			    <span class="sel-item">
					<select id="status" name="status">
						<option value="">Open</option>
					</select>
			    </span>
			</div>

			<div class="twelve columns">
				<input type="submit" id="submit" class="blue-btn" value="Add Ticket">
			</div>
		</div><!--/row-->
	</form>
</div>
