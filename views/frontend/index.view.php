<?php
    // delegate to snippets, so that designers can easily change how things look AND it makes changes more theme agnostic (although this may not be a great thing anyway)
    echo Snippet::get('slider', array('items'=>$items));

