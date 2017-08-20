jQuery(document).ready(function( $ ){
  if (jQuery('body').hasClass('home')) {
    customLandingPage();    
  }
  else if (jQuery('body').hasClass('single-product')) {
    customProductPage();    
  }
});
let currency = jQuery('.entry-summary .price del .amount').text()[0];

function customLandingPage() {
  hidePartialTopSlider();
  dropdownmenuOnHome();
  productSliderGridLayout();
  addSaleSpanToProductSlider();  
}

function customProductPage() {
  let regular_price = parseFloat(jQuery('.entry-summary .price del .amount').text().slice(1));
  let sale_price = parseFloat(jQuery('.entry-summary .price ins .amount').text().slice(1));

  jQuery('.single-product').removeClass('right-sidebar');
  convertDropdownToRadio();
  rewriteCartForm();
  countDiscount(regular_price, sale_price);
  setTotalPrice(sale_price, 1); 
  handleQuantityCart(sale_price);
}

function handleQuantityCart(sale_price) {
  jQuery('.quantity input')
    .change(function(e){    
      setTotalPrice(sale_price, e.target.value); 
    })
    .after(`<button type="button" class="button" onclick="addQuantityCart(` + sale_price + `)">
              <span class="glyphicon glyphicon-plus"></span>
            </button>`)
  	.before('<span class="quantity-cs-tag">Quantity:</span>')
    .before(`<button type="button" class="button" onclick="minusQuantityCart(` + sale_price + `)">
              <span class="glyphicon glyphicon-minus"></span>
            </button>`);
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
  jQuery('.entry-summary .price del>span').before('<span class="list-price-cs-tag">List Price:</span>');
  jQuery('.entry-summary .price ins>span').before('<span class="price-cs-tag">Price:</span>');
  jQuery('.variations_form').children().unwrap();  
  jQuery('.entry-summary').wrapInner('<div class="entry-summary-left col-xs-12 col-sm-8">');
  jQuery('.entry-summary').wrapInner(toMove);
  jQuery('.entry-summary-left').after('<div class="entry-summary-right col-xs-12 col-sm-4">');
  jQuery('.entry-summary-right').append(jQuery('.single_variation_wrap'));
  jQuery('.single_variation_wrap')
  	.before(`<div class="total-price-cs-div">
              <span class="total-price-cs-tag">Total Price:</span>
              <span class="total-price-cs-amount"></span>
              <img class="best-price-cs-tag" src="https://www.travelerwishlist.com/wp-content/uploads/2017/08/Best-Price-Guarantee.png"/>
			</div>`)
    .after(`<ul class="payment-desc-cs-tag">
              <li><span class="glyphicon glyphicon-globe"></span><strong>Free</strong> Worldwide Shipping</li>
              <li><span class="glyphicon glyphicon-check"></span><strong>100%</strong> Money Back Guarantee</li>
              <li><span class="glyphicon glyphicon-lock"></span><strong>100%</strong> Secure Payments</li>
            </ul>`);
}

function countDiscount(regular_price, sale_price) {  
  let price = regular_price - sale_price;
  let percentage = price / regular_price * 100;
  jQuery('.save-cs-tag>span')
    .after('<span>' + currency + price + ' (' + percentage.toPrecision(2) + '%)</span>');
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
  jQuery('#top-slide>div:nth-child(1)').addClass('hidden-xs hidden-sm');
  jQuery('.b-topImg>div:nth-child(2)').addClass('hidden-xs hidden-sm');
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
