<?php

$m	= Array(
lang('january')
,lang('february')
,lang('march')
,lang('april')
,lang('may')
,lang('june')
,lang('july')
,lang('august')
,lang('september')
,lang('october')
,lang('november')
,lang('december')
);
?>

<table class="table table-striped hide">
	<thead>
		<tr>
			<th><?php echo $year;?></th>
			<th><?php echo lang('coupon_discounts');?></th>
			<th><?php echo lang('gift_card_discounts');?></th>
			<th><?php echo lang('products');?></th>
			<th><?php echo lang('shipping');?></th>
			<!--<th><?php echo lang('tax');?></th>-->
			<th><?php echo lang('grand_total');?></th>
		</tr>
	</thead>
	<tbody>
		<?php

		//$fields = ['couponDiscounts', 'giftCardDiscounts', 'products', 'shipping', 'tax'];
		$fields = ['couponDiscounts', 'giftCardDiscounts', 'products', 'shipping','cost_products'];
		$total_money = array();	
		$max_value = 100;
		for($i=1; $i<=12; $i++):
		?>
		<tr>
			<th><?php echo $m[$i-1];?></th>
			<?php
				$total = 0;
				foreach($fields as $field)
				{
					echo '<td>';
					if(isset($orders[$field][$i]))
					{
						//$orders[$field][$i] = $orders[$field][$i] * 10;
						if($field == 'couponDiscounts' || $field == 'giftCardDiscounts')
						{
							echo format_currency( (abs($orders[$field][$i])*-1) );
							$total = $total - abs($orders[$field][$i]);
						}
						else
						{
							echo format_currency($orders[$field][$i]);
							$total = $total + $orders[$field][$i];
						}
						//$bcdiv = bcdiv($orders[$field][$i], '1000000', 3);
						$bcdiv = round($orders[$field][$i] / 1000000, 3);
						
						if($bcdiv > $max_value){
							$max_value = $bcdiv;
						}
						if($field !='cost_products'){
							$total_money[$field][$i-1] = $bcdiv;
						}else{
							$total_money[$field][$i-1] = $orders[$field][$i];
						}
					}
					else
					{
						echo format_currency(0);
						$total_money[$field][$i-1] = 0;
					}
					echo '</td>';
				}
				echo '<td>'.format_currency($total).'</td>';
			?>
		</tr>
		<?php endfor;?>
	</tbody>
</table>
<?php
	//$rate_usd = config_item('rate_usd');
	$rate_usd = 1; // the COST doesn't use USD
?>
<div id="chartContainer3" style="width: 100%; height: 400px;display: inline-block;"></div>
<script type="text/javascript">
		$(function () {
			//Better to construct options first and then pass it as a parameter
			var options = {
				title: {
					text: "Chart"
				},
				animationEnabled: true,
				axisY: {
					includeZero: false,
					maximum: <?php $max_value = (($max_value/100) + 1) * 100; echo $max_value;?>,
					valueFormatString: "",
					suffix: " Triệu"
				},
				axisX: {
					title: "Months"
				},
				toolTip: {
					shared: true,
					content: "<span style='\"'color: {color};'\"'><strong>{name}</strong></span> {y}"
				},

				data: [
				{
					type: "line",
					showInLegend: true,
					name: "Sales",
					dataPoints: [
					<?php foreach($total_money['products'] as $key=>$value) {echo '{ x: '.($key+1).', y: '.$value.' },';}?>
					]
				},
				{
					type: "line",
					name: "Profit",
					showInLegend: true,
					dataPoints: [
					<?php foreach($total_money['cost_products'] as $key=>$value) {
						$bcdiv = round($value*$rate_usd / 1000000, 3);
						$convert_to_vnd = $bcdiv;
						$profit = $total_money['products'][$key] - $convert_to_vnd;
						echo '{ x: '.($key+1).', y: '.$profit.' },';}
					?>
					]
				}
				]
			};
			$("#chartContainer3").CanvasJSChart(options);
		});
	</script>
