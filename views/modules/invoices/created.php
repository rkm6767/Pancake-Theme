<?php
/**
  * Page: Invoice Created
  */
?>

<div id="header">
	 <div class="row">
	   <h2 class="ttl ttl3"><?php echo __('Success!'); ?></h2>
           <?php echo $template['partials']['search']; ?>
	 </div>
</div>

<div class="row">
  <div class="three columns push-nine side-bar-wrapper">
    <div class="panel">
      <h4 class="sidebar-title">Client URL</h4>
      <p>
        <?php if($invoice->type == 'ESTIMATE'): ?>
          <?php echo __('estimates:addedconf', array($invoice->invoice_number, 
                              Currency::format($invoice->amount, $invoice->currency_code), 
                              "<a href='".site_url("admin/clients/view/".$invoice->client_id)."'>" . $invoice->first_name . " ". $invoice->last_name . "</a>",
                              ($invoice->company != '') ? ", " . __('global:from') . " " .$invoice->company : '' )) ?>
        <?php else: ?>
        
          <?php echo __('invoices:addedconf', array($invoice->invoice_number, 
                              Currency::format($invoice->amount, $invoice->currency_code), 
                               "<a href='".site_url("admin/clients/view/".$invoice->client_id)."'>" . $invoice->first_name . " ". $invoice->last_name . "</a>",
                              ($invoice->company != '') ? ", " . __('global:from') . " " .$invoice->company : '' )) ?>
        <?php endif; ?>
      </p>
  
      <p class="urlToSend"><?php echo __('global:urltosend') ?> <a href="<?php echo site_url($unique_id); ?>" class="url-to-send"><?php echo site_url($unique_id); ?></a></p>
      <p><a href="#" id="copy-to-clipboard" class="blue-btn"><span><?php echo __('global:copytoclipboard') ?></span></a></p>
    </div>
    <div class="panel">
      <h4 class="sidebar-title add-bottom"><?php echo __('global:quick_links'); ?></h4>
      <ul class="side-bar-btns"> 
        <li class="edit"><a href="<?php echo site_url('/admin/'.($invoice->type == 'ESTIMATE' ? 'estimates' : 'invoices').'/edit/'.$unique_id); ?>"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:edit' : 'invoices:edit') ?></span></a></li>
        <li class="preview"><a href="<?php echo site_url($unique_id); ?>"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:preview' : 'invoices:preview') ?></span></a></li>
      </ul>
    </div><!-- /panel-->
  </div><!-- /three -->

  <div class="nine columns pull-three content-wrapper" id="mailperson">
    <div class="form-holder">
    	<?php if($invoice->email != ''): ?>
      	<?php echo form_open('admin/invoices/send/'.$unique_id, 'id="send-invoice"'); ?>
      		<input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>" />
      		  
      		<div class="row">
      		  <div class="twelve columns">
        		  <h3 class="ttl ttl3" style="margin-top: 0;"><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now_title' : 'invoices:send_now_title') ?></h3>
        		  <p><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now_body' : 'invoices:send_now_body') ?></p>
      		  </div>
      		</div>
      		
      		<fieldset class="panel" >
      			<div class="row base-indent">
      				<label for="email"><?php echo __('global:to') ?>: </label>
      				<input type="text" id="email" name="email" style="width:30%;" class=" txt" value="<?php echo $invoice->email; ?>">
      			</div>
      			
      			<div class="row base-indent">
      				<label for="subject"><?php echo __('global:subject') ?>: </label>
      				<input type="text" id="subject" name="subject" style="width:30%;" class=" txt" value="<?php echo get_email_template($invoice->type == 'ESTIMATE' ? 'new_estimate' : 'new_invoice', 'subject'); ?>">
      			</div>
      			
      			<div class="row base-indent">
      				<label for="message">Message: </label>
      				<textarea name="message" rows="15" style="height:200px"><?php echo get_email_template($invoice->type == 'ESTIMATE' ? 'new_estimate' : 'new_invoice', 'message'); ?></textarea>
      			</div>
      			
      			<div class="row base-indent">
      				<a href="#" class="blue-btn" onclick="$('#send-invoice').submit();"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now' : 'invoices:send_now') ?> &rarr;</span></a>
      			</div>
      
      		</fieldset>
      	</form>
    	<?php endif;?>
    </div>
  </div><!-- invoice-block-->
</div><!-- /row -->

<script src="<?php echo asset::get_src('jquery.zclip.min.js');?>"></script>
<script>
    $('a#copy-to-clipboard').each(function() {
        var that = $(this);
        that.click(function() {return false;}).zclip({
            path: '<?php echo asset::get_src('ZeroClipboard.swf', 'js')?>',
            copy: $('.url-to-send').text(),
            afterCopy:function(){
                that.find('span').width(that.width()).text('<?php echo __('global:copied');?>');
                setTimeout(function() {
                    that.find('span').text('<?php echo __('global:copytoclipboard') ?>');
                }, 500);
            }
        })
    });
</script>