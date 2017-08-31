jQuery(document).ready(function( $ ){
  if (jQuery('body').hasClass('home')) {
    customLandingPage();    
  }
  else if (jQuery('body').hasClass('single-product')) {
    customProductPage();    
  }
  else if (jQuery('body').hasClass('woocommerce-checkout')) {
    customCheckoutPage();
  }
  customFooter();
});
let currency = jQuery('.entry-summary .price .amount').text()[0];

function customLandingPage() {
  hidePartialTopSlider();
  dropdownmenuOnHome();
  productSliderGridLayout();
  addSaleSpanToProductSlider();  
}

function customProductPage() {
  let sale_price, regular_price;
  jQuery('.single-product').removeClass('right-sidebar');
  convertDropdownToRadio();
  rewriteCartForm();
  rearrangeTabs();
  formatReviewTab();

  if (jQuery('.entry-summary .price del .amount').length != 0) {
    // jQuery('.shipping-cs-tag').before('<span class="save-cs-tag"><span>You save:</span></span>');
    jQuery('.entry-summary .price del>span').before('<span class="list-price-cs-tag">List Price:</span>');
    jQuery('.entry-summary .price ins>span').before('<span class="price-cs-tag">Price:</span>');

    regular_price = parseFloat(jQuery('.entry-summary .price del .amount').text().slice(1));
    sale_price = parseFloat(jQuery('.entry-summary .price ins .amount').text().slice(1));
    countDiscount(regular_price, sale_price);
    setTotalPrice(sale_price, 1); 
    handleQuantityCart(sale_price);
  }
  else {
    jQuery('.entry-summary .price').css('flex-direction','row');    
    jQuery('.entry-summary .price>span:nth-child(1)').before('<span class="price-cs-tag">Price:</span>');
    jQuery('.select2OptionPicker a').on('click', function() {
      regular_price = parseFloat(jQuery('.entry-summary .price del .amount').text().slice(1));
      sale_price = parseFloat(jQuery('.entry-summary .price ins .amount').text().slice(1));
      jQuery('.woocommerce-variation-price .price').remove();
      if (isNaN(regular_price)) { regular_price = 0 }
      if (isNaN(sale_price)) { sale_price = 0 }
      countDiscount(regular_price, sale_price);
      setTotalPrice(sale_price, parseInt(jQuery('.quantity input').val())); 
      handleQuantityCart(sale_price);
      // console.log('has been executed');
    });
  }
}

function customCheckoutPage() {
  jQuery('.woocommerce-checkout #main>div').addClass('col-xs-12 col-sm-9').after(jQuery('#payment-terms'));
  jQuery('.woocommerce-checkout #main').addClass('row');
}

function formatReviewTab() {
  jQuery('.tabs-header-cs .woocommerce-Reviews-title span').remove();
  if (jQuery('.tabs-header-cs .woocommerce-Reviews-title').text().match(/\d+/g) != null) {
    countReviews = parseInt(jQuery('.tabs-header-cs .woocommerce-Reviews-title').text().match(/\d+/g)[0]);
  }
  else {
    countReviews = 0;
  }
  jQuery('.tabs-header-cs .woocommerce-Reviews-title').text('Reviews (' + countReviews + ')');
  jQuery('#reviews .comment-form-comment textarea').attr('placeholder','Your review');
  jQuery('#reviews .comment-form-author input').attr('placeholder','Name');
  jQuery('#reviews .comment-form-email input').attr('placeholder','Email');
}

function rearrangeTabs() {
  jQuery('#tab-description >:not(h2)').wrapAll('<div class="tabs-body-cs">');
  jQuery('#tab-additional_information >:not(h2)').wrapAll('<div class="tabs-body-cs">');
  jQuery('.woocommerce-Tabs-panel h2').wrap('<div class="tabs-header-cs">');
  jQuery('#tab-reviews').after(jQuery('#tab-shipping-delivery'));
  jQuery('#tab-title-reviews').after(jQuery('#tab-title-shipping-delivery'));
}

function customFooter() {
  jQuery('.site-info').append(jQuery('.content-copyright'));
  jQuery('.site-info').append(jQuery('.footer-social-media'));
}

function initQuantityCart() {
  jQuery('.quantity input').before('<span class="quantity-cs-tag">Quantity:</span>');
}

