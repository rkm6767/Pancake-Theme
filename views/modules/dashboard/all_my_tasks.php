<div id="header">
    <div class="row">
        <h2 class="ttl ttl3"><?php echo __("dashboard:my_tasks") ?></h2>
        <?php echo $template['partials']['search']; ?>
    </div>
</div>
<div id="dashboard-main">
    <div class="row">
        <div class="twelve columns">
            <?php $this->load->view("_my_tasks"); ?>
        </div>
    </div>
</div>
