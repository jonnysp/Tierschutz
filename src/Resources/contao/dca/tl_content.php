<?php
use Contao\System;
use Contao\Backend;
use Contao\DataContainer;
use Contao\StringUtil;
use Contao\Image;

use Animals\Model\AnimalsCategoriesModel;


$GLOBALS['TL_DCA']['tl_content']['palettes']['animalscategorie_viewer'] = '{type_legend},type;{animals_categories_legend},animalscategorie;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['animalscategorie'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['animalscategorie'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_animals', 'getAnimalsCategorie'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_animals', 'editAnimalsCategorie')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);


class tl_content_animals extends Backend 
{

	public function getAnimalsCategorie()
	{
		$objCats =  AnimalsCategoriesModel::findAll();
		$arrCats = array();
		if (isset($objCats)) {
			foreach ($objCats as $objCat)
			{
				$arrCats[$objCat->id] =  $objCat->title .' (ID ' . $objCat->id . ')';
			}
		}
		return $arrCats;
	}

	public function editAnimalsCategorie(DataContainer $dc): string
	{

		$this->loadLanguageFile('tl_animals_categories');
		if ($dc->value < 1)
        {
            return '';
        }
		$title = sprintf($GLOBALS['TL_LANG']['tl_animals_categories']['edit'][1], $dc->value);
		$href = System::getContainer()->get('router')->generate('contao_backend', array('do'=>'animalscategorie', 'table'=>'tl_animals_categories','act'=>'edit', 'id'=>$dc->value , 'popup'=>'1', 'nb'=>'1'));
		return ' <a href="' . StringUtil::specialcharsUrl($href) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", $title)) . '\',\'url\':this.href});return false">' . Image::getHtml('edit.svg', $title) . '</a>';
	}

}