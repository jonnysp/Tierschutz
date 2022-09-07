<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */

array_insert($GLOBALS['BE_MOD']['animals'], 100, array
(
	'animalscategorie' 		=> array('tables' => array('tl_animals_categories', 'tl_animals'))
));


/**
 * Style sheet
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnyspanimals/animals.css|static';
}


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
			(
				'animalscategorie_viewer'	=> 'animalsCategorieViewer'
			)
	)
);


