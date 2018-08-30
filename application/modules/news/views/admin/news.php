<?php echo pageHeader(lang('news')); ?>
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete');?>');
    }
</script>
<div class="text-right">
    <a class="btn btn-primary" href="<?php echo site_url('admin/news/form'); ?>"><i class="icon-plus"></i> <?php echo lang('add_new_news');?></a>
    <a class="btn btn-primary" href="<?php echo site_url('admin/news/category/0'); ?>"><i class="icon-plus"></i> <?php echo lang('manage_category');?></a>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th><?php echo lang('title');?></th>
        <th/>
    </tr>
    </thead>

    <?php echo (count($news) < 1)?'<tr><td style="text-align:center;" colspan="2">'.lang('no_news_or_links').'</td></tr>':''?>
    <?php if($news):?>
        <tbody>
        <?php
        foreach ($news as $item):?>
            <tr>
                <td><?php echo  $item->title; ?></td>
                <td class="text-right">
                    <div class="btn-group">
                        <a class="btn btn-default" href="<?php echo site_url('admin/news/form/'.$item->id); ?>"><i class="icon-pencil"></i></a>
                        <a class="btn btn-default" href="<?php echo site_url('news/'.$item->slug); ?>" target="_blank"><i class="icon-eye"></i></a>
                        <a class="btn btn-danger" href="<?php echo site_url('admin/news/delete/'.$item->id); ?>" onclick="return areyousure();"><i class="icon-times"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    <?php endif;?>
</table>