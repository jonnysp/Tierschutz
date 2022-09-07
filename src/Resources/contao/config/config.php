<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */

array_insert($GLOBALS['BE_MOD']['tierschutz'], 100, array
(
	'recipescategorie' 		=> array('tables' => array('tl_tierschutz_categories', 'tl_tierschutz'))
));


/**
 * Style sheet
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnysptierschutz/tierschutz.css|static';
}


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
			(
				'tierschutzcategorie_viewer'	=> 'TierschutzCategorieViewer'
			)
	)
);


