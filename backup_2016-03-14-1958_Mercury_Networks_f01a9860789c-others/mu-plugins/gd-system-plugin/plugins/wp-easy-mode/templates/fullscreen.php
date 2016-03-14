<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>">

	<title><?php wpem_template_title() ?></title>

	<?php wp_print_styles( 'wpem-fullscreen' ) ?>

	<style type="text/css">
	.wpem-steps-list li {
		width: <?php echo wpem_round( 100 / count( wp_easy_mode()->admin->get_steps() ), 2 ) ?>%;
	}
	</style>

	<?php wp_print_scripts( 'jquery' ) ?>

	<!--[if lte IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/webshim/1.15.10/dev/polyfiller.js"></script>
		<script type="text/javascript">
			jQuery.webshim.setOptions( 'extendNative', true );
			jQuery.webshim.polyfill( 'forms' );
		</script>
	<![endif]-->

</head>

<body class="wp-core-ui wpem-screen <?php echo esc_attr( sprintf( 'wpem-step-%d', wpem_get_current_step()->position ) ) ?> <?php echo esc_attr( sprintf( 'wpem-step-%s', wpem_get_current_step()->name ) ) ?>" onunload="">

	<h1 id="logo">

		<a href="<?php echo self_admin_url() ?>"><?php _e( 'WordPress', 'wp-easy-mode' ) ?></a>

	</h1>

	<?php wpem_template_list_steps() ?>

	<div id="wpbody-content">

		<div class="wrap">

			<?php do_action( 'wpem_template_notices' ) ?>

			<h1><?php echo esc_html( wpem_get_current_step()->page_title ) ?></h1>

			<form method="post">

				<?php wpem_get_current_step()->content() ?>

				<div class="clearfix"></div>

				<div class="wpem-actions">

					<?php wpem_get_current_step()->actions() ?>

					<input type="hidden" id="wpem_step_name" name="wpem_step_name" value="<?php echo esc_attr( wpem_get_current_step()->name ) ?>">

					<input type="hidden" id="wpem_step_took" name="wpem_step_took" value="">

					<input type="hidden" id="wpem_force_refresh" value="false">

					<?php wp_nonce_field( sprintf( 'wpem_step_nonce-%s-%d', wpem_get_current_step()->name, get_current_user_id() ), 'wpem_step_nonce' ) ?>

				</div>

			</form>

		</div>

	</div>

	<?php wpem_template_footer() ?>

</body>

</html>
