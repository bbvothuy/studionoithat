<?php foreach($categories as $category):?>
    <url>
        <loc><?php echo site_url($category->slug);?></loc>
        <lastmod><?php echo date('Y-m-d' , strtotime("now"));?></lastmod>
    </url>
<?php endforeach;?>