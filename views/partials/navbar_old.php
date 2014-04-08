<?php if (count($project_nav_timers) >= 1): ?>
                        <ul class="left">
                            <li class="divider"></li>
                            <li class="has-dropdown timers">

                                <?php if (count($timers)): ?>
                                    <a style="margin-right: 20px;" href="#">Timers</a>
                                    <span class="timer-counter" ><?php echo count($timers); ?></span>
                                <?php else: ?>
                                    <a href="#">Timers</a>
                                <?php endif; ?>

                                <ul class="dropdown">

                                    <?php if (count($timers)): ?>
                                        <li><label>Running</label></li>

                                        <?php foreach ($timers as $task_id => $timer): ?>
                                            <li class="has-dropdown"><a href="<?php echo site_url('admin/projects/view/' . $timer['project_id']) ?>"><?php echo $timer['project_name']; ?> &ndash; <?php echo $timer['task_name']; ?></a>
                                                <ul class="dropdown">
                                                    <li <?php timer($timers, $task_id); ?> class="timer navtimer">
                                                        <a href="#" title="Stop Timer" class="timer-button stop" id="start_timer">Stop Timer</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>

                                        <li class="divider"></li>
                                    <?php endif; ?>

                                    <?php if (count($project_nav_timers)): ?>
                                        <li><label>Projects</label></li>
                                        <?php foreach ($project_nav_timers as $p_nav_timer): ?>
                                            <li class="has-dropdown">
                                                <a href="<?php echo site_url('admin/projects/view/' . $p_nav_timer->id) ?>" class=""><?php echo $p_nav_timer->name; ?></a>
                                                <ul class="dropdown">
                                                    <?php foreach ($p_nav_timer->tasks as $p_nav_task): ?>
                                                        <?php
                                                        if ($p_nav_task['id'] == 0) {
                                                            continue;
                                                        }
                                                        ?>
                                                        <li class="has-dropdown">
                                                            <a href="<?php echo site_url('admin/projects/view/' . $p_nav_task['project_id']) ?>"><?php echo $p_nav_task['name']; ?></a>

                                                            <ul class="dropdown">
                                                                <li <?php timer($timers, $p_nav_task['id']); ?> class="timer navtimer">
                                                                    <a class="timer-button play" href="#">
                                                                        <?php echo $p_nav_task['entry_started'] ? __('global:stop_timer') : __('global:start_timer') ?>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <!-- Left Nav Section -->
                    <ul class="left">
                        <li class="divider"></li>
                        
                        <?php if (can_for_any_client('read', 'invoices')): ?>
                        <li class="<?php echo ($module == 'invoices' and substr($this->uri->uri_string(), 6, 9) != 'estimates') ? 'active ' : ''; ?>  has-dropdown">
                            <?php echo anchor('admin/invoices/all', __('global:invoices')); ?>
                            <ul class="dropdown">
                                <?php if (can_for_any_client('create', 'estimates_plus_invoices')): ?>
                                    <li><?php echo anchor('admin/invoices/create', __('global:createinvoice')); ?></li>
                                <?php endif; ?>
                                <li><?php echo anchor('admin/invoices/paid', __('global:paid')); ?> <span class="count">(<?php echo get_count('paid'); ?>)</span></li>
                                <li><?php echo anchor('admin/invoices/overdue', __('global:overdue')); ?> <span class="count">(<?php echo get_count('overdue'); ?>)</span></li>
                                <li><?php echo anchor('admin/invoices/unpaid', __('global:sentbutunpaid')); ?> <span class="count">(<?php echo get_count('sent_but_unpaid'); ?>)</span></li>
                                <li><?php echo anchor('admin/invoices/unsent', __('global:unsent')); ?> <span class="count">(<?php echo get_count('unsent'); ?>)</span></li>
                                <li><?php echo anchor('admin/invoices/recurring', __('global:recurring')); ?> <span class="count">(<?php echo get_count('recurring'); ?>)</span></li>
                                <li><?php echo anchor('admin/invoices/all', __('global:view_all')); ?></li>
                                <?php if (is_admin()): ?>
                                    <li><?php echo anchor('admin/invoices/reminders', __('reminders:reminders')); ?></li>
                                <?php endif ?>
                                <?php if (is_admin()): ?>
                                    <li><?php echo anchor('admin/items', __('global:reusableinvoiceitems')); ?></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <?php endif;?>
                        
						<?php if (can_for_any_client('read', 'estimates')): ?>
                        <li<?php echo (($module == 'invoices' and substr($this->uri->uri_string(), 6, 9) == 'estimates') or ($module == 'estimates')) ? ' class="active"' : ''; ?>><?php echo anchor('admin/invoices/estimates', __('global:estimates')); ?></li>
                        <li class="divider"></li>
                        <?php endif; ?>
                        
						<?php if (can_for_any_client('read', array('projects', 'project_tasks'))): ?>
                            <li<?php echo ($module == 'projects') ? ' class="active"' : ''; ?>><?php echo anchor('admin/projects', __('global:projects')); ?></li>
                            <li class="divider"></li>
                        <?php endif; ?>
						
                        <?php if (can_for_any_client('read', 'project_expenses')): ?>
                        <li class="<?php echo ($module == 'expenses' and substr($this->uri->uri_string(), 6, 9) != 'estimates') ? 'active ' : ''; ?>  <?php echo is_admin() ? 'has-dropdown' : ''; ?>">
                            <?php echo anchor('admin/expenses', __('expenses:expenses')); ?>
                            <?php if (is_admin()): ?>
                                <ul class="dropdown">
                                    <li><?php echo anchor('admin/expenses', __('global:view_all')); ?></li>
                                    <li><?php echo anchor('admin/expenses/suppliers', __('expenses:suppliers')); ?></li>
                                    <li><?php echo anchor('admin/expenses/categories', __('expenses:categories')); ?></li>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <li class="divider"></li>
                        <?php endif;?>

                        <?php if (can_for_any_client('read', 'proposals')): ?>
                        <li<?php echo ($module == 'proposals') ? ' class="active"' : ''; ?>><?php echo anchor('admin/proposals', __('global:proposals')); ?></li>
                        <li class="divider"></li>
                        <?php endif;?>
                        
                        <?php if (can_for_any_client('read', 'tickets')): ?>
                        <li<?php echo ($module == 'tickets') ? ' class="active"' : ''; ?>><?php echo anchor('admin/tickets', __('global:tickets')); ?></li>
                        <li class="divider"></li>
                        <?php endif; ?>
						
                        <li class="more-link has-dropdown">
                            <a href="#" title="More Options">More</a>
                            <ul class="dropdown">		
                                
                                 <?php if (can_for_any_client('read', 'project_tasks')): ?>
		                            <li><?php echo anchor('admin/projects/app', __('global:timer_app'), array('class' => "open-timer-app")); ?></li>
		                        <?php endif; ?>
                                
								<?php if (can_for_any_client('read', 'invoices')): ?>
	                    			<li<?php echo ($module == 'reports') ? ' class="active"' : ''; ?>><?php echo anchor('admin/reports', __('global:reports')); ?></li>
	                    		<?php endif;?>
					
	                    		<?php if (can_for_any_client('read', 'clients')): ?>
	                    			<li<?php echo ($module == 'clients') ? ' class="active"' : ''; ?>><?php echo anchor('admin/clients', __('global:clients')); ?></li>
		                        <?php endif; ?>
                        
		                        <?php if (is_admin()): ?>
		                            <li<?php echo ($module == 'users') ? ' class="active"' : ''; ?>><?php echo anchor('admin/users', __('global:users')); ?></li>
		                        <?php endif; ?>
							</ul>
						</li>
                    </ul>