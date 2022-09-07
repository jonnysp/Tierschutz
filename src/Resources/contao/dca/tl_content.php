<?php

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
		$objCats =  \AnimalsCategoriesModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editAnimalsCategorie(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_animals_categories');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=animalscategorie&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_animals_categories']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_animals_categories']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_animals_categories']['editheader'][0]) . '</a>';
	}

}