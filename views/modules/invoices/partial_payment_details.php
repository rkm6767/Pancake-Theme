<div id="modal-header">
    <div class="row">
        <h3 class="ttl ttl3">Payment Details</h3>
    </div>
</div>

<div id="<?php echo $is_add_payment ? 'add_payment' : 'partial-payment-details'?>">
    <form class="form-holder row <?php echo $is_add_payment ? '': 'partial-payment-details';?>">
        <div class="row">
          <div class="twelve columns">
            <label><?php echo __('partial:paymentmethod');?></label>
            <span class="sel-item"><?php echo form_dropdown('payment-gateway', Gateway::get_enabled_gateway_select_array(), $gateway, 'class=""'); ?></span>
          </div>
        </div>
        
      <div class="row">
        <?php if (!$is_add_payment): ?>
          <div class="six columns">
            <label><?php echo __('partial:paymentstatus');?></label>
            <span class="sel-item"><?php echo form_dropdown('payment-status', array('Completed' => __('gateways:completed'), 'Pending' => __('gateways:pending'), 'Refunded' => __('gateways:refunded'), '' => __('gateways:unpaid')), $status === '0' ? '' : $status, 'class=""'); ?></span>
          </div>
        <?php else: ?>
          <div class="six columns">
            <label><?php echo __('invoices:amount');?></label>
            <input type="text" class="text txt" name="payment-amount" value="">
          </div>
        <?php endif;?>
      
        <div class="six columns">
          <label><?php echo __('partial:paymentdate');?></label>
          <input type="text" class="text txt datePicker" name="payment-date" value="<?php echo $date;?>">
        </div>
      </div><!-- /row-->
	    
	    <div class="row">
        <div class="six columns">
          <label><?php echo __('partial:transactionfee');?></label>
          <div class="row">
              <div class="two columns">
                  <label for="fee" class="fee-label"><?php echo $currency;?></label>
              </div>
              <div class="ten columns">
                  <input type="text" class="text txt" id="fee" name="transaction-fee" value="<?php echo $fee;?>">
              </div>
          </div>
         
         
        </div>

        <div class="six columns">
          <label><?php echo __('partial:transactionid');?></label>
          <input type="text" name="payment-tid" class="text txt" value="<?php echo $tid;?>">
        </div>
      </div><!-- /row -->
        
      <div class="row">
          <div class="twelve columns">
            <input type="checkbox" name="send_payment_notification" value="1"> Send a payment notification email to the client?
        </div>
      </div>
      
      <div class="row">
        <div class="twelve columns">
          <label></label>
          <a href="#" class="blue-btn <?php echo $is_add_payment ? 'add_payment_button' : 'savepaymentdetails'?>"><span><?php echo __('partial:'.($is_add_payment ? 'add_payment' : 'savepaymentdetails'));?></span></a>
        </div>  
      </div><!-- /row -->

      <input type="submit" class="hidden-submit" />
    </form>
</div>

<a class="close-reveal-modal">×</a>

<script>
  $(".datePicker").datepicker( "getDate");
    // fix for modal close
    $(".close-reveal-modal").click(function () {
         $(".reveal-modal").trigger("reveal:close");
    });
</script>