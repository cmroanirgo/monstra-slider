<?php

// This deletes the slider table ONLY if it is empty
if (Table::get('slider')!==false) {
	$table = new Table('slider');
	if ($table->count()<1) {
		// no user data remaining. It's safe to drop
		Table::drop('slider');
	}
}