function handleQuantityCart(sale_price) {
  jQuery('.plus-qty-btn').remove();
  jQuery('.minus-qty-btn').remove();
  if (sale_price == 0) {
    jQuery('.quantity input').off();
  }
  else {
    jQuery('.quantity input')
      .change(function(e){    
        setTotalPrice(sale_price, e.target.value); 
      })
      .after(`<button type="button" class="plus-qty-btn button" onclick="addQuantityCart(` + sale_price + `)">
                <span class="glyphicon glyphicon-plus"></span>
              </button>`)  	
      .before(`<button type="button" class="minus-qty-btn button" onclick="minusQuantityCart(` + sale_price + `)">
                <span class="glyphicon glyphicon-minus"></span>
              </button>`);
  }  
}

function addQuantityCart(sale_price) {
  let quantity = parseInt(jQuery('.quantity input').val());
  setTotalPrice(sale_price, quantity + 1);
  setQuantityInput(quantity + 1)
}

function minusQuantityCart(sale_price) {
  let quantity = parseInt(jQuery('.quantity input').val());
  if (quantity == 0){ return; }
  setTotalPrice(sale_price, quantity - 1);
  setQuantityInput(quantity - 1)
}

function rewriteCartForm() {
  let toMove = jQuery('.variations_form');
  jQuery('.variations_form').children().unwrap();  
  jQuery('.entry-summary').wrapInner('<div class="entry-summary-left col-xs-12 col-sm-8">');
  jQuery('.entry-summary').wrapInner(toMove);
  jQuery('.entry-summary-left').after('<div class="entry-summary-right col-xs-12 col-sm-4">');
  jQuery('.entry-summary-right').append(jQuery('.single_variation_wrap'));
  jQuery('.single_variation_wrap')
  	.before(`<div class="total-price-cs-div">
              <span class="total-price-cs-tag">Total Price</span>
              <span class="total-price-cs-amount">` + currency + `0</span>
              <img class="best-price-cs-tag" src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/Best-Price-Guarantee.png"/>
			</div>`)
    .after(`<ul class="payment-desc-cs-tag">
              <li><span class="glyphicon glyphicon-globe"></span><strong>Free</strong> Worldwide Shipping</li>
              <li><span class="glyphicon glyphicon-check"></span><strong>100%</strong> Money Back Guarantee</li>
              <li><span class="glyphicon glyphicon-lock"></span><strong>100%</strong> Secure Payments</li>
            </ul>`);
  initQuantityCart();
  jQuery('.single-product .woocommerce-product-gallery, .single-product .summary').wrapAll('<div class="row">')
}

function countDiscount(regular_price, sale_price) {  
  let price = regular_price - sale_price;
  if (price == 0) {
    percentage = 0;
  }
  else {
    price = (price - 0.005).toFixed(2);
    percentage = (price / regular_price * 100).toPrecision(2);
  }
  jQuery('.discounted-price').remove();
  jQuery('.save-cs-tag>span')
    .after('<span class="discounted-price">' + currency + price + ' (' + percentage + '%)</span>');
}

function setTotalPrice(sale_price, amount) {
  let total_price = sale_price * amount;
  jQuery('.total-price-cs-amount').text(currency + total_price)
}

function setQuantityInput(amount) {
  jQuery('.quantity input').val(amount);
}

function convertDropdownToRadio() {
  jQuery('#color').select2OptionPicker();
}

function addSaleSpanToProductSlider() {
  jQuery('.product-slider-div li>a').after( "<span class='product-slider-sale'>sale!</span>" );
}

function productSliderGridLayout() {
  jQuery('.product-slider-div li').addClass('col-sm-3 col-xs-12');
}

function hidePartialTopSlider() {
  jQuery('#top-slide>div:nth-child(1), .b-topImg>div:nth-child(2)').addClass('hidden-xs hidden-sm');
}

function dropdownmenuOnHome() {
  jQuery('#slide-menu .menu-item-has-children').addClass('dropdown');
  jQuery('#slide-menu .sub-menu').addClass('dropdown-menu').addClass('dropdown-menu-right');
  jQuery('.dropdown').hover(function(){
    jQuery(this).addClass('open');
    }, function(){
    jQuery(this).removeClass('open');
  });
}
