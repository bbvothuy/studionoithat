<div id="addressFormWrapper">
	<div class="page-header">
		<button id="addAddress" type="button" class="input-xs pull-right"> Đổi thông tin<?php //echo lang('add_address');?></button>
		<h3>Thông tin giao hàng<?php //echo lang('your_addresses');?></h3>
	</div>
</div>
<?php if(count($addresses) > 0):$id = 0;?>
<div id="addressError" class="alert red hide"></div>
<div class="col-nest">
    <div class="col" data-cols="1">
        <table class="table horizontal-border">
            <tbody>

                <?php foreach($addresses as $a):$id = $a['id'];?>
                    <tr>
						<!--
                        <td>
                            <?php echo format_address($a, true); ?>
                        </td>
						-->
						<td style="border-top:none">
							<div>
								<label>Tên: </label>
								<?php echo $a['firstname']; ?>
							</div>
							<div>
								<label>Phone: </label>
								<?php echo $a['phone']; ?>
							</div>
							<div>
								<label>Email: </label>
								<?php echo $a['email']; ?>
							</div>
							<div>
								<label>Địa chỉ: </label>
								<p><?php echo $a['address1']; ?></p>
								<p>Phường/Xã: <?php echo $a['ward_name']; ?></p>
								<p>Quận/Huyện: <?php echo $a['district_name']; ?></p>
								<p>TP/Tỉnh: <?php echo $a['city_name']; ?></p>
							</div>
                        </td>
                        <td style="border-top:none" class="hide">
                            <label><?php
                                $checked = (GC::getCart()->billing_address_id == $a['id'])?true:false;
                                echo form_radio(['name'=>'billing_address', 'value'=>$a['id'], 'checked'=>$checked]);
                            ?><?php echo lang('billing');?></label>
                        </td>
                        <td style="border-top:none" class="hide">
                            <label><?php
                                $checked = (GC::getCart()->shipping_address_id == $a['id'])?true:false;
                                echo form_radio(['name'=>'shipping_address', 'value'=>$a['id'], 'checked'=>$checked]);
                            ?>
                            <?php echo lang('shipping');?></label>
                        </td>
                        <td style="border-top:none">
                            <i class="icon-pencil" onclick="editAddress(<?php echo $a['id'];?>)"></i>
                            <i class="icon-x text-red" onclick="deleteAddress(<?php echo $a['id'];?>)"></i>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<?php else:?>

<script>
//$('.checkoutAddress').spin();
$('.checkoutAddress').load('<?php echo site_url('addresses/form');?>');
getCartSummary();
</script>

<?php endif;?>

<script>
function editAddress(id)
{
    //$('.checkoutAddress').spin();
    $('.checkoutAddress').load('<?php echo site_url('addresses/form');?>/'+id);
}

function deleteAddress(id)
{
    if( confirm('<?php echo lang('delete_address_confirmation');?>') )
    {
        $.post('<?php echo site_url('addresses/delete');?>/'+id, function(){
            closeAddressForm();
        });
    }
}

$('#addAddress').click(function(){
    //$('.checkoutAddress').spin();
    $('.checkoutAddress').load('<?php echo site_url('addresses/form/'.$id);?>');
})

$('[name="billing_address"]').change(function(){
    //$('#billingAddress').spin();
    $.post('<?php echo site_url('checkout/address');?>', {'type':'billing', 'id':$(this).val()}, function(data){
        if(data.error != undefined)
        {
            alert(data.error);
            closeAddressForm();
        }
        else
        {
            getCartSummary();
        }
        //$('#billingAddress').spin(false);
    });
});

$('[name="shipping_address"]').change(function(){
    //$('#shipingAddress').spin();
    $.post('<?php echo site_url('checkout/address');?>', {'type':'shipping', 'id':$(this).val()}, function(data){
        if(data.error != undefined)
        {
            alert(data.error);
            closeAddressForm();
        }
        else
        {
            getCartSummary();
        }
        //$('#shipingAddress').spin(false);
    });
});

var billingAddresses = $('[name="billing_address"]');
var shippingAddresses = $('[name="shipping_address"]');

if(billingAddresses.length == 1)
{
    billingAddresses.attr('checked', true).change();
}

if(shippingAddresses.length == 1)
{
    shippingAddresses.attr('checked', true).change();
}
</script>
