<?php
    /*
     This is the default slider template. Yours will be different. 
     This demo assumes that your theme is not already using a slider and includes everything
    */
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/flexslider-min.css" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/jquery.flexslider-min.js"></script>
<script>
$(window).load(function() {
 
    $('.flexslider').flexslider({
        animation: "slide",
         //controlsContainer: ".slider-holder",
        slideshowSpeed: 7000,
        directionNav: true,
        controlNav: true,
        animationDuration: 2000,
        before:function( slider ){
            $('.slide-cnt').fadeOut()
        },

        after:function( slider ){
            $('.slide-cnt').fadeIn()
        }
    });
});
</script>
<style>
    .flexslider img { max-height: 400px; }
    .flexslider .slide-cnt { position:fixed; top:1em; margin-top:2em; margin-left:3em; color:#f0f0f0}
    .flexslider h2 { }
    .flexslider .box-cnt p { }
    .flexslider a,.flexslider a:hover { }
</style>
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
            $item['summary'] = Text::nl2br(Html::toText($item['summary']));
            $item['misc_text'] = Html::toText($item['misc_text']);

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
                <p><?php echo $item['summary']; ?></p>
            </div>
            <?php if (trim($item['misc_text'])!=='') { echo '<a href="'.$link.'"'.$target.' class="btn btn-default">'.$item['misc_text'].'</a>'; } ?>
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