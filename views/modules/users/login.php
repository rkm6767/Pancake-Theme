<div id="login-box">
	<?php echo form_open("admin/users/login", 'id="login-form"');?>
	<fieldset>
				<div class="row">
				<label for="email"><?php echo lang('login:username') ?>:</label>
				<?php echo form_input(array(
					'name'	=> 'username',
					'id'	=> 'username',
					'type'	=> 'text',
					'class'	=> 'txt',
					'value' => set_value('username'),
				));?>
				</div>
        
        <script type="text/javascript">document.getElementById('username').focus();</script>
				<div class="row">
					<label for="password"><?php echo lang('login:password') ?>:</label>
					<?php echo form_input(array(
						'name'	=> 'password',
						'id'	=> 'password',
						'type'	=> 'password',
						'class'	=> 'txt',
					));?>
				</div>
				
				<div class="row">
					<label for="remember"><?php echo lang('login:remember') ?>:</label>
					<?php echo form_checkbox('remember', '1', set_checkbox('remember', '1', FALSE), 'style="margin-top: 10px"');?>
				</div>
				
	    <?php if (!PANCAKE_DEMO) :?>
				<div class="row">
					<?php echo anchor('admin/users/forgot_password',  lang('login:forgot'), 'id="forgot-password"'); ?>
				</div>
	    <?php endif;?>
	    
						<input type="submit" class="hidden-submit" />
						<button href="#" class="blue-btn" onclick="document.getElementById('login-form').submit();"><span>&nbsp;&nbsp;<?php echo lang('login:login') ?>&nbsp;&nbsp;</span></button>

	</fieldset>
	<?php echo form_close();?>
</div>
<?php if (PANCAKE_DEMO): ?>
<p>Username: demo</p>
<p>Password: password</p>
<?php endif; ?>