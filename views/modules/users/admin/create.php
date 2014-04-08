<div class="modal-form-holder">

  <div id="modal-header">
  	<div class="row">
		 <h3 class="ttl ttl3">Create User</h3>
  	</div>
  </div>
  
	 <p>Please enter the user's information below.</p>
         <?php 
         $validation = validation_errors();
         if (!empty($validation)) {
             echo '<div class="error" style="padding: 1em;margin-bottom: 2em;">';
             echo $validation;
             echo '</div>';
         }
         ?>
	 
	 <?php echo form_open("admin/users/create", 'id="user-form"');?>
   <div class="row">
	 <div class="row user-form form-holder">
	   <div class="four columns">
	     <!-- issue: needs to update dependant on email provided in email field -->
	     <img class="user-gravatar" src="http://www.gravatar.com/avatar/31cdba71cc02563767db3ed44deec276?s=130&d=mm&r=g" />
	   </div>
	   
	   <div class="eight columns">
			<div class="row add-bottom">
    		<div class="six columns">
  				<label for="first_name">First Name:</label>
      		<?php echo form_input(array(
      			'name'	=> 'first_name',
      			'id'	=> 'first_name',
      			'type'	=> 'text',
      			'value'	=> set_value('first_name'),
   					'placeholder' => 'First Name',
      			'class'	=>	'txt',
      		)); ?>
    		</div><!-- /6-->
    		
        <div class="six columns end">
          <label for="last_name">Last Name:</label>
      		<?php echo form_input(array(
      			'name'	=> 'last_name',
      			'id'	=> 'last_name',
      			'type'	=> 'text',
      			'class'	=>	'txt',
      			'placeholder' => 'Last Name',
      			'value'	=> set_value('last_name'),
      		));?>
    		</div><!-- /6-->
			</div><!-- /row -->

      <div class="row add-bottom"> 
    		<div class="six columns">
    		  <label for="email">Email:</label>
      		<?php echo form_input(array(
      			'name'	=> 'email',
      			'id'	=> 'email',
      			'type'	=> 'text',
      			'class'	=>	'txt',
      			'placeholder' => 'Email',
      			'value'	=> set_value('email'),
      		)); ?>
    		</div><!-- /12 -->
    		
    		<div class="six columns end">
	        <span class="sel-item"><?php echo form_dropdown('group', $groups, set_value('group'), '');?></span>
	      </div><!-- /8 -->
			</div><!-- /row -->

		 <div class="row add-bottom"> 
	     <div class="six columns">
    		 <label for="company">Company:</label>
    		 <?php echo form_input(array(
    			 'name'	=> 'company',
    			 'id'	=> 'company',
    			 'type'	=> 'text',
    			 'class'	=>	'txt',
    			 'placeholder' => 'Company',
    			 'value'	=> set_value('company'),
    	  	));?>
  		</div>

  		<div class="six columns end">
    		<label for="phone1">Phone:</label>
    		<?php echo form_input(array(
    			'name'	=> 'phone',
    			'id'	=> 'phone',
    			'type'	=> 'text',
    			'class'	=>	'txt',
    			'placeholder' => 'Phone',
    			'value'	=> set_value('phone'),
    		));?>
  		</div>
    </div><!-- /row -->
	
	</div><!-- /eight -->
	
	<br class="clear" />
  
  <div class="twelve columns add-bottom">
		<div class="row add-bottom">
    	<div class="four columns">
      	<label for="username">Username:</label>
      	<?php echo form_input(array(
    			'name'	=> 'username',
    			'id'	=> 'username',
    			'type'	=> 'text',
    			'class'	=>	'txt',
    			'placeholder' => 'Username',
    			'value'	=> set_value('username'),
    		));?>
  		</div><!-- /6-->
    		
  		<div class="four columns">
    		<label for="password">Password:</label>
    		<?php echo form_password(array(
    			'name'	=> 'password',
    			'id'	=> 'password',
    			'type'	=> 'password',
    			'class'	=>	'txt',
    		  'placeholder' => 'Password',
    			'value'	=> set_value('password'),
    		));?>
      </div>
      
      <div class="four columns end">
    		<label for="password_confirm">Confirm Password:</label>
    		<?php echo form_password(array(
    			'name'	=> 'password_confirm',
    			'id'	=> 'password_confirm',
    			'type'	=> 'password',
    			'class'	=>	'txt',
    		  'placeholder' => 'Confirm Password',
    			'value'	=> set_value('password_confirm'),
    		));?>
      </div>
	  </div><!-- /row -->    		
	 </div><!-- /12 -->
	 
	 <div class="twelve columns no-bottom">
     	<a href="#" onclick="$('#user-form').submit()" class="blue-btn"><span>Create User</span></a>
     	<input type="submit" class="hidden-submit" />
	 </div><!-- /12 -->
 </div><!-- /row -->

<?php echo form_close();?>
</div>

<a class="close-reveal-modal">&#215;</a>

<script>
	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>
</div><!-- /modal-form-holder -->