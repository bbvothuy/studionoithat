<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>
<style>
    .bill-order{
        text-align: center;
        text-transform: uppercase;
        font-size: 22px;
        color:#e91f6b
    }
    p{
        margin: 3px 0px;
        font-size: 12px;
    }
	h2{margin:5px}
</style>
<body>

<?php
$charges['products'] = [];
$charges['shipping'] = [];

foreach ($order->items as $item)
{
    if($item->type == 'shipping')
    {
        $charges['shipping'][] = $item;
        continue;
    }
    elseif($item->type == 'product')
    {
        $charges['products'][] = $item;
    }elseif($item->type == 'tax'){
            $charges['tax'][] = $item;
    }
}
?>

<div style="font-size:12px; font-family:arial, verdana, sans-serif;min-height:475px;">
    <table style="border:0px solid #000; width:100%; font-size:13px;" cellpadding="5" cellspacing="0">
        <tr>
            <td style="width:20%; vertical-align:top;">
                <img src="/themes/default/assets/images/logo.png" alt="">
            </td>
            <td style="width:80%; vertical-align:top;" class="packing">
                <p style="padding: 0px; margin:0px"><?php echo lang('company_name_studionoithat');?></p>
                <p style="margin: 3px 0px;"><?php echo lang('address_studionoithat');?></p>
                <p style="margin: 3px 0px;"><?php echo lang('phone_studionoithat');?></p>
            </td>
        </tr>
    </table>

    <h2 class="bill-order"><?php echo lang('bill_order');?></h2>

    <table style="border:1px solid; width:100%; font-size:12px;" cellpadding="5" cellspacing="0">
        <tr>
            <td style="width:17%; vertical-align:top;" class="packing">
                <p>
                    <strong><?php echo lang('customer_name');?>:</strong>
                </p>
                <p>
                    <strong><?php echo lang('ship_to_address');?>:</strong>
                </p>
                <p>
                    <strong><?php echo lang('delivery_name');?>:</strong>
                </p>
            </td>
            <td style="width:51%; vertical-align:top;" class="packing">
                <p>
                    <?php echo $order->shipping_firstname.' - '.$order->shipping_phone;?>
                </p>
                <p>
                    <?php echo $order->shipping_address1.', '.$order->ward_name.', '.$order->district_name.', '.$order->city_name;?>
                </p>
            </td>
            <td style="width:32%; vertical-align:top; border-left:1px solid" class="packing">
                <p>
                    <strong><?php echo lang('order_number');?>:</strong> <?php echo $order->invoice_number;?>
                </p>
                <p>
                    <strong><?php echo lang('order_date');?>: </strong><?php echo date('d/m/Y', strtotime($order->ordered_on));?>
                </p>
                <p>
                    <strong><?php echo lang('print_date');?>:</strong> <?php echo date('d/m/Y H:i');?>
                </p>
            </td>
        </tr>

        <?php if(!empty($order->gift_message)):?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('gift_note');?></strong>
                    <?php echo $order->gift_message;?>
                </td>
            </tr>
        <?php endif;?>

        <?php if(!empty($order->shipping_notes)):?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $order->shipping_notes;?>
                </td>
            </tr>
        <?php endif;?>
    </table>

    <table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
        <thead>
        <tr style="background-color: #faebd7;">
            <th width="5%" class="packing">
                #
            </th>
            <th width="7%" class="packing">
                SKU
            </th>
            <th class="packing">
                <?php echo lang('product_name');?>
            </th>
            <th width="5%" class="packing">
                <?php echo lang('unit_text');?>
            </th>
            <th width="6.1%" class="packing">
                <?php echo lang('qty_short_name');?>
            </th>
            <th width="13%" class="packing">
                <?php echo lang('product_price');?>
            </th>
            <th width="13%" class="packing">
                <?php echo lang('total_price');?>
            </th>
            <!--
            <th class="packing" >
                <?php echo lang('description');?>
            </th>
            -->
        </tr>
        </thead>
        <tbody>
        <?php $total_quantity = 0; $count = 1; foreach($charges['products'] as $product): $total_quantity = $total_quantity + $product->quantity;?>
            <tr>
                <td style="text-align:center;"><?php echo $count++;?></td>
                <td style="text-align:center;"><?php echo $product->sku;?></td>
                <td>
                    <?php echo $product->name;?>
                </td>
                <td style="text-align:center;"><?php echo lang('unit');?></td>
                <td style="text-align:center;"><?php echo $product->quantity;?></td>
                <td style="text-align:center;"><?php echo format_currency($product->total_price);?></td>
                <td style="text-align:center;"><?php echo format_currency( ($product->total_price * $product->quantity) - ($product->coupon_discount * $product->coupon_discount_quantity) );?></td>
                <!--
                <td>
                    <?php if(isset($order->options[$product->id])):
                        foreach($order->options[$product->id] as $option):?>
                            <div><strong><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?></strong> : <?php echo $option->value;?></div>
                        <?php endforeach;
                    endif;?>
                </td>
                -->
            </tr>
        <?php endforeach; ?>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center;" colspan="4"><b><?php echo lang('total_price_product');?></b></td>
            <td style="text-align:center;"><b><?php echo $total_quantity;?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"><b><?php echo format_currency($order->subtotal);?></b></td>
            <!--
                <td>
                    <?php if(isset($order->options[$product->id])):
                foreach($order->options[$product->id] as $option):?>
                            <div><strong><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?></strong> : <?php echo $option->value;?></div>
                        <?php endforeach;
            endif;?>
                </td>
                -->
        </tr>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center;" colspan="4"><b><?php echo lang('ship_cost');?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <?php $tmp = 0; foreach($charges['shipping'] as $shipping):
                $tmp = $tmp + $shipping->total_price;
             endforeach;?>
            <td style="text-align:center;"><b><?php echo format_currency($tmp); ?></b></td>
        </tr>
        <?php 
			$tmp = 0;
			if(isset($charges['tax'])){
				foreach($charges['tax'] as $tax):
					$tmp = $tmp + $tax->total_price;
				endforeach;
			}
		?>
        <?php if($tmp > 0){?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center;" colspan="4"><b>VAT</b></td>
                <td></td>
                <td></td>
                <td style="text-align:center;"><b><?php echo format_currency($tmp); ?></b></td>
            </tr>
        <?php }?>
		<?php if($order->decrease > 0){?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center;" colspan="4"><b>Giảm Giá</b></td>
                <td></td>
                <td></td>
                <td style="text-align:center; color:red"><b>- <?php echo format_currency($order->decrease); ?></b></td>
            </tr>
        <?php }?>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center; color: red;" colspan="4"><b><?php echo lang('total_pay');?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center; color: red"><b><?php echo format_currency($order->total - $order->decrease);?></b></td>
        </tr>
        </tbody>
    </table>
    <?php if($order->notes_customer !=''){?>
        <div style=" padding: 15px 0px 0px 0px">
            <b><?php echo lang('note_customer');?>:</b> <?php echo $order->notes_customer;?>
        </div>
    <?php }?>
    <table style="border:0px solid #000; width:100%; font-size:13px; margin-top:10px; margin-right: 20px" cellpadding="5" cellspacing="0";>
        <tr>
            <td colspan="2" style="vertical-align:top; text-align: right">
                <i><?php echo lang('delivery_date');?></i>
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                <b><?php echo lang('receive_name');?></b><br>
                <i><?php echo lang('signature_name');?></i>
            </td>
            <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                <b><?php echo lang('delivery_name');?></b><br>
                <i><?php echo lang('signature_name');?></i>
            </td>
        </tr>
    </table>

