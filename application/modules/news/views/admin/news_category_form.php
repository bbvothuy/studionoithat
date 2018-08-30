<?php
/**
 * Created by PhpStorm.
 * User: Khang
 * Date: 9/10/2017
 * Time: 5:01 PM
 */
?>
<?php pageHeader(lang('news_category_form')) ?>

<?php if($id == '') $id = 99999; echo form_open('admin/news/category/'.$id); ?>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="title"><?php echo lang('title');?></label>
            <?php echo form_input(['name'=>'title', 'value'=>assign_value('title', $title), 'class'=>'form-control']);?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="menu_title"><?php echo lang('menu_title');?></label>
            <?php echo form_input(['name'=>'menu_title', 'value'=>assign_value('menu_title', $menu_title), 'class'=>'form-control']);?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="seo_title"><?php echo lang('seo_title');?></label>
            <?php echo form_input(['name'=>'seo_title', 'value'=>assign_value('seo_title', $seo_title), 'class'=>'form-control']);?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="slug"><?php echo lang('slug');?></label>
            <?php echo form_input(['name'=>'slug', 'value'=>assign_value('slug', $slug), 'class'=>'form-control']);?>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="form-group">
        <label for="content"><?php echo lang('content');?></label>
        <?php echo form_textarea(['name'=>'content', 'value'=>assign_value('content', $content), 'class'=>'form-control redactor']);?>
    </div>
</div>


<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="sequence">Language</label>
            <?php
            $options = array('1' => 'Vietnamese', '2' => 'English');
            echo form_dropdown('language', $options,  assign_value('language', $language), 'class="form-control"');
            ?>
        </div>
        <div class="form-group">
            <label for="sequence"><?php echo lang('sequence');?></label>
            <?php echo form_input(['name'=>'sequence', 'value'=>assign_value('sequence', $sequence), 'class'=>'form-control']); ?>
        </div>

    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label><?php echo lang('meta');?></label>
            <?php echo form_textarea(['rows'=>'3', 'name'=>'meta', 'value'=>assign_value('meta', html_entity_decode($meta)), 'class'=>'form-control']); ?>
            <span id="helpBlock" class="help-block"><?php echo lang('meta_data_description');?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label><?php echo lang('keyword');?></label>
            <?php echo form_textarea(['rows'=>'3', 'name'=>'keyword', 'value'=>assign_value('keyword', html_entity_decode($keyword)), 'class'=>'form-control']); ?>
        </div>
    </div>
</div>



<div class="form-actions">
    <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
</div>
</form>
