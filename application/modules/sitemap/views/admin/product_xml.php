<?php foreach($products as $product):?>
    <url>
        <loc><?php echo site_url($product->slug.'.html');?></loc>
        <lastmod><?php echo date('Y-m-d' , strtotime("now"));?></lastmod>
    </url>
<?php endforeach;?>