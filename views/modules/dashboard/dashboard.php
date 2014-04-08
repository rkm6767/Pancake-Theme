<?php
	// Dashboard
?>

	<?php if (is_admin()): ?>

		<div class="counters row">
			<?php /* <h4 class="sous-title"><?php echo __('global:statistics'); ?></h4> */ ?>
	
			<div class="four columns">
                                <a href="<?php echo site_url('admin/invoices/paid'); ?>" class="collect">
					<small class="small-title"><?php echo lang('dashboard:collected') ?>*</small>
					<strong class="big-money">
						<?php echo Currency::format($paid['total']); ?>
					</strong>
				</a><!-- /collect-->
			</div><!-- /four -->

			<div class="four columns">
				<a href="<?php echo site_url('admin/invoices/unpaid'); ?>" class="outstanding">
					<small class="small-title"><?php echo lang('dashboard:outstanding') ?></small>
					<strong class="big-money"> 
						<?php echo Currency::format($unpaid['total']); ?>
					</strong>
				</a><!-- /outstanding -->
			</div><!-- /four -->

			<div class="four columns">
				<a href="<?php echo site_url('admin/expenses'); ?>" class="expenses">
					<small class="small-title"><?php echo lang('items:expenses'); ?>*</small>
					<strong class="big-money">
						<?php echo Currency::format($expenses_sum); ?>
					</strong>
				</a><!-- /expense-->
			</div><!-- /four -->
	    </div><!-- /row -->

	    <div class="row">
			<div class="twelve columns">
	            <div class="account-stats">
	                <dl class="account-stat-item">
	                    <dt><a href="<?php echo site_url('admin/invoices/paid') ?>" title="<?php echo __('invoices:paid') ?>">
	    			            <?php echo __('invoices:paid') ?>*</a></dt>
	                    <dd><?php echo $paid_count; ?></dd>
	                </dl>
	                <dl class="account-stat-item">
	                    <dt><a href="<?php echo site_url('admin/invoices/unpaid') ?>" title="<?php echo __('invoices:unpaid') ?>">
	    						<?php echo __('invoices:unpaid') ?></a>
	                    <dd><?php echo $unpaid_count; ?></dd>
	                </dl>
	                <dl class="account-stat-item">
	                    <dt><a href="#"><?php echo __('projects:hours_worked_short') ?>*</a></dt>
	    				<dd><?php echo $hours_worked; ?></dd>
	                </dl>
	                <dl class="account-stat-item">
	                    <dt><a href="#"><?php echo __('tasks:timers_running') ?></a></dt>
	                    <dd><?php echo count($timers); ?></dd>
	                </dl>
	                <dl class="account-stat-item">
	    				<dt><a href="<?php echo site_url('admin/projects/') ?>" title="<?php echo __('projects:totalprojects') ?>">
	    						<?php echo __('projects:totalprojects') ?></a></dt>
	    				<dd><?php if ($project_count >= 1) { echo $project_count; } else { echo "0"; } ?></dd>
	                </dl>
	                <dl class="account-stat-item">
	                    <dt><a href="<?php echo site_url('admin/clients/') ?>"><?php echo __('clients:total_clients') ?></a></dt>
	                    <dd><?php echo $client_count; ?></dd>
	                </dl>
	            </div>
                            
                            <p style="text-align: right;"><small>* <?php echo __("dashboard:since_explanation", array(anchor("admin/settings", format_date(Settings::fiscal_year_start()))))?></small></p>
	        </div>
		</div><!-- /account-stats end -->
	<?php endif; ?>
                
	<div id="dashboard-main">
            <?php if (count($my_upcoming_tasks) > 0 or count($team_working_on) > 0): ?>
		<div class="row">
                    <div class="six columns" id="dashboard-content">
                        <?php if (count($my_upcoming_tasks) > 0): ?>
                            <?php $this->load->view("_my_tasks"); ?>
                        <?php endif; ?>
                    </div>
			<div class="three columns" id="dashboard-sidebar-1">
				<?php
					// Client Activity
					$this->load->view('_activity');
				?>
				
			</div>
			<div class="three columns" id="dashboard-sidebar-2">
				<?php $this->load->view("_team_activity"); ?>
			</div>
		</div>
            <?php endif; ?>

		<div class="row">
			<div class="nine columns">
			    <?php if (count($overdue_invoices) > 0 or count($almost_due_and_unseen) > 0): ?>
					<div class="panel radius" id="my-invoices">
						<header>
							<h4><i class="fi-clipboard-notes"></i> <?php echo __('global:invoices') ?></h4>
						</header>
						<?php echo count($overdue_invoices) > 0 ? $this->load->view('reports/table', array('rows' => $overdue_invoices)) : ''; ?>
						<?php echo count($almost_due_and_unseen) > 0 ? $this->load->view('reports/table', array('rows' => $almost_due_and_unseen)) : ''; ?>
					</div><?php // #my-invoices ?>
	            <?php endif; ?>
			</div>
		
			<div class="three columns">
                            
                            <?php if (count($my_upcoming_tasks) == 0 and count($team_working_on) == 0): ?>
                           <?php
					// Client Activity
					$this->load->view('_activity', array("client_activity_x" => 10));
				?>
                            <?php endif;?>
				
				<?php $this->load->view("_comments"); ?>
    
	</div><?php // END #dashboard-main ?>
    
  </div><!-- /nine columns -->



	<div class="three columns side-bar-wrapper">
		<div class="panel">
			<div class="top">
				
			</div>
			
			<div class="top" style="display:none;">
				
				
        <?php if (can_for_any_client('create', 'estimates') or can_for_any_client('create', 'invoices') or is_admin()) : ?>
	        
			<h4 class="sidebar-title"><?php echo __('global:quick_links'); ?></h4>
	        <p><ul class="side-bar-btns">
                    <?php if (can_for_any_client('create', 'invoices')): ?>
	        	<li class="generate-invoice"><a href="<?php echo site_url('admin/invoices/create'); ?>"><span><?php echo lang('invoices:newinvoice') ?></span></a></li>
                        <?php endif;?>
                        <?php if (can_for_any_client('create', 'estimates')): ?>
	        	<li class="generate-invoice"><a href="<?php echo site_url('admin/estimates/create_estimate'); ?>"><span><?php echo lang('estimates:createnew') ?></span></a></li>
                        <?php endif; ?>
	        	<?php if (is_admin()): ?>
                        <li class="add"><a href="<?php echo site_url('admin/clients/create/'); ?>"><span><?php echo __('clients:add'); ?></span></a></li>
                        <?php endif; ?>
	        </ul></p><!-- /btns-list end -->
				
  		    <h4 class="sidebar-title">Date Range</h4>
  		    <p>Use the boxes below to enter a custom date range to filter the boxes to the left. By default it's the last thirty days</p>
    		    <div class="filter-area row">
    		      <!-- area for filters to be implemented -->

      		      <input type="text" name="start-date" class="filter-input" placeholder="Start Date"/>

    		        <input type="text" name="finish-date" class="filter-input" placeholder="End Date"/>

      		      <button name="filter-date" class="blue-btn">Filter</button>

    		    </div><!-- /filter-area -->
				
		
		
			<?php endif; ?>
		</div>
			
			<?php if (is_admin()): ?>
                <?php /*
                    <h4 class="sidebar-title"><?php echo __('global:statistics'); ?></h4>
			
					<div class="counters row">
						<div class="twelve columns">
							<div class="collect">
								<strong class="big-money"><?php echo anchor('admin/invoices/paid', Currency::format($paid['total'])); ?></strong>
								<small class="small-title"><?php echo lang('dashboard:collected') ?></small>
							</div><!-- /collect-->
						</div><!-- /four-->
		
						<div class="twelve columns">
							<div class="outstanding">
								<strong class="big-money"><?php echo anchor('admin/invoices/unpaid', Currency::format($unpaid['total'])); ?></strong>
								<small class="small-title"><?php echo lang('dashboard:outstanding') ?></small>
							</div><!-- /outstanding -->
						</div><!-- /four -->
		
						<div class="twelve columns">
							<div class="expenses">
								<strong class="big-money"><?php echo Currency::format($expenses_sum); ?></strong>
								<small class="small-title"><?php echo lang('items:expenses'); ?></small>
							</div><!-- /expense-->
						</div><!-- /four -->
					</div><!-- /counters end -->
			
					
			<div class="row">
					<div class="six columns mobile-two">
							<a href="<?php echo site_url('admin/invoices/paid') ?>" title="<?php echo __('invoices:paid') ?>">
								<?php echo __('invoices:paid') ?>
								<p class="f-thin-black"><?php echo $paid_count; ?></p>
							</a><!-- /stat-item-->
					</div><!-- /two -->
					
						<div class="six columns mobile-two">
							<a href="<?php echo site_url('admin/invoices/unpaid') ?>" title="<?php echo __('invoices:unpaid') ?>">
								<?php echo __('invoices:unpaid') ?>
								<p class="f-thin-black"><?php echo $unpaid_count; ?></p>
							</a><!-- /stat-item-->
						</div><!-- /two -->
					
						<div class="six columns mobile-two">
							<a href="">
								<?php echo __('projects:hours_worked_short') ?>
								<p class="f-thin-black"><?php echo $hours_worked; ?></p>
							</a><!-- /stat-item-->
						</div><!-- /two -->
					
						<div class="six columns mobile-two">
							<a href="#">
								<?php echo __('tasks:timers_running') ?>
								<p class="f-thin-black"><?php echo count($timers); ?></p>
							</a><!-- /stat-item-->
						</div><!-- /two -->
					
						<div class="six columns mobile-two">
							<a href="<?php echo site_url('admin/projects/') ?>" title="<?php echo __('projects:totalprojects') ?>">
								<?php echo __('projects:totalprojects') ?>
								<p class="f-thin-black"><?php if ($project_count >= 1) { echo $project_count; } else { echo "0"; } ?></p>
							</a><!-- /stat-item-->
						</div><!-- /two -->
					
						<div class="six columns mobile-two">
							<a href="<?php echo site_url('admin/clients/') ?>">
								<?php echo __('clients:total_clients') ?>
								<p class="f-thin-black"><?php echo $client_count; ?></p>
							</a><!-- /stat-item-->
						</div><!-- /two -->
					</div><!-- /stats -->
                */ ?>
					<?php endif;?>
    </div><!-- /panel -->

	</div><!-- /three columns -->
</div><!-- /row -->

<script type="text/javascript">
	$(function() {
		$(".sortable").sortable();
	});
	$("#sous-team li:nth-child(2n+2)").css("margin-right", "0px");
</script>

