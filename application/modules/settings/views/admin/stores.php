<?php pageHeader(lang('stores')); ?>
<script type="text/javascript">
function areyousure()
{
    return confirm('Do you want to delete this store?');
}
</script>
<style type="text/css">
    .pagination {
        margin:0px;
        margin-top:-3px;
    }
</style>
	<div class="text-right form-group">
		<a class="btn btn-primary" style="font-weight:normal;" href="/admin/settings/form_store"><i class="icon-plus"></i> New Store</a>
	</div>

    <table class="table table-striped">
        <thead>
            <thead>
            <tr>
                <th>#</th>
				<th>Name</th>
				<th>Domain</th>
				<th>Theme</th>
				<th>Status</th>
				<th style="width:16%"></th>
            </tr>
        </thead>
        </thead>
        <tbody>
        <?php echo (count($stores) < 1)?'<tr><td style="text-align:center;" colspan="7">There are currently no stores.</td></tr>':''?>
    <?php $index = 0;foreach ($stores as $store): $index++;?>
            <tr>
                <td><?php echo $index;?></td>
                <td><?php echo $store->store_name;?></td>
                <td><?php echo $store->domain;?></td>
                <td><?php echo $store->theme;?></td>
				<td><?php echo $store->status?"Active":"Deleted";?></td>
                <td class="text-right">
                    <div class="btn-group">
                        <a class="btn btn-default" href="<?php echo site_url('admin/settings/form_store/'.$store->id);?>" alt="<?php echo lang('edit');?>"><i class="icon-pencil"></i></a>                        
                        <a class="btn btn-danger" href="<?php echo site_url('admin/settings/delete_store/'.$store->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>"><i class="icon-times "></i></a>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
