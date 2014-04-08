<?php $expenses_sum = !isset($expenses_sum) ? 0 : $expenses_sum; ?>
<div id="header" >
	 <div class="row client-header">
	   <?php if ($client->company): ?>
			 <h2 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client->company; ?></h2>
		 <?php else: ?>
			 <h2 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client->first_name . ' ' . $client->last_name;?></h2>
		 <?php endif; ?>
                         <?php echo $template['partials']['search']; ?>


  	 <div class="client-image">
            <img src="<?php echo get_gravatar($client->email, '200'); ?>" alt="<?php echo $client->first_name . ' ' . $client->last_name;?> image"/>
         </div><!-- client-image -->
	 </div><!-- client-header-->
</div><!-- header-->

<div class="row">
  <div class="client-contact">
    <?php if ($client->phone != '') { ?>
      <span class="contact phone"><?php echo lang('global:phone'); ?>:</span> <span class="contact-text"><?php echo $client->phone; ?></span>
    <?php } if ($client->mobile != '') { ?>
      <span class="contact mobile"><?php echo lang('global:mobile'); ?>:</span> <span class="contact-text"><?php echo $client->mobile; ?></span>
    <?php } if ($client->fax != '') { ?>
      <span class="contact fax"><?php echo lang('global:fax'); ?>:</span> <span class="contact-text"><?php echo $client->fax; ?></span>
    <?php } ?>
    
    <span class="contact email"><?php echo lang('global:email'); ?>:</span> <span class="contact-text"><?php echo mailto($client->email); ?></span>
    <?php if ($client->phone == '' and $client->fax == '' and $client->mobile == '') : ?><br /><?php endif;?>
    <br />

    <?php if ($client->address != '') { ?>
      <span class="contact address">Address:</span> <span class="contact-text"><?php echo $client->company;?>, <?php echo nl2br($client->address);?></span>
    <?php } ?>
  </div>
</div><!-- /row-->

