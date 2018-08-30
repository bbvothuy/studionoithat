<?php if($news_title):?>
    <div class="page-header">
        <h1><?php echo $news_title;?></h1>
    </div>
<?php endif;?>

<?php
echo (new content_filter($news->content))->display();
?>