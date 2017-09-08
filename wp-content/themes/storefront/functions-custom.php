<?php
/**
 * A custom function page to manipulate wordpress hooks using PHP.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package storefront
 * Developed by: taufiqelrahman.com
 * Developed on: 10th August 2017
 */

function my_bootstrap_theme_scripts()
{
    wp_register_style('opensans-font', 'https://fonts.googleapis.com/css?family=Open+Sans');
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
add_action('wp_enqueue_scripts', 'my_bootstrap_theme_scripts');

// header
if (! function_exists( 'storefront_free_shipping' )) {
    /**
     * Site branding wrapper and display
     *
     * @since  1.0.0
     * @return void
     */
    function storefront_free_shipping()
    {
        ?>
        <span class="free-shipping">Free shipping worldwide</span>
        <?php
    }
}

if (! function_exists( 'storefront_current_user_email' )) {
    /**
     * Site branding wrapper and display
     *
     * @since  1.0.0
     * @return void
     */
    function storefront_current_user_email()
    {
        // if (is_user_logged_in()) :
        //     $current_user = wp_get_current_user();
        ?>
            <div class="current-user-email">
                <span><?php 
                    // echo $current_user->user_email; 
                    echo get_option('admin_email');
                ?></span>
            </div>
        <?php
        // endif;
    }
}

remove_action('storefront_header', 'storefront_header_cart', 60);
add_action('storefront_header', 'storefront_header_cart', 39);
add_action('storefront_header', 'storefront_free_shipping', 1);
add_action('storefront_header', 'storefront_current_user_email', 60);

// footer
if (! function_exists( 'storefront_footer_widgets_custom' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */
    function storefront_footer_widgets_custom()
    {
        $rows    = intval( apply_filters( 'storefront_footer_widget_rows', 1 ) );
        $regions = intval( apply_filters( 'storefront_footer_widget_columns', 4 ) );

        for ($row = 1; $row <= $rows; $row++) :
            // Defines the number of active columns in this footer row.
            for ($region = $regions; 0 < $region; $region--) {
                if (is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) )) {
                    $columns = $region;
                    break;
                }
            }

            if (isset( $columns )) : ?>
            <div class="col-full">
                <div class=<?php echo '"footer-widgets row row-' . strval( $row ) . ' col-' . strval( $columns ) . ' fix"'; ?>><?php

                for ($column = 1; $column <= $columns; $column++) :
                    $footer_n = $column + $regions * ( $row - 1 );

                    if (is_active_sidebar( 'footer-' . strval( $footer_n ) )) :
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
if (! function_exists( 'storefront_footer_site_info' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function storefront_footer_site_info()
    {
        ?>
        <div class="content-copyright text-center" itemprop="streetAddress">Central Jakarta, Indonesia</div>
        <div class="content-copyright text-center">Developed by <a target="_blank" href="https://taufiqelrahman.com">taufiqelrahman.com</a>.</div>
        <?php
    }
}
if (! function_exists( 'storefront_footer_social_media' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function storefront_footer_social_media()
    {
        ?>
        <ul class="footer-social-media">
            <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        </ul>
        <?php
    }
}
if (! function_exists( 'storefront_footer_payment_delivery_methods' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function storefront_footer_payment_delivery_methods()
    {
        ?>
        <div id="payment-delivery-methods">
            <div class="col-full">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <span>Payment Methods:</span>
                        <img src="/wp-content/uploads/2017/08/Mastercard-Logo.png"/>
                        <img src="/wp-content/uploads/2017/08/Visa-Logo.png"/>
                        <a href="https://www.paypal.com/webapps/mpp/paypal-popup" target="_blank"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt=""></a>
                    </div>                
                    <div class="col-xs-12 col-sm-6">
                        <span>Delivery Methods:</span>
                        <img src="/wp-content/uploads/2017/08/EMS-Logo.png"/>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

remove_action('storefront_footer', 'storefront_footer_widgets', 10);
add_action('storefront_footer', 'storefront_footer_widgets_custom', 10);
add_action('storefront_footer', 'storefront_footer_site_info', 21);
add_action('storefront_before_footer', 'storefront_footer_payment_delivery_methods', 1);
add_action('storefront_footer', 'storefront_footer_social_media', 22);


// product page
add_action( 'get_header', 'remove_storefront_sidebar' );
add_action( 'woocommerce_single_product_summary', 'custom_template_single_yousave', 15);
add_action( 'woocommerce_single_product_summary', 'custom_template_single_shipping', 16);
add_action( 'woocommerce_after_single_product_summary', 'custom_template_single_trio_slogans', 9);
add_action( 'woocommerce_after_single_product_summary', 'custom_template_single_tabs_shipping_delivery', 11);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

function remove_storefront_sidebar()
{
    if (is_product()) {
        remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
    }
}

if (! function_exists( 'custom_template_single_yousave' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function custom_template_single_yousave()
    {
        global $product;
        ?>
        <span class="save-cs-tag">
            <span>You save:</span>
            <span class="discounted-price">-</span>
        </span>
        <?php
    }
}
if (! function_exists( 'custom_template_single_shipping' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function custom_template_single_shipping()
    {
        global $product;
        ?>
        <span class="shipping-cs-tag">
            <span>Shipping:</span>
            <span>Free</span>
        </span>
        <?php
    }
}
if (! function_exists( 'custom_template_single_tabs_shipping_delivery' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function custom_template_single_tabs_shipping_delivery()
    {        
        include('shipping-delivery-custom.php');
    }
}
if (! function_exists( 'custom_template_single_trio_slogans' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function custom_template_single_trio_slogans()
    {
        global $product;
        ?>
				<div class="secondary-slider hidden-xs hidden-sm panel-row-style panel-row-style-for-1133-1">
					<div class="widget_text secondary-slider-div panel-widget-style panel-widget-style-for-1133-1-0-0">
						<div class="textwidget custom-html-widget">
							<img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/Delivery.png">
							<h4 class="secondary-slider-title">Free shipping worldwide</h4>
							<span class="secondary-slider-text">Our store operates worldwide and you can enjoy free delivery of all orders</span>
						</div>
					</div>
					<div class="widget_text secondary-slider-div panel-widget-style panel-widget-style-for-1133-1-0-0">
						<div class="textwidget custom-html-widget">
							<img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/100-Guarantee.png">
							<h4 class="secondary-slider-title">Money back guarantee</h4>
							<span class="secondary-slider-text">We give your money back if ordered item(s) do not arrive within 1 month after order</span>
						</div>
					</div>
					<div class="widget_text secondary-slider-div panel-widget-style panel-widget-style-for-1133-1-0-0">
						<div class="textwidget custom-html-widget">
							<img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/SSL-Paypal.png">
							<h4 class="secondary-slider-title">100% secure payment</h4>
							<span class="secondary-slider-text">Buy with confidence using the world's most popular and secure payment methods</span>
						</div>
					</div>
				</div>
        <?php
    }
}

// checkout page
add_action( 'woocommerce_after_checkout_form', 'custom_template_payment_terms', 11);
if (! function_exists( 'custom_template_payment_terms' )) {
    /**
     * Display the footer widget regions.
     *
     * @since  1.0.0
     * @return void
     */

    function custom_template_payment_terms()
    {        
        include('checkout-page-custom.php');
    }
}