<div class="row">
  <div id="client-details" class="nine columns content-wrapper">
     <div class="row">
      <div class="tweleve columns">
        <div id="ajax_container"></div><!-- /ajax-->
      </div><!-- /twelve -->
    </div><!-- /row -->

    <?php if ($client->profile != '') { ?>
      <div class="row">
        <div id="notesHolder" class="twelve columns">
      	  <h4><?php echo lang('global:notes'); ?></h4>
       	  <p><?php echo nl2br($client->profile);?></p>
      	</div><!-- /notesHolder -->
      </div><!-- /row -->
    <?php } else { ?>
      <br />
    <?php } ?>


    <!-- Status: Needs tweaking for projects in client area, all styles should carry over and be implmeneted. Projects need filtering to client and then looping
         Last seen: 21st October 2012
    -->

    <?php if ($projects): ?>
		  <?php $this->load->view('projects/_projects_row', array('rows' => $projects['active'], 'status' => 'active')); ?>

		  <?php $this->load->view('projects/_projects_row', array('rows' => $projects['archived'], 'status' => 'archived')); ?>
		      <br />
    <?php endif; ?>



    <?php if ($totals['count'] == 0): ?>

                      <?php if (can('create', $client->id, 'invoices')): ?>
    	<div class="no_object_notification">
    	  <h4><?php echo lang('clients:hasnoinvoicetitle') ?></h4>
    	  <p><?php echo lang('clients:hasnoinvoicebody') ?></p>
    	  <p class="call_to_action"><a class="blue-btn" id="create_invoice" href="<?php echo site_url('admin/invoices/create/client/'.$client->id); ?>"><span><?php echo lang('invoices:create'); ?></span></a></p>
    	</div><!-- /no_object_notification -->
        <?php endif;?>

    <?php else: ?>

        <?php if ($invoices['overdue']): ?>

        <h4 class="ttl ttl4"><?php echo __('invoices:overdue'); ?></h4>
        <div class="twelve columns">
          <div class="table-area thirty-days">
            <?php $this->load->view('reports/table', array('rows' => $invoices['overdue'], 'suffix' => 'overdue')); ?>
          </div>
        </div>

        <?php endif; ?>

        <?php if ($invoices['unpaid']): ?>

          <h4 class="ttl ttl4"><?php echo __('invoices:unpaid'); ?></h4>
          <div class="twelve columns">
            <div class="table-area thirty-days">
              <?php $this->load->view('reports/table', array('rows' => $invoices['unpaid'], 'suffix' => 'unpaid')); ?>
            </div>
          </div>

        <?php endif; ?>

      <?php if ($invoices['paid']): ?>

        <h4 class="ttl ttl2"><?php echo __('invoices:paid'); ?></h4>
        <div class="twelve columns">
     		  <div class="table-area thirty-days">
            <?php $this->load->view('reports/table', array('rows' => $invoices['paid'], 'suffix' => 'paid')); ?>
         </div>
        </div>


      <?php endif; ?>

      <?php if ( ! empty($contact_log)): ?>

       <h4 class="ttl ttl2"><?php echo __('contact:title'); ?></h4>
       <div class="twelve columns">
        <div class="table-area">
        	<table class="pc-table">
        		<thead>
        			<tr>
        			    <th><?php echo __('contact:subject') ?></th>
        			    <th><?php echo __('contact:contact') ?></th>
        				<th><?php echo __('global:sent') ?></th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php foreach ($contact_log as $contact): ?>
        		<tr>
        			<td><?php echo $contact->subject; ?></td>
        			<td><?php echo $contact->method == 'email' ? 'e: '.mailto($contact->contact) : 'p: '.$contact->contact; ?></td>
        	   		<td><?php echo format_date($contact->sent_date, 'h:i:s'); ?></td>
        		</tr>
        		<?php endforeach; ?>
        		</tbody>
        	</table>
        </div>
       </div>
      <?php endif; ?>

    <?php endif; ?>
  </div><!-- /client-details-->

  <div class="three columns side-bar-wrapper">
	  <!--<div class="panel">
      <div id="detailsHolder">
      	<h4 class="twelve columns"><?php echo lang('global:details') ?></h4>

      	<div class="three columns counters">
      	  <div class="details outstanding">
      	    <strong class="medium-money"><?php echo Currency::format($totals['overdue']['total']); ?></strong>
      	    <small class="small-title"><?php echo lang('global:overdue') ?></small>
      	  </div>
      	</div>

      	<div class="three columns counters">
      	  <div class="details collect">
      	    <strong class="medium-money"><?php echo Currency::format($totals['unpaid']['total']); ?></strong>
      	    <small class="small-title"><?php echo lang('global:unpaid') ?></small>
      	  </div>
      	</div>

        <div class="three columns counters">
      	  <div class="details paid">
      	    <strong class="medium-money"><?php echo Currency::format($totals['paid']['total']);?></strong>
      	    <small class="small-title"><?php echo lang('global:paid') ?></small>
      	  </div>
      	</div>

        <div class="three columns counters">
      	  <div class="details expenses">
      	    <strong class="medium-money"><?php echo Currency::format($expenses_sum);?></strong>
      	    <small class="small-title"><?php echo 'Expenses' // echo lang('global:expense') ?></small>
      	  </div>
      	</div>
      </div>
    </div><!-- /row -->

    <div class="panel">
      <div class="row">
        <div class="six columns mobile-two">
          <h5><?php echo lang('global:overdue') ?></h5>
          <p class="f-thin-red no-bottom"><?php echo Currency::format($totals['overdue']['total']); ?></p>
        </div><!-- /six overdue -->

        <div class="six columns mobile-two">
          <h5><?php echo lang('global:unpaid') ?></h5>
          <p class="f-thin-black no-bottom"><?php echo Currency::format($totals['unpaid']['total']); ?></p>
        </div><!-- /six overdue -->
      </div><!-- /row -->

      <div class="row">
        <div class="six columns mobile-two">
          <h5><?php echo lang('global:paid') ?></h5>
          <p class="f-thin-black no-bottom"><?php echo Currency::format($totals['paid']['total']);?></p>
        </div><!-- /six overdue -->

        <div class="six columns mobile-two">
          <h5><?php echo 'Expenses'; ?></h5>
          <p class="f-thin-black no-bottom"><?php echo Currency::format($expenses_sum);?></p>
        </div><!-- /six overdue -->
      </div><!-- /row -->
    </div><!-- /panel -->


	  <div class="panel" id="healthcheck-holder">
      <h4 class="sidebar-title"><?php echo lang('clients:health_check') ?></h4>
      <div class="progress-bar blue">
      	 <span style="width:<?php echo $client->health['overall'];?>%"><?php echo $client->health['overall'];?>%</span>
      </div><!-- /healthCheck -->
    </div><!-- /row -->

    <div class="panel">
        <h4 class="sidebar-title"><?php echo __('kitchen:kitchen_name'); ?></h4>

      	<div id="cas-url-holder">
      		<p class="text"><?php echo __('kitchen:description') ?></p>
      		<p class="urlToSend"><strong><?php echo __('kitchen:urltosend') ?></strong> <br/> <a href="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id); ?>" class="url-to-send"><?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id); ?></a></p>
      		<p><a href="#" id="copy-to-clipboard" class="blue-btn"><span><?php echo __('global:copytoclipboard') ?></span></a></p>

          <?php if($client->passphrase == ''): ?>
            <p class="passphrase no-bottom"><?php echo __('kitchen:nopassphrase') ?></p>
          <?php else: ?>
            <p class="passphrase set no-bottom"><?php echo __('kitchen:passphrase') ?>: <span><?php echo $client->passphrase ?></span></p>
          <?php endif; ?>
      	</div><!-- /cas-url-holder -->
	  </div><!-- /panel -->

	  <div class="panel">
	    <h4 class="sidebar-title"><?php echo __('global:quick_links'); ?></h4>
  	  <ul class="side-bar-btns">
  	 		<?php if (can('create', $client->id, 'projects')): ?>
  	 		  <li class="add"><a href="<?php echo site_url('admin/projects/index/0/'.$client->id.'#create'); ?>"><span><?php echo __('projects:add'); ?></span></a></li>
  	 		<?php endif ?>

  	 		<?php if (can('create', $client->id, 'invoices')): ?>
  	 		  <li class="generate-invoice"><a href="<?php echo site_url('admin/invoices/create/client/'.$client->id); ?>"><span><?php echo lang('invoices:create'); ?></span></a></li>
  	 		<?php endif ?>

                        <?php if (can('update', $client->id, 'clients', $client->id)): ?>
                            <li class="edit"><a href="<?php echo site_url('admin/clients/edit/' . $client->id); ?>"><span><?php echo lang('clients:edit'); ?></span></a></li>
                        <?php endif ?>

                        <?php if (can('delete', $client->id, 'clients', $client->id)): ?>
                            <li class="delete"><a href="<?php echo site_url('admin/clients/delete/' . $client->id); ?>"><span><?php echo __('clients:delete'); ?></span></a></li>
                        <?php endif ?>

  	  </ul>
	  </div><!-- /panel -->
  </div><!-- /three -->
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
