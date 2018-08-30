<link href="/themes/default/assets/css/gumbo/grid.css" type="text/css" rel="stylesheet" />
<link href="/themes/default/assets/css/gumbo/forms.css" type="text/css" rel="stylesheet" />
<style>
.cartSummary img{
	width:100%;
	max-width:200px;
}
.cartItem {
    padding: 15px;
    border-top: 3px solid #e0e0e0;
}
.cartSummaryTotals {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
    text-align: right;
	font-weight:bold;
}
.cartPromotions {
    padding: 15px;
    background-color: #fafafa;
    border-top: 1px solid #e0e0e0;
}
#addressFormWrapper .page-header{
	padding-bottom: 0;
    margin: 0;
}
#addressFormWrapper .page-header h3{
	margin-top: 0;
    margin-bottom: 10px;
}
</style>
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active">Thanh Toán</li>
            </ol>
        </div>
		<div class="col-nest">
			<div class="col" data-cols="1/2">

				<div class="checkoutAddress">
				<?php if(!empty($addresses))
				{
					$this->show('checkout/address_list', ['addresses'=>$addresses]);
				}
				else
				{
					?>
					<script>
						$('.checkoutAddress').load('<?php echo site_url('addresses/form');?>');
					</script>
					<?php //(new GoCart\Controller\Addresses)->form();
				}
				?>
				</div>

				<div id="shippingMethod hide"></div>
				<div id="paymentMethod hide"></div>

			</div>
			<div class="col" data-cols="1/2">
				<div id="orderSummary"></div>
			</div>
		</div>
	</div>
</div>
<script>
	<?php if(!empty($addresses)){?>
		var country_zone_id_current = '<?php echo $addresses[0]['city'];?>';
		var city_zone_id_current = '<?php echo $addresses[0]['zone_id'];?>';
		var ward_id_current = '<?php echo $addresses[0]['ward_id'];?>';
		$.post( "<?php echo site_url('cart/addShiping');?>", {country_zone_id: country_zone_id_current, city_zone_id: city_zone_id_current, ward_id: ward_id_current}, function( data ) {
			getCartSummary();
		}, "json");
	<?php }?>

    var grandTotalTest = <?php echo (GC::getGrandTotal() > 0)?1:0;?>;

    function closeAddressForm(){
        $('.checkoutAddress').load('<?php echo site_url('checkout/address-list');?>');
    }

    function processErrors(errors)
    {
        //scroll to the top
        $('body').scrollTop(0);

        $.each(errors, function(key,val) {

            if(key == 'inventory')
            {
                setInventoryErrors(val);
                $('#summaryErrors').text('<?php echo lang('some_items_are_out_of_stock');?>').show();
            }
            else if(key == 'shipping')
            {
                showShippingError(val);
            }
            else if(key == 'shippingAddress')
            {
                $('#addressError').text('<?php echo lang('error_shipping_address')?>').show();
            }
            else if(key == 'billingAddress')
            {
                $('#addressError').text('<?php echo lang('error_billing_address')?>').show();
            }
        });
    }

    $(document).ready(function(){
        //getBillingAddressForm();
        //getShippingAddressForm();
        //getShippingMethods();
        getCartSummary();
        getPaymentMethods();
    });

    function getCartSummary(callback)
    {
        //update shipping too
        getShippingMethods();

        //$('#orderSummary').spin();
        $.post('<?php echo site_url('cart/summary');?>', function(data) {
            $('#orderSummary').html(data);
            if(callback != undefined)
            {
                callback();
            }
        });
    }

    function getShippingMethods()
    {
        $('#shippingMethod').load('<?php echo site_url('checkout/shipping-methods');?>');
    }

    function getPaymentMethods()
    {
        $('#paymentMethod').load('<?php echo site_url('checkout/payment-methods');?>');
    }
</script>
