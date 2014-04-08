<div class="modal-form-holder">
	<div id="modal-header">
 	   <div class="row">
	 	   <h3 class="ttl ttl3 half-bottom">Edit User</h3>
 	   </div>
	</div>
    
    <p>Please enter the user's information below.</p>
         <?php 
         $validation = validation_errors();
         if (!empty($validation)) {
             echo '<div class="error" style="padding: 1em;">';
             echo $validation;
             echo '</div>';
         }
         
         $errors = isset($errors) ? $errors : '';
         if (!empty($errors)) {
             echo '<div class="error" style="padding: 1em;">';
             echo $errors;
             echo '</div>';
         }
         
         ?>

   <?php echo form_open("admin/users/edit/".$member->id, 'id="user-form"');?>
   <br />
   
   <div class="row">
	   <div class="row user-form form-holder">
	     <div class="four columns">
	       <!-- issue: needs to update dependant on email provided in email field
				Edit: Hard coding as form value for now, I'll fight with this later.
				
				-Lee
	 			-->
			
	
	       <img class="user-gravatar" src="<?php echo get_gravatar($member->email, '130') ?>" />
	     </div><!-- /four -->
	    
  	    <div class="eight columns">
    			<div class="row add-bottom">
        		<div class="six columns">
      				<label for="first_name">First Name:</label>
          		<?php echo form_input(array(
          			'name'	=> 'first_name',
          			'id'	=> 'first_name',
          			'type'	=> 'text',
          			'value'	=> $member->first_name,
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
          			'value'	=> $member->last_name,
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
          			'value'	=> $member->email,
          		)); ?>
        		</div><!-- /12 -->
        		  
        		<div class="six columns end">
        		<?php if (PANCAKE_DEMO): ?>
        		  <label for="group_id">Group:</label>
    	        <span class="sel-item"><?php echo form_dropdown('group_id', $groups, $member->group_id, 'disabled="disabled"');?></span>
    	      <?php else: ?>
    	        <label for="group_id">Group:</label>
    	        <span class="sel-item"><?php echo form_dropdown('group_id', $groups, $member->group_id);?></span>
    	      <?php endif; ?>
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
        			 'value'	=> set_value('company', $member->company),
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
        		  'value'	=> $member->phone ? $member->phone : '',
        		));?>
      		</div>
        </div><!-- /row -->
  	  </div><!-- /eight -->

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
        			'disabled' => true,
        			'value'	=> $member->username,
        		));?>
      		</div><!-- /6-->
      
      		<?php if (PANCAKE_DEMO): ?>
        		<div class="four columns">
          		<label for="password">Password:</label>
          		<?php echo form_password(array(
          			'name'	=> 'password',
          			'id'	=> 'password',
          			'type'	=> 'password',
          			'class'	=>	'txt',
          		  'placeholder' => 'Password',
          			'disabled' => 'disabled',
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
          			'disabled' => 'disabled',
          		));?>
            </div>
          <?php else: ?>
            <div class="four columns">
          		<label for="password">Password:</label>
          		<?php echo form_password(array(
          			'name'	=> 'password',
          			'id'	=> 'password',
          			'type'	=> 'password',
          			'class'	=>	'txt',
          		  'placeholder' => 'Password',
      
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
          		));?>
            </div>  
          <?php endif; ?>
    	  </div><!-- /row -->    		
    	 </div><!-- /12 -->
    
    	 <div class="twelve columns">
         <a href="#" onclick="$('#user-form').submit()" class="blue-btn"><span><?php echo lang('global:save') ?></span></a>
         <input type="submit" class="hidden-submit" />
    	 </div><!-- /12 -->
	 
	   </div><!-- /user-form-->
   </div><!-- /row -->
  <?php echo form_close();?>

<a class="close-reveal-modal">&#215;</a>

<script>
	// fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>
</div><!-- /modal-form-holder -->