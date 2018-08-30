<table id="table-best-seller" class="table table-striped" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<?php /*<th>ID</th> uncomment this if you want it*/ ?>
			<th width="150px"><?php echo lang('sku');?></th>
			<th><?php echo lang('name');?></th>
			<th width="200px"><?php echo lang('quantity');?></th>
		</tr>
	</thead>
	<tbody>
		<?php $count_quantity = 0;foreach($best_sellers as $b): $count_quantity = $count_quantity + $b->quantity_sold;?>
		<tr>
			<?php /*<td style="width:16px;"><?php echo  $customer->id; ?></td >*/?>
			<td><?php echo  $b->sku; ?></td>
			<td><a href ="/<?php echo $b->slug;?>" target="_blank"><?php echo  $b->name; ?></a></td>
			<td><?php echo $b->quantity_sold; ?></a></td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td align="right"><b>Total quantity<b/></td>
			<td><b><?php echo $count_quantity;?></b></td>
		</tr>
	</tfoot>
</table>
  <script>
  $(function(){
    $("#table-best-seller").dataTable({
		"bPaginate": false,
		"aaSorting": []
	});	
  })
  </script>