<?php foreach ($tickets as $ticket): ?>
    <li class="ticket-item ticket-item-preview <?php echo in_array($ticket->status_title, array('New', 'Pending')) ? 'unread' : ''; ?> <?php echo isset($current_ticket) && $current_ticket->id == $ticket->id ? 'current' : ''; ?>">
        <a href="<?php echo site_url('admin/tickets/view/' . $ticket->id) ?>">
            <div class="image"><img src="<?php echo get_gravatar($ticket->client_email, 60) ?>"/></div>
            <div class="body">
                <h4><?php echo $ticket->client_first_name . ' ' . $ticket->client_last_name ?> 

                    <?php if ($ticket->is_billable) : ?>
                        <?php if ($ticket->is_paid) : ?>
                            (<span class="ticket-paid">$</span>)
                        <?php else : ?>
                            <span class="ticket-unpaid">($)</span>
                        <?php endif; ?>
                    <?php endif; ?>


                </h4>
                <p><strong style="border-bottom: 2px solid <?php echo $ticket->priority_background_color ?>;"><?php echo $ticket->subject ?></strong> <br />
                    <?php echo $ticket->latest_post ? $ticket->latest_post->message : '<em>' . __('tickets:no_posts') . '</em>' ?>
                </p>
            </div>
            <span class="date"><?php echo format_date($ticket->created, true) ?></span>
        </a>
        <br class="clear" />
    </li>
<?php endforeach ?>
<?php if ($this->router->fetch_method() != "archived" and (!isset($current_ticket) or !$current_ticket->is_archived)): ?>
    <li class="ticket-item add">
        <!-- <a href="#"> -->
        <div class="image"></div>
        <div class="body">
            <h4 style="color: #777; margin-bottom: 12px; margin-top: 10px; font-size: 14px; font-style: italic;"><?php echo anchor('admin/tickets/archived', __('tickets:view_archived') . ' &rarr;') ?></h4>
        </div>
        <!-- </a> -->
        <br class="clear" />
    </li>
<?php else: ?>
    <li class="ticket-item add">
        <!-- <a href="#"> -->
        <div class="image"></div>
        <div class="body">
            <h4 style="color: #777; margin-bottom: 12px; margin-top: 10px; font-size: 14px; font-style: italic;"><?php echo anchor('admin/tickets/index', __('tickets:view_unarchived') . ' &rarr;') ?></h4>
        </div>
        <!-- </a> -->
        <br class="clear" />
    </li>
<?php endif; ?>