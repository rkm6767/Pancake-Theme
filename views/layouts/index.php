<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title><?php echo $template['title']; ?></title>
        <link rel="stylesheet" href="<?php echo asset::get_src('app.css', 'css'); ?>">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo asset::get_src('favicon.ico', 'img'); ?>" />
        <link rel="apple-touch-icon" href="<?php echo asset::get_src('apple-icon.png', 'img'); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo asset::get_src('apple-icon-72.png', 'img'); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo asset::get_src('apple-icon-114.png', 'img'); ?>">

        <!-- CSS -->

        <?php asset::css('foundation.css', array('media' => 'screen'), 'main-css'); ?>
        <?php asset::css('stacked.css', array('media' => 'all'), 'main-css'); ?>
        <?php asset::css('redactor.css', array('media' => 'screen'), 'main-css'); ?>
        <?php //asset::css('stacks.css', array('media' => 'all'), 'main-css'); ?>
        <?php asset::css('jquery.minicolors.css', array(), 'main-css'); ?>
        <?php asset::css('timePicker.css', array(), 'main-css'); ?>
        <?php asset::css('jquery.meow.css', array(), 'main-css'); ?>
        <?php asset::css('pancake-ui/smoothness-1.10.4/jquery-ui-1.10.4.custom.min.css', array('media' => 'screen'), 'main-css'); ?>
        <?php echo asset::render('main-css'); ?>

        <?php if (Settings::get('backend_css')): ?>
            <style type="text/css">
    <?php echo Settings::get('backend_css'); ?>
            </style>
        <?php endif; ?>

        <?php if (isset($iframe) and $iframe): ?>
            <style>
                .iframe .contain-to-grid, .iframe #header, footer, .iframe #invoice-type-block, .iframe .gateway-items {display:none;}
            </style>
        <?php endif; ?>

        <script>
            pancake_demo = <?php echo PANCAKE_DEMO ? 'true' : 'false'; ?>;
            window.jQuery || document.write('<script src="<?php echo asset::get_src('javascripts/foundation/jquery.js', 'foundation'); ?>">\x3C/script>');
            refreshTrackedHoursUrl = '<?php echo site_url('ajax/refresh_tracked_hours/'); ?>';
            baseURL = '<?php echo substr((substr(site_url('ajax'), -1) == '/') ? site_url('ajax') : site_url('ajax') . '/', 0, -5); ?>';
            siteURL = '<?php echo rtrim(site_url(), '/'); ?>/';
            php_date_format = "<?php echo Settings::get('date_format'); ?>";
            datePickerFormat = "<?php echo get_date_picker_format(); ?>";
            storeTimeUrl = '<?php echo site_url('ajax/store_time'); ?>';
            lang_paymentdetails = '<?php echo __('partial:paymentdetails'); ?>';
            lang_markaspaid = '<?php echo __('partial:markaspaid'); ?>';
            submit_import_url = '<?php echo site_url('admin/settings/submit_import/') ?>';
            lang_loading_please_wait = '<?php echo addslashes(__('update:loadingpleasewait')); ?>';
            submit_hours_url = '<?php echo site_url('admin/projects/times/add_hours') ?>';
            task_time_interval = '<?php echo format_hours(Settings::get('task_time_interval')); ?>';
            show_task_time_interval_help = <?php echo ((process_hours(Settings::get('task_time_interval'))) > 0) ? 'true' : 'false' ?>;
            settings = <?php echo json_encode(Settings::get_all()); ?>;
            use_24_hours = <?php echo strstr(PAN::setting('time_format'), 'A') !== false ? 'false' : 'true'; ?>;

            var __ = function(string, variables) {
                pancake_language_strings = <?php echo json_encode(get_instance()->lang->language); ?>;

                string = (typeof pancake_language_strings[string] !== 'undefined') ? pancake_language_strings[string] : string;

                if (typeof variables === "object") {
                    var i = 1;
                    $.each(variables, function(key, value) {
                        string.split(':'+(i + 1)).join(value);
                        i++;
                    });
                }

                return string;
            };

            var site_url = function(url) {
                return "<?php echo BASE_URL ?>" + url;
            };

        </script>

        <!-- Javascript
    ================================================== -->
        <?php asset::js('jquery-1.11.0.min.js', array(), 'main-js'); ?>

        <?php
        /*
         * If the current environment is "development", then the dev version of jQuery Migrate will be loaded,
         * which will generate console warnings about everything that needs updating.
         */
        ?>
        <?php asset::js('jquery-migrate-1.2.1'.(ENVIRONMENT == 'production' ? '.min' : '').'.js', array(), 'main-js'); ?>
        <?php asset::js('redactor/redactor.min.js', array(), 'main-js'); ?>
        <?php asset::js('jquery.meow.js', array(), 'main-js'); ?>
        <?php asset::js('main.js', array(), 'main-js'); ?>
        <?php asset::js('jquery-ui-1.10.4.custom.min.js', array(), 'main-js'); ?>
        <?php asset::js('plugins.js', array(), 'main-js'); ?>
        <?php asset::js('jquery.minicolors.js', array(), 'main-js'); ?>
        <?php asset::js('jquery.timePicker.min.js', array(), 'main-js'); ?>

	<?php asset::foundation('javascripts/foundation/jquery.foundation.forms.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.reveal.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.navigation.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.buttons.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.tabs.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.tooltips.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.accordion.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.placeholder.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.alerts.js', array(), 'foundation-js'); ?>
        <?php asset::foundation('javascripts/foundation/jquery.foundation.topbar.js', array(), 'foundation-js'); ?>

        <?php asset::js('jquery.backstretch.min.js', array(), 'secondary-js'); ?>
        <?php asset::js('jquery.wookmark.js', array(), 'secondary-js'); ?>
        <?php asset::js('jquery.knob.js', array(), 'secondary-js'); ?>

        <?php echo asset::render('main-js'); ?>
        <?php echo asset::render('secondary-js'); ?>
        <?php echo asset::render('foundation-js'); ?>


        <!-- IE Fix for HTML5 Tags -->
        <!--[if lt IE 9]>
          <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body id="body-wrap" class="<?php echo (isset($iframe)) ? ($iframe ? 'iframe' : '') : ''; ?> not-login-layout main-layout">

        <!-- Header and Nav -->
        <div class="fixed ">
            <nav class="top-bar">
                <ul>
                    <!-- Title Area -->
                    <?php /* alternate home link:
                      <li id="home-link">
                      <?php echo anchor('admin/','Dashboard'); ?>
                      </li>
                     */ ?>
                    <li id="backend-logo" class="name">
                        <?php echo logo(''); ?>
                    </li>

                    <li class="toggle-topbar"><a href="#"></a></li>
                </ul>

                <section>
                    <ul class="left">
                        <?php $this->load->view("partials/navbar_old", array("links" => $navbar, "is_base" => true)); ?>
                    </ul>

                    <ul class="right">
						<!--
						<li class="nav-search">
                            <form method="post" action="<?php echo site_url('/admin/search'); ?>">
                                <input type="text" id="search" placeholder="search" name="q" />
                                <button type="submit" class="hidden">go</button>
                            </form>
                        </li>

                        <li class="divider"></li>
						-->

                        <li class="has-dropdown">
                            <?php if($update_counter > 0): ?><a href="<?php echo site_url('admin/settings#update') ?>" class="tiny button update-badge"><?php echo $update_counter;?></a><?php endif;?>
                            <a href="#"><img src="<?php echo get_gravatar($current_user->email, 30) ?>" class="user-pic" />   <?php echo $current_user->first_name ?></a>
                            <ul class="dropdown">
                                <?php if (is_admin()): ?>
                                    <li><label><?php echo __('global:settings'); ?></label></li>
                                    <li><a href="<?php echo site_url('admin/settings#general') ?>"><?php echo __('settings:general'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#templates') ?>"><?php echo __('settings:emails') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#taxes') ?>"><?php echo __('settings:taxes') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#currencies') ?>"><?php echo __('settings:currencies') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#branding') ?>"><?php echo __('settings:branding') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#payment') ?>"><?php echo __('settings:payment_methods') ?></a></li>
                                    <li <?php echo ($update_counter > 0) ? 'class="updates-available-badge tiny button"' : ''?>>
                                        <?php if($update_counter > 0): ?>
                                        <a href="<?php echo site_url('admin/settings#update') ?>"><?php echo __('global:update'.($update_counter == 1 ? '' : 's').'_available', array($update_counter));?></a>
                                        <?php else: ?>
                                        <a href="<?php echo site_url('admin/settings#update') ?>"><?php echo __('global:update') ?></a>
                                        <?php endif;?>
                                    </li>
                                    <li><a href="<?php echo site_url('admin/settings#importexport') ?>"><?php echo __('settings:importexport') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#feeds') ?>"><?php echo __('settings:feeds') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#api_keys') ?>"><?php echo __('settings:api_keys') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#task_statuses') ?>"><?php echo __('settings:task_statuses') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#ticket_priorities') ?>"><?php echo __('settings:ticket_priorities') ?></a></li>
                                    <li><a href="<?php echo site_url('admin/settings#ticket_statuses') ?>"><?php echo __('settings:ticket_statuses') ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('admin/settings') ?>"><?php echo __("global:all_settings"); ?> &rarr;</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('admin/plugins') ?>"><?php echo __('global:plugins')?></a></li>
                                    <li><a href="<?php echo site_url('admin/store') ?>"><?php echo __('store:store'); ?></a></li>
                                <?php endif ?>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('admin/users/logout') ?>"><?php echo __('login:logout'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </nav>
        </div>

        <!-- End Header and Nav -->
        <!-- Main Grid Section -->



        <div id="main">

            <div class="row">
				<?php echo $template['partials']['notifications']; ?>
			</div>

			<?php if ($module == 'dashboard' and $this->router->fetch_method() == "index"): ?>
			<div id="header">
				<div class="row">
					<h2 class="ttl ttl1">
						<?php echo random_element(lang('global:greetings')).' '.$current_user->first_name; ?>
					</h2>
					<?php echo $template['partials']['search']; ?>
				 </div>

			</div>
			<?php endif; ?>

            <?php echo $template['body']; ?>

        </div><!-- /main end -->

        <br class="clear"/>

        <!-- End Grid Section -->



        <!-- Footer -->

        <footer>
            <div class="footer">
                <div class="row">
                    <div class="six columns">
                        <div id="footer-logo" class="name">
                            <?php echo logo(''); ?>
                        </div>
                    </div>

                    <div class="six columns align-right">
                        <span class="f-logo"><a href="http://pancakeapp.com/">Pancake</a></span>
                        <p><strong style="font-size: 16px;">Pancake</strong> <br /> <?php echo __('global:version', array(Settings::get('version'))); ?></p>
                    </div>
                </div>
            </div>
        </footer><!-- /footer end -->
        <?php if (PANCAKE_DEMO) : ?>
            <?php echo file_get_contents(FCPATH . 'DEMO'); ?>
        <?php endif; ?>

		<!-- <?php echo isset($GLOBALS['HTTP_REQUESTS']) ? $GLOBALS['HTTP_REQUESTS'] : 0; ?> HTTP REQUESTS -->

        <?php if (!isset($iframe) or !$iframe): ?>
            <?php if ($current_user->custom_background != null): ?>
                <script>
                    $.backstretch("<?php echo $current_user->custom_background ?>");
                </script>
            <?php endif ?>
            <script>
                $(document).foundationTopBar();

				$(".close-reveal-modal").click(function() {
                    $(".reveal-modal").trigger("reveal:close");
                });

                $(".fire-ajax").click(function(e) {
                    open_reveal($(this).attr('href'));
                    return false;
                });

                // This is not loading. - Bruno
                // $(document).tooltips();

                // Fixes issue with forms not getting submitted when the Enter key is pressed.
                $('body').on('keypress', 'input, select', function(e) {
                    if (e.keyCode == 13) {
                        $(this).parents('form').trigger('submit');
                    }
                });
            </script>
            <div id="arbitrary-modal" class="reveal-modal medium">
                <div class="modal-content"></div>
                <a class="close-reveal-modal">&#215;</a>
            </div>
            <div id='arbitrary-modal-loading' class="reveal-modal" style='width: 400px; text-align: center;padding: 40px;'>
                <p style="font-size: 2em;"><span class="verb-ing">Loading</span>, please wait...</p>
                <p style="font-size: 1.5em;">This might take a few seconds.</p>
            </div>
        <?php endif; ?>
<?php if (Settings::get('backend_js')): ?>
    <script><?php echo Settings::get('backend_js'); ?></script>
<?php endif; ?>
    </body>
</html>
