<?php     
    $this->show('categories/products', ['products'=>$products, 'search'=>true, 'term'=>$term, 'cat_id'=>$cat_id, 'cat_name'=>$cat_name]);
    //include(__DIR__.'/products.php');?>

    <div class="text-center pagination">
        <?php echo CI::pagination()->create_links();?>
    </div>
   
</div>
<script type="text/javascript">
$(function() {
    $("#sort").change(function () {
        window.location = this.value;
    });
});
</script>