</div>
<?php if(count($charges['products']) < 4){?>
<div style="font-size:12px; font-family:arial, verdana, sans-serif; min-height:450px; margin-top:20px">
    <table style="border:0px solid #000; width:100%; font-size:13px;" cellpadding="5" cellspacing="0">
        <tr>
            <td style="width:20%; vertical-align:top;">
                <img src="/themes/default/assets/images/logo.png" alt="">
            </td>
            <td style="width:80%; vertical-align:top;" class="packing">
                <p style="padding: 0px; margin:0px"><?php echo lang('company_name_studionoithat');?></p>
                <p style="margin: 3px 0px;"><?php echo lang('address_studionoithat');?></p>
                <p style="margin: 3px 0px;"><?php echo lang('phone_studionoithat');?></p>
            </td>
        </tr>
    </table>

    <h2 class="bill-order"><?php echo lang('bill_order');?></h2>
	
    <table style="border:1px solid; width:100%; font-size:12px;" cellpadding="5" cellspacing="0">
        <tr>
            <td style="width:17%; vertical-align:top;" class="packing">
                <p>
                    <strong><?php echo lang('customer_name');?>:</strong>
                </p>
                <p>
                    <strong><?php echo lang('ship_to_address');?>:</strong>
                </p>
                <p>
                    <strong><?php echo lang('delivery_name');?>:</strong>
                </p>
            </td>
            <td style="width:51%; vertical-align:top;" class="packing">
                <p>
                    <?php echo $order->shipping_firstname.' - '.$order->shipping_phone;?>
                </p>
                <p>
                    <?php echo $order->shipping_address1.', '.$order->ward_name.', '.$order->district_name.', '.$order->city_name;?>
                </p>
            </td>
            <td style="width:32%; vertical-align:top; border-left:1px solid" class="packing">
                <p>
                    <strong><?php echo lang('order_number');?>:</strong> <?php echo $order->id;?>
                </p>
                <p>
                    <strong><?php echo lang('order_date');?>: </strong><?php echo date('d/m/Y', strtotime($order->ordered_on));?>
                </p>
                <p>
                    <strong><?php echo lang('print_date');?>:</strong> <?php echo date('d/m/Y H:i');?>
                </p>
            </td>
        </tr>

        <?php if(!empty($order->gift_message)):?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('gift_note');?></strong>
                    <?php echo $order->gift_message;?>
                </td>
            </tr>
        <?php endif;?>

        <?php if(!empty($order->shipping_notes)):?>
            <tr>
                <td colspan="3" style="border-top:1px solid #000;">
                    <strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $order->shipping_notes;?>
                </td>
            </tr>
        <?php endif;?>
    </table>

    <table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
        <thead>
        <tr style="background-color: #faebd7;">
            <th width="5%" class="packing">
                #
            </th>
            <th width="7%" class="packing">
                SKU
            </th>
            <th class="packing">
                <?php echo lang('product_name');?>
            </th>
            <th width="5%" class="packing">
                <?php echo lang('unit_text');?>
            </th>
            <th width="6.1%" class="packing">
                <?php echo lang('qty_short_name');?>
            </th>
            <th width="13%" class="packing">
                <?php echo lang('product_price');?>
            </th>
            <th width="13%" class="packing">
                <?php echo lang('total_price');?>
            </th>
            <!--
            <th class="packing" >
                <?php echo lang('description');?>
            </th>
            -->
        </tr>
        </thead>
        <tbody>
        <?php $total_quantity = 0;$count = 1; foreach($charges['products'] as $product): $total_quantity = $total_quantity + $product->quantity;?>
            <tr>
                <td style="text-align:center;"><?php echo $count++;?></td>
                <td style="text-align:center;"><?php echo $product->sku;?></td>
                <td>
                    <?php echo $product->name;?>
                </td>
                <td style="text-align:center;"><?php echo lang('unit');?></td>
                <td style="text-align:center;"><?php echo $product->quantity;?></td>
                <td style="text-align:center;"><?php echo format_currency($product->total_price);?></td>
                <td style="text-align:center;"><?php echo format_currency( ($product->total_price * $product->quantity) - ($product->coupon_discount * $product->coupon_discount_quantity) );?></td>
                <!--
                <td>
                    <?php if(isset($order->options[$product->id])):
                        foreach($order->options[$product->id] as $option):?>
                            <div><strong><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?></strong> : <?php echo $option->value;?></div>
                        <?php endforeach;
                    endif;?>
                </td>
                -->
            </tr>
        <?php endforeach; ?>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center;" colspan="4"><b><?php echo lang('total_price_product');?></b></td>
            <td style="text-align:center;"><b><?php echo $total_quantity;?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"><b><?php echo format_currency($order->subtotal);?></b></td>
            <!--
                <td>
                    <?php if(isset($order->options[$product->id])):
                foreach($order->options[$product->id] as $option):?>
                            <div><strong><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->option_name) : $option->option_name;?></strong> : <?php echo $option->value;?></div>
                        <?php endforeach;
            endif;?>
                </td>
                -->
        </tr>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center;" colspan="4"><b><?php echo lang('ship_cost');?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <?php $tmp = 0; foreach($charges['shipping'] as $shipping):
                $tmp = $tmp + $shipping->total_price;
             endforeach;?>
            <td style="text-align:center;"><b><?php echo format_currency($tmp); ?></b></td>
        </tr>
        <?php 
			$tmp = 0;
			if(isset($charges['tax'])){
				foreach($charges['tax'] as $tax):
					$tmp = $tmp + $tax->total_price;
				endforeach;
			}
		?>
        <?php if($tmp > 0){?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center;" colspan="4"><b>VAT</b></td>
                <td></td>
                <td></td>
                <td style="text-align:center;"><b><?php echo format_currency($tmp); ?></b></td>
            </tr>
        <?php }?>
		<?php if($order->decrease > 0){?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center;" colspan="4"><b>Giảm Giá</b></td>
                <td></td>
                <td></td>
                <td style="text-align:center; color:red"><b>- <?php echo format_currency($order->decrease); ?></b></td>
            </tr>
        <?php }?>
        <tr style="background-color: #faebd7;">
            <td style="text-align:center; color: red;" colspan="4"><b><?php echo lang('total_pay');?></b></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center; color: red"><b><?php echo format_currency($order->total - $order->decrease);?></b></td>
        </tr>
        </tbody>
    </table>
    <?php if($order->notes_customer !=''){?>
        <div style=" padding: 15px 0px 0px 0px">
            <b><?php echo lang('note_customer');?>:</b> <?php echo $order->notes_customer;?>
        </div>
    <?php }?>
    <table style="border:0px solid #000; width:100%; font-size:13px; margin-top:10px; margin-right: 20px" cellpadding="5" cellspacing="0";>
        <tr>
            <td colspan="2" style="vertical-align:top; text-align: right">
                <i><?php echo lang('delivery_date');?></i>
            </td>
        </tr>
        <tr>
            <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                <b><?php echo lang('receive_name');?></b><br>
                <i><?php echo lang('signature_name');?></i>
            </td>
            <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                <b><?php echo lang('delivery_name');?></b><br>
                <i><?php echo lang('signature_name');?></i>
            </td>
        </tr>
    </table>

</div>
<?php }?>

</body>
</html>
