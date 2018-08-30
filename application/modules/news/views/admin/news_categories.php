<?php
/**
 * Created by PhpStorm.
 * User: Khang
 * Date: 9/10/2017
 * Time: 4:44 PM
 */?>

<?php echo pageHeader(lang('manage_category')); ?>
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete');?>');
    }
</script>
<div class="text-right">
    <a class="btn btn-primary" href="<?php echo site_url('admin/news/form'); ?>"><i class="icon-plus"></i> <?php echo lang('add_new_news');?></a>
    <a class="btn btn-primary" href="<?php echo site_url('admin/news/category/99999'); ?>"><i class="icon-plus"></i> <?php echo lang('add_new_category');?></a>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>
            <?php echo lang('title');?>
        </th>
        <th style="width: 150px">

        </th>
    </tr>
    </thead>

    <?php echo (count($categories) < 1)?'<tr><td style="text-align:center;" colspan="2">'.lang('no_news_or_links').'</td></tr>':''?>
    <?php if($categories):?>
        <tbody>

        <?php
        foreach ($categories as $news):?>
            <tr>
                <td><?php echo  $news->title; ?></td>
                <td class="text-right">
                    <div class="btn-group">
                        <a class="btn btn-default" href="<?php echo site_url('admin/news/category/'.$news->id); ?>"><i class="icon-pencil"></i></a>
                        <!--<a class="btn btn-default" href="<?php echo site_url('news/category/'.$news->slug); ?>" target="_blank"><i class="icon-eye"></i></a>-->
                        <a class="btn btn-danger" href="<?php echo site_url('admin/news/delete_category/'.$news->id); ?>" onclick="return areyousure();"><i class="icon-times"></i></a>
                    </div>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    <?php endif;?>
</table>