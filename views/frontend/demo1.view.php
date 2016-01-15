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
        controlsContainer: ".slider-holder",
        slideshowSpeed: 7000,
        directionNav: true,
        controlNav: true,
        animationDuration: 2000,
        before:function( slider ){
            $('.img-holder').animate({'bottom' : '-30px'},300)
        },

        after:function( slider ){
            $('.img-holder').animate({'bottom' : '0px'},300)
        }
    });
});
</script>
<!-- slider -->
<div class="m-slider">
    <div class="slider-holder">
        <span class="slider-shadow"></span>
        <span class="slider-b"></span>
        <div class="slider flexslider">
<ul class="slides">
<?php
    $target = '';

    if (count($items) > 0) {
        foreach ($items as $item) {

            $item['link'] = Html::toText($item['link']);
            $item['title'] = Html::toText($item['title']);

            $pos = strpos($item['link'], 'http://');
            if ($pos === false) {
                $link = Option::get('siteurl').'/'.$item['link'];
            } else {
                $link = $item['link'];
            }

            if (trim($item['target']) !== '') {
                $target = ' target="'.$item['target'].'" ';
            }

?><li>
        <div class="img-holder">
            <img src="<?php echo $item['image']; ?>" alt=""/>
        </div>
        <div class="slide-cnt">
            <h2><?php echo $item['title']; ?></h2>
            <div class="box-cnt">
                <p><?php echo Text::nl2br($item['summary']); ?></p>
            </div>
            <?php if ($item['has_button']) { echo '<a href="'.$link.'" class="grey-btn">'.$item['button_class'].'</a>'; } ?>
        </div>
</li>
<?php        }
    }
?>
</ul>
        </div>
    </div>
</div>
<!-- end of slider -->