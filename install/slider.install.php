<?php

// Create the table 
if (Table::create('slider', ['title', 'summary', 'link', 'category', 'target','order', 'misc_text', 'image'])) {
    // created a new table
}
$table = new Table('slider');
$table->updateField('button_class','misc_text');
$table->deleteField('has_button');

// Ensure there is a slider snipper (don't overwrite though)
$snippets_path = STORAGE . DS  . 'snippets' . DS;
$install_path = PLUGINS . DS . 'slider'. DS . 'install' . DS;
if (!File::exists($snippets_path.'slider.snippet.php')) {
	// Copy our default one
	File::copy(
		$install_path.'slider.default.snippet.php',
		$snippets_path.'slider.snippet.php');
}

