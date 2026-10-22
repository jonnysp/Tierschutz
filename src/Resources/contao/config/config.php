<?php

use Contao\Model;
use Contao\ArrayUtil;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

use Animals\Model\AnimalsModel;
use Animals\Model\AnimalsCategoriesModel;

$GLOBALS['TL_MODELS']['tl_animals'] = AnimalsModel::class;
$GLOBALS['TL_MODELS']['tl_animals_categories'] = AnimalsCategoriesModel::class;

ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['animals'], 100, array
	(
		'animalscategorie' => array('tables' => array('tl_animals_categories', 'tl_animals'))
	)
);

/**
 * Style sheet
 */
if (System::getContainer()->get('contao.routing.scope_matcher')
	->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))
) 
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnysptierschutz/animals.css|static';
};

/**
 * Front end modules
 */
ArrayUtil::arrayInsert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' => array
		(
			'animalscategorie_viewer'    => 'AnimalsCategorieViewer'
		)
	)
);


