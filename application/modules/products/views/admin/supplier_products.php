<?php pageHeader(lang('products')); ?>
<style>
    .form-control {
        padding: 6px 6px;
    }
    .price{
        text-align: right;
    }
</style>
<?php
//set "code" for searches
if(!empty($term)):
    $term = json_decode($term);
    if(!empty($term->term) || !empty($term->category_id)):?>
        <div class="alert alert-info">
            <?php echo sprintf(lang('search_returned'), intval($total));?>
        </div>
    <?php endif;?>
<?php endif;?>

<script type="text/javascript">
function areyousure()
{
    return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>
<style type="text/css">
    .pagination {
        margin:0px;
        margin-top:-3px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <?php echo CI::pagination()->create_links();?>  &nbsp;
            </div>
        </div>
    </div>
</div>

<?php echo form_open('admin/products/bulk_save', array('id'=>'bulk_form'));?>
<div class="text-right form-group">
    <a class="btn btn-primary" style="font-weight:normal;"href="<?php echo site_url('admin/products/form');?>"><i class="icon-plus"></i> <?php echo lang('add_new_product');?></a>
    <!--<a class="btn btn-primary" style="font-weight:normal;"href="<?php echo site_url('admin/products/gift-card-form');?>"><i class="icon-plus"></i> <?php echo lang('add_new_gift_card');?></a>-->
</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <?php
                    foreach(['name'] as $thead)
                    {
                        echo '<th>';

                        $uristring = 'admin/products/'.$rows.'/'.$thead.'/';
                        $icon = '';
                        if ($order_by == $thead)
                        {
                            if($sort_order == 'asc')
                            {
                                $uristring .= 'desc/';
                                $icon   = ' <i class="icon-sort-alt-up"></i>';
                            }
                            else
                            {
                                $uristring .= 'asc/';
                                $icon   = ' <i class="icon-sort-alt-down"></i>';
                            }
                        }
                        else
                        {
                            $uristring .='asc/';
                        }

                        echo '<a href="'.site_url($uristring.$code.'/'.$page).'">'.lang($thead).$icon.'</a></th>';
                    }
                ?>
                <th style="width:20%">Confirmed</th>
                <th style="width:20%">

                </th>
            </tr>
        </thead>
        <tbody>
        <?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="7">'.lang('no_products').'</td></tr>':''?>
    <?php foreach ($products as $product):?>
            <tr>
                <td><?php echo $product->name;?></td>
                <td>
                    <?php echo $product->confirm ? 'Yes' : 'No';?>
                </td>
                <td class="text-right">
                    <div class="btn-group">
                        <?php if($product->confirm == 1){?>
                            <a target="_blank" class="btn btn-default" href="/<?php echo $product->slug.'.html';?>" title="View"><i class="icon-link"></i></a>
                            <a class="btn btn-default" href="<?php echo site_url('admin/products/form/'.$product->id.'/1');?>" title="<?php echo lang('copy');?>"><i class="icon-copy"></i></a>
                        <?php }else{?>
                            <a class="btn btn-default" href="<?php echo ($product->is_giftcard) ? site_url('admin/products/gift-card-form/'.$product->id) : site_url('admin/products/form/'.$product->id);?>" alt="<?php echo lang('edit');?>"><i class="icon-pencil"></i></a>
                            <a class="btn btn-default" href="<?php echo site_url('admin/products/form/'.$product->id.'/1');?>" alt="<?php echo lang('copy');?>"><i class="icon-copy"></i></a>
                            <a class="btn btn-danger" href="<?php echo site_url('admin/products/delete/'.$product->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>"><i class="icon-times "></i></a>
                        <?php }?>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
</form>
