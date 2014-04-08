<?php $more_threshold = 8; ?>

<?php $i = 1; ?>
<?php foreach ($links as $url => $details): ?>
    <?php if ($i == $more_threshold and $is_base): ?>
        <li class="more-link has-dropdown">
            <a href="#"><?php echo __("global:more")?></a>
            <ul class="dropdown">
    <?php endif; ?>
    <li class="<?php echo (count($details['children']) > 0) ? "has-dropdown" : ""; ?>">
        <a href="<?php echo substr($url, 0, 1) === "#" ? $url : site_url($url); ?>"><?php echo __($details['title']); ?></a>
        
        <?php if ($details['badge'] !== null): ?>
            <span class="<?php echo $is_base ? "timer-counter" : "count"; ?>"><?php echo $details['badge']; ?></span>
        <?php endif; ?>
        
        <?php if (count($details['children']) > 0): ?>
            <ul class="dropdown">
                <?php $this->load->view("partials/navbar", array("links" => $details['children'], "is_base" => false)); ?>
            </ul>
        <?php endif; ?>
    </li>
    <?php if ($is_base and $i < $more_threshold): ?>
        <li class="divider"></li>
    <?php endif; ?>
    <?php $i++; ?>
<?php endforeach; ?>
<?php if ($i > $more_threshold and $is_base): ?>
        </ul>
    </li>
<?php endif;?>
