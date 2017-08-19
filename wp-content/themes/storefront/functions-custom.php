<?php
// taufiqelrahman.com edited

function my_bootstrap_theme_scripts() {
	wp_register_style('opensans-font','https://fonts.googleapis.com/css?family=Open+Sans');
  wp_enqueue_style( 'opensans-font' );
  wp_register_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '3.0.1', 'all' );
  wp_enqueue_style( 'bootstrap-css' );
  wp_register_style( 'select2OptionPicker-css', get_template_directory_uri() . '/assets/js/select2OptionPicker/select2OptionPicker.css');
  wp_enqueue_style( 'select2OptionPicker-css' );

  wp_register_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ), '3.0.1', true );
  wp_enqueue_script( 'bootstrap-js' );
  wp_register_script( 'select2OptionPicker-js', get_template_directory_uri() . '/assets/js/select2OptionPicker/jQuery.select2OptionPicker.js');
  wp_enqueue_script( 'select2OptionPicker-js' );

}
add_action('wp_enqueue_scripts','my_bootstrap_theme_scripts');

// header
if ( ! function_exists( 'storefront_free_shipping' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_free_shipping() {
		?>
		<span class="free-shipping">Free shipping worldwide</span>
		<?php
	}
}

if ( ! function_exists( 'storefront_current_user_email' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_current_user_email() {
		if (is_user_logged_in()):		
			$current_user = wp_get_current_user();
		?>
			<div class="current-user-email">
				<span><?php echo $current_user->user_email; ?></span>
			</div>
		<?php
		endif;
	}
}

remove_action('storefront_header','storefront_header_cart',60);
add_action('storefront_header','storefront_header_cart',39);
add_action('storefront_header','storefront_free_shipping',1);
add_action('storefront_header','storefront_current_user_email',60);

// footer
if ( ! function_exists( 'storefront_footer_widgets_custom' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_footer_widgets_custom() {
		$rows    = intval( apply_filters( 'storefront_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'storefront_footer_widget_columns', 4 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :

			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) : ?>
			<div class="col-full">
				<div class=<?php echo '"footer-widgets row row-' . strval( $row ) . ' col-' . strval( $columns ) . ' fix"'; ?>><?php

					for ( $column = 1; $column <= $columns; $column++ ) :
						$footer_n = $column + $regions * ( $row - 1 );

						if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) : 
							if ($footer_n != 4) :?>

							<div class="col-lg-2 col-sm-4 footer-widget-<?php echo strval( $column ); ?>">
								<?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
							</div><?php

							else :?>

							<div class="col-lg-6 col-sm-12 footer-widget-<?php echo strval( $column ); ?>">
								<?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
							</div><?php

							endif;

						endif;
					endfor; ?>

				</div></div><!-- .footer-widgets.row-<?php echo strval( $row ); ?> --><?php

				unset( $columns );
			endif;
		endfor;
	}
}
remove_action('storefront_footer','storefront_footer_widgets',10);
add_action('storefront_footer','storefront_footer_widgets_custom',10);


// product page
add_action( 'get_header', 'remove_storefront_sidebar' );
add_action( 'woocommerce_single_product_summary', 'custom_template_single_yousave',15);
add_action( 'woocommerce_single_product_summary', 'custom_template_single_shipping',16);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);

function remove_storefront_sidebar() {
    if ( is_product() ) {
        remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
    }
}

if ( ! function_exists( 'custom_template_single_yousave' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since  1.0.0
	 * @return void
	 */

	function custom_template_single_yousave() {
	global $product;
		?>
		<span class="save-cs-tag">
			<span>You save:</span>
		</span>
		<?php
	}
}
if ( ! function_exists( 'custom_template_single_shipping' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since  1.0.0
	 * @return void
	 */

	function custom_template_single_shipping() {
	global $product;
		?>
		<span class="shipping-cs-tag">
			<span>Shipping:</span>
			<span>Free</span>
		</span>
		<?php
	}
}
// add_action('woocommerce_single_product_summary','woocommerce_template_single_price',60);