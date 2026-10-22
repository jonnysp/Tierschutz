<?php
use Contao\ContentElement;
use Contao\BackendTemplate;
use Contao\System;
use Contao\FilesModel;
use Contao\StringUtil;

use Animals\Model\AnimalsCategoriesModel;
use Animals\Model\AnimalsModel;

class AnimalsCategorieViewer extends ContentElement
{
	protected $strTemplate = 'ce_animalscategorieviewer';

	public function generate()
	{

		$request = System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$objCat = AnimalsCategoriesModel::findByPK($this->animalscategorie);
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['tl_content']['animals_categories_legend'] . ' ###';
			$objTemplate->title = '['. $objCat->id.'] - '. $objCat->title;
			return $objTemplate->parse();	
		}

		return parent::generate();
	}//end generate

	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_animals');
		$this->loadLanguageFile('tl_animals_categories');

		$Categorie = array();
		$Animals = array();

		$objCategorie = AnimalsCategoriesModel::findByPK($this->animalscategorie);
		$filterAnimals = AnimalsModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($this->animalscategorie,1) ,'order' => 'sorting')
		);

		//make Categorie data
		$Categorie = array(
			"id" => $objCategorie->id,
			"title" => $objCategorie->title,
			"description" => $objCategorie->description//,
		);
		$CategorieImage = FilesModel::findByPk($objCategorie->image);
		if ($CategorieImage) {
			$Categorie['image'] = array(
				"meta"      => StringUtil::deserialize($CategorieImage->meta),
				"path"      => $CategorieImage->path,
				"name"      => $CategorieImage->name,
				"extension" => $CategorieImage->extension
			);
		}else{
			$Categorie['image'] = null;
		}

		//make Animal data
		if (count($filterAnimals) > 0){
			foreach ($filterAnimals as $key => $value) {
			
				// generate Data_array
				$Animals[$key] = array(
					"id" => $value->id,
					"title" => $value->title,
					"description" => $value->description,
					"published" => $value->published
				);

				//main Image				
				$AnimalImage = FilesModel::findByPk($value->image);
				if ($AnimalImage) {
					$Animals[$key]['image'] = array(
						"meta"      => StringUtil::deserialize($AnimalImage->meta), 
						"path"      => $AnimalImage->path,
						"name"      => $AnimalImage->name,
						"extension" => $AnimalImage->extension
					);
				}else{
					$Animals[$key]['image'] = null;
				}

				//additional Images
				$Images = array();
				$AnimalImages = FilesModel::findMultipleByUuids(StringUtil::deserialize($value->images));
				if ($AnimalImages){
					foreach ($AnimalImages as $Image) {
						array_push($Images, array
							(
								"meta" => StringUtil::deserialize($Image->meta), 
								"path" => $Image->path,
								"name" => $Image->name,
								"extension" => $Image->extension
							)
						);
					}
					$Animals[$key]['images'] = $Images;	
				}else{
					$Animals[$key]['images'] = null;	
				}
				

			}
		}


		$this->Template->AnimalsCategorie = $Categorie;
		$this->Template->Animals = $Animals;


	}//end compile

}//end class

