<?php
// taufiqelrahman.com edited

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
        if (is_user_logged_in()) :
            $current_user = wp_get_current_user();
        ?>
            <div class="current-user-email">
                <span><?php echo $current_user->user_email; ?></span>
            </div>
        <?php
        endif;
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
        global $product;
        ?>
        <div class="content-copyright text-center" itemprop="streetAddress">101 California Street, Suite 2710, San Francisco, Indonesia 94111</div>
        <div class="content-copyright text-center">www.travelerwishlist.com</div>
        <?php
    }
}

remove_action('storefront_footer', 'storefront_footer_widgets', 10);
add_action('storefront_footer', 'storefront_footer_widgets_custom', 10);
add_action('storefront_footer', 'storefront_footer_site_info', 21);


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
        global $product;
        ?>
        <li class="shipping-delivery_tab" id="tab-title-shipping-delivery" role="tab" aria-controls="tab-shipping-delivery">
            <a href="#tab-shipping-delivery">Shipping and Free Returns</a>
        </li>
        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab"
            id="tab-shipping-delivery" role="tabpanel" aria-labelledby="tab-title-reviews" style="display: block;">
            <div class="tabs-header-cs"><h2>Shipping and Delivery</h2></div>
            <div class="tabs-body-cs">
                <p>We offer international shipping services worldwide. Bringing our customers great value and service is the best thing we want to do. We will strive for the best to meet all the needs of all our dear customers anywhere in the world.</p>
                </br>

                <h4>How do you ship my packages?</h4>
                <p>All our packages deliver from our warehouse in China and will be shipped by ePacket or EMS depending on the weight and size of the product.</p>
                </br>
                
                <h4>Do you ship worldwide, and is it free?</h4>
                <p>Of course we are! We mostly provide free shipping to the most countries around the world.</p>
                </br>

                <h4>What about customs?</h4>
                <p>We are not responsible for any custom fees once the items have shipped. By purchasing our products, you consent that one or more packages may be shipped to you and may get custom fees when they arrive depends on your country.</p>
                </br>

                <h4>How long does shipping take?</h4>
                <p>Shipping time varies by location. Usually it takes around 10-30 days with the longest estimates takes up to 45 days (does not include out 2-5 days of processing time).</p>
                </br>

                <h4>Do you provide tracking information?</h4>
                <p>Unfortunately, up to this moment we do not provide tracking information. We plan to have tracking information on future.</p>
                </br>

                <h4>Will my items in the same purchase sent in same packages?</h4>
                <p>For logistical reasons, items in the same purchase will sometimes be sent in separate packages, even if you’ve specified combined shipping.</p>
                </br>
                <p>If you have any other questions, please contact us at travelerwishlist.com@gmail.com and we will do our best to help you out.</p>
            </div>
            <div class="tabs-header-cs"><h2>Refund & Return policy</h2></div>
            <div class="tabs-body-cs">
                <h4>Order cancellation</h4>
                <p>All orders can be cancelled until they are shipped. If your order has been paid and you need to make a change or cancel an order, you must contact us through travelerwishlist.com@gmail.com within 12 hours. Once the packaging and shipping process has started, it can no longer be cancelled.</p>
                </br>

                <h4>Refunds</h4>
                <p>Your satisfaction is our #1 priority. Therefore,  you can request a refund for faulty products.</p>
                <p>If you did not receive the product within the guaranteed time (45 days not including 2-5 day processing) you can request a refund or a reshipment. If you received the wrong item you can request a refund or a reshipment. If you do not want the product you’ve receive you may request a refund but you must return the item at your expense and the item must be unused.</p>
                </br>

                <h4>We do not issue the refund if:</h4>
                <ul>
                    <li>Your order did not arrive due to factors within your control (i.e. providing the wrong shipping address)</li>
                    <li>Your order did not arrive due to exceptional circumstances outside the control of Traveler Wishlist (i.e. not cleared by customs, delayed by a natural disaster).</li>
                    <li>Other exceptional circumstances outside the control of travelerwishlist.com</li>
                    <li>*You can submit refund requests within 7 days after the guaranteed period for delivery (45 days) has expired. You can do it by sending a message on Contact Us page.</li>
                </ul>
                </br>
                
                <p>If you are approved for a refund, then your refund will be processed, and a credit will automatically be applied to your credit card or original method of payment, within 14 days.</p>
            </div>
        </div>
        <?php
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
        global $product;
        ?>
        <div id="payment-terms" class="col-xs-12 col-sm-3">
            <div class="b-sidebar_checkout b-sidebar_checkout-confidence">
                <div class="b-sidebar_checkout-confidence__inner">
                    <h4 class="b-sidebar_checkout-confidence__head">SHOP WITH CONFIDENCE</h4>

                    <div class="b-sidebar_checkout-confidence__top">
                        <div class="b-sidebar_checkout-confidence__top__img">
                            <img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/confidence_lock.png" alt="">
                        </div>
                        <div class="b-sidebar_checkout-confidence__top__text">
                            <span>SHOPPING ON</span>
                            <br> www.travelerwishlist.com IS SAFE AND SECURE. GUARANTEED! </div>
                    </div>

                    <div class="b-sidebar_checkout-confidence__text">You'll pay nothing if unauthorized charges are made to your credit card as a result of shopping at www.travelerwishlist.com </div>

                    <h5>SAFE SHOPPING GUARANTEE</h5>
                    <div class="checkout-guarantee">
                        <img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/SSL.png" alt="">
                        <img src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/Paypal.png" alt="">
                        <!--<img src="//worldofharry.com/wp-content/themes/davinci/img/trust/truste.svg?1000" alt="">-->
                    </div>

                    <div class="b-sidebar_checkout-confidence__text">
                        All information is encrypted and transmitted without risk using a Secure Sockets Layer (SSL) protocol. </div>
                </div>

            </div>
            <div class="b-sidebar_checkout b-sidebar_checkout-privacy_policy">
                <div class="b-sidebar_checkout-privacy_policy__inner">
                    <h4 class="b-sidebar_checkout-privacy_policy__head">PRIVACY POLICY </h4>

                    <div class="b-sidebar_checkout-privacy_policy__text">
                        www.travelerwishlist.com respects your privacy. We don't rent or sell your personal information to anyone. </div>
                    <a href="https://www.travelerwishlist.com/privacy-policy/">Read our Privacy Policy »</a>
                </div>

            </div>
            <div class="b-sidebar_checkout b-sidebar_checkout-buyer_protection">
                <div class="b-sidebar_checkout-buyer_protection__inner">
                    <h4 class="b-sidebar_checkout-buyer_protection__head">
                    <i class="icon"></i>Buyer Protection</h4>
                    <ul>
                        <li>
                            <b>Full Refund</b> if you don't receive your order </li>
                        <li>
                            <b>Refund or Keep</b> items not as described </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
}