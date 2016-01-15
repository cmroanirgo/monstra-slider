<?php
    /*
     This is just a demo slider template. Yours will be different. 
     This demo assumes that your theme is not already using a slider and includes everything

    copy this to /public/themes/<theme>/slider/views/frontend/index.view.php
    */
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/flexslider-min.css" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/jquery.flexslider-min.js"></script>
<script>
$(window).load(function() {
 
    $('.flexslider').flexslider({
        animation: "slide",
        controlsContainer: ".flexslider",
        slideshowSpeed: 3000,
        directionNav: false,
        controlNav: true,
        animationDuration: 900
    });
});
</script>

<!-- slider -->
<div class="slider-holder">
    <div class="flexslider">
        <ul class="slides">
<?php
    $target = '';

    if (count($items) > 0) {
        foreach ($items as $item) {
?>
            <li><img src="<?php echo $item['image']; ?>" alt=""/></li>            
<?php   
        }
    }
?>
        </ul>
    </div>
</div>
<!-- end of slider -->
