<h2 class="margin-bottom-1"><?php echo __('Slider Usage', 'slider'); ?></h2>

<p>This plugin uses FlexSlider by WooThemes in the default scenario, although it's not necessary. If you're happy with something else, then it should be easy to drop it in instead.</p>
<p>Some other good sliders (/carousels) are:</p>
<ul>
	<li><a href="https://www.woothemes.com/flexslider/" target="_blank">FlexSlider</a></li>
	<li><a href="http://kenwheeler.github.io/slick/" target="_blank">Slick</a></li>
	<li><a href="http://sorgalla.com/jcarousel/" target="_blank">jCarousel</a></li>
</ul>
<p>A list of jQuery sliders can be found <a href="https://plugins.jquery.com/tag/carousel/" target="_blank">here</a>.</p>

<h3>Basic Usage</h3>
<h4>Step 1</h4>
<p>Simply edit the relevant template page (eg. the Home page) and add <code>&lt;?php echo Slider::get(); ?&gt;</code> to instantiate the default Slider, or use the shortcode <code>{slider}</code> within a page or blog post.</p>
<p>To use a different slider category, use <code>&lt;?php echo Slider::get("some_category"); ?&gt;</code> or <code>{slider name="some_category"}</code>.
<ul>
    <li><?php echo Html::anchor('Click to go to the theme editor', 'index.php?id=themes'); ?></li>
    <li><?php echo Html::anchor('Click to go to the page editor', 'index.php?id=pages'); ?></li>
</ul>
<h4>Step 2 (optional)</h4>
<p>Once you have edited the template page, the Slider code then makes use of the Snippet called <quote>Slider</quote>, which you can edit based upon your requirements.</p>

<ul>
    <li><?php echo Html::anchor('Click to edit the snippet', 'index.php?id=snippets&action=edit_snippet&filename=slider'); ?></li>
</ul>

<h3>Advanced Usage</h3>
<p>The mechanism to use the slider is easily overridden, if desired.</p>
<ol>
<li>copy the file from  <code>/plugins/slider/frontend/index.view.php</code> to <code>/public/themes/&lt;theme&gt;/slider/frontend/index.view.php</code></li>
<li>The existing code is a few short lines of php:
<code><pre>
	<?php echo '&lt;?'.'php'; ?>
	    
	    // delegate to snippets, so that designers can easily change how things look 
	    echo Snippet::get('slider', array('items'=>$items));
</pre></code> which can be edited however you like. The existing snippet code can be dropped into this file without adjustment.
</li>
</ol></p>
<p>Note that <code>/plugins/slider/frontend</code> also contains some demo implementations that you can make use of.</p>

<h3>Default Snippet Code</h3>
<p>For posterity, here is the default snippet code. As mentioned above, you can use any existing slider /carousel that you like. Note also that the field names 
are rather arbitary. For example 'Misc Text' is used to display a link button.</p>
<div><textarea id="snippet-content" name="snippet-content" class="source-editor form-control" style="width:100%;height:400px;">&lt;?php
    /*
     This is the default slider template. Yours will be different. 
     This demo assumes that your theme is not already using a slider and includes everything
    */
?&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/flexslider-min.css&quot; type=&quot;text/css&quot; /&gt;
&lt;script src=&quot;//cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/jquery.flexslider-min.js&quot;&gt;&lt;/script&gt;
&lt;script&gt;
$(window).load(function() {
 
    $(&#039;.flexslider&#039;).flexslider({
        animation: &quot;slide&quot;,
		 //controlsContainer: &quot;.slider-holder&quot;,
        slideshowSpeed: 7000,
        directionNav: true,
        controlNav: true,
        animationDuration: 2000,
        before:function( slider ){
            $(&#039;.slide-cnt&#039;).fadeOut()
        },

        after:function( slider ){
            $(&#039;.slide-cnt&#039;).fadeIn()
        }
    });
});
&lt;/script&gt;
&lt;style&gt;
	.flexslider img { max-height: 400px; }
	.flexslider .slide-cnt { position:fixed; top:1em; margin-top:2em; margin-left:3em; color:#f0f0f0}
    .flexslider h2 { }
    .flexslider .box-cnt p { }
	.flexslider a,.flexslider a:hover { }
&lt;/style&gt;
&lt;!-- slider --&gt;
&lt;div class=&quot;m-slider&quot;&gt;
    &lt;div class=&quot;slider-holder&quot;&gt;
        &lt;span class=&quot;slider-shadow&quot;&gt;&lt;/span&gt;
        &lt;span class=&quot;slider-b&quot;&gt;&lt;/span&gt;
        &lt;div class=&quot;slider flexslider&quot;&gt;
&lt;ul class=&quot;slides&quot;&gt;
&lt;?php
    $target = &#039;&#039;;

    if (count($items) &gt; 0) {
        foreach ($items as $item) {

            $item[&#039;link&#039;] = Html::toText($item[&#039;link&#039;]);
            $item[&#039;title&#039;] = Html::toText($item[&#039;title&#039;]);
            $item[&#039;summary&#039;] = Text::nl2br(Html::toText($item[&#039;summary&#039;]));
            $item[&#039;misc_text&#039;] = Html::toText($item[&#039;misc_text&#039;]);

            $pos = strpos($item[&#039;link&#039;], &#039;http://&#039;);
            if ($pos === false) {
                $link = Option::get(&#039;siteurl&#039;).&#039;/&#039;.$item[&#039;link&#039;];
            } else {
                $link = $item[&#039;link&#039;];
            }

            if (trim($item[&#039;target&#039;]) !== &#039;&#039;) {
                $target = &#039; target=&quot;&#039;.$item[&#039;target&#039;].&#039;&quot; &#039;;
            }

?&gt;&lt;li&gt;
        &lt;div class=&quot;img-holder&quot;&gt;
            &lt;img src=&quot;&lt;?php echo $item[&#039;image&#039;]; ?&gt;&quot; alt=&quot;&quot;/&gt;
        &lt;/div&gt;
        &lt;div class=&quot;slide-cnt&quot;&gt;
            &lt;h2&gt;&lt;?php echo $item[&#039;title&#039;]; ?&gt;&lt;/h2&gt;
            &lt;div class=&quot;box-cnt&quot;&gt;
                &lt;p&gt;&lt;?php echo $item[&#039;summary&#039;]; ?&gt;&lt;/p&gt;
            &lt;/div&gt;
            &lt;?php if (trim($item[&#039;misc_text&#039;])!==&#039;&#039;) { echo &#039;&lt;a href=&quot;&#039;.$link.&#039;&quot;&#039;.$target.&#039; class=&quot;btn btn-default&quot;&gt;&#039;.$item[&#039;misc_text&#039;].&#039;&lt;/a&gt;&#039;; } ?&gt;
        &lt;/div&gt;
&lt;/li&gt;
&lt;?php        }
    }
?&gt;
&lt;/ul&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;!-- end of slider --&gt;</textarea></div>

<!--
<p>Go to <code>/plugins/slider/frontend</code> to see the demo code. NB: Of them all demo2.view.php is the most simple, and demo1.view.php is most complex</p>
-->