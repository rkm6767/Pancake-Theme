<div class="client-item row">
    <div class="client-info row">
        <div class="ten columns mobile-three">
            <img src="<?php echo get_gravatar($row->email, '50') ?>" class="client-user-pic" />	



            <?php if ($row->first_name != ''): ?>
                <span class="f-thin-black"><a href="<?php echo site_url('admin/clients/view/' . $row->id); ?>"><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></a></span> <span class="f-thin-grey"><?php if ($row->company) {
                echo "($row->company)";
            } ?></span>
            <?php else: ?>
                <span class="f-thin-black"><a href="<?php echo site_url('admin/clients/view/' . $row->id); ?>"><?php if ($row->company) {
                echo "$row->company";
            } ?></a></span>
<?php endif ?>

            <br />

            <span class="contact address"></span> <span class="contact-text"><a href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $row->unique_id); ?>">Client Area</a></span>

            <?php
            if ($row->phone || $row->mobile) {
                if ($row->phone) {
                    echo '<span class="contact phone">Phone</span> <span class="contact-text"><a href="#" data-client="' . $row->id . '">' . $row->phone . '</a></span>';
                }
                if ($row->mobile) {
                    echo '<span class="contact mobile">Mobile</span> <span class="contact-text"><a href="#" data-client="' . $row->id . '">' . $row->mobile . '</a></span>';
                }
            }
            ?>
            <span class="contact email">Email</span> <span class="contact-text"><?php echo mailto($row->email) ?></span>

        </div><!-- /ten -->
        <div class="two columns projects mobile-one">
            Projects <br />
            <span class="project-count"><?php echo $row->project_count; ?></span>
        </div><!-- /two -->
    </div><!-- /client-info-->

    <div class="client-extra row">
        <div class="three columns mobile-one"><strong>Unpaid:</strong> <?php echo Currency::format($row->unpaid_total); ?></div>
        <div class="three columns mobile-one"><strong>Paid</strong> <?php echo Currency::format($row->paid_total); ?></div>
        <div class="three columns mobile-one">
            <div class="healthCheck">
                <span class="healthBar"><span class="paid" style="width:<?php echo $row->health['overall']; ?>%"></span></span>
            </div><!-- /healthCheck -->
        </div><!-- /three -->
        <div class="three columns align-right mobile-one">
            <?php if (can('delete', $row->id, 'clients', $row->id)): ?>
    <?php echo anchor('admin/clients/delete/' . $row->id, lang('global:delete'), array('class' => 'icon delete', 'title' => __('global:delete'))); ?>
<?php endif ?>

<?php if (can('update', $row->id, 'clients', $row->id)): ?>
    <?php echo anchor('admin/clients/edit/' . $row->id, __('global:edit'), array('class' => 'icon edit', 'title' => __('global:edit'))); ?>
<?php endif ?>
        </div><!-- /three-->
    </div><!-- /client-exra-->
</div><!-- /client-item -->