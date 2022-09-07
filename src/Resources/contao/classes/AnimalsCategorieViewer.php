<?php

class AnimalsCategorieViewer extends ContentElement
{
	protected $strTemplate = 'ce_animalscategorieviewer';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objCat = \AnimalsCategoriesModel::findByPK($this->animalscategorie);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['animals_categories_legend']) . ' ###';
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

		//gets the categorie
		$objCategorie = \AnimalsCategoriesModel::findByPK($this->animalscategorie);
		
		$Animals = array();

		$filterAnimals = \AnimalsModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($this->animalscategorie,1) ,'order' => 'sorting')
		);

		//get Categorie data
		$CategorieImage = \FilesModel::findByPk($objCategorie->image);

		$Categorie = array(
			"id" => $objCategorie->id,
			"title" => $objCategorie->title,
			"description" => $objCategorie->description,
			"image" => array(
					"meta" => $this->getMetaData($CategorieImage->meta, $objPage->language),
					"path" => $CategorieImage->path,
					"name" => $CategorieImage->name,
					"extension" => $CategorieImage->extension
				)
		);


		//get Animals data
		if (count($filterAnimals) > 0){
			foreach ($filterAnimals as $key => $value) {

				//main Image
				$AnimalImage = \FilesModel::findByPk($value->image);
				
				//additional sorted Images
				$AnimalImages = array();
				$AnimalUnsortedImages = \FilesModel::findMultipleByUuids(StringUtil::deserialize($value->images));
				$AnimalImagesSort = StringUtil::deserialize($value->imagessort);

		 		if ($AnimalImagesSort){
		 			foreach ($AnimalImagesSort as $sortkey => $uuid) {
						if ($AnimalUnsortedImages){
							foreach ($AnimalUnsortedImages as $Image) {
								if ($Image->uuid == $uuid) {
									array_push($AnimalImages, array
										(
											"meta" => $this->getMetaData($Image->meta, $objPage->language),
											"path" => $Image->path,
											"name" => $Image->name,
											"extension" => $Image->extension
										)
									);
								}
							}
						}
		 			}
				}

				// generate Data_array
				$Animals[$key] = array(
					"id" => $value->id,
					"title" => $value->title,
					"description" => $value->description,
					"ingredients" => $value->ingredients,
					"preparation" => $value->preparation,
					"published" => $value->published,
					"tags" => StringUtil::deserialize($value->tags),
					"categories" => StringUtil::deserialize($value->categories),
					"image" =>  array(
							"meta" => $this->getMetaData($AnimalImage->meta, $objPage->language),
							"path" => $AnimalImage->path,
							"name" => $AnimalImage->name,
							"extension" => $AnimalImage->extension
							),
					"images" => $AnimalImages
				);
			}
		}

		$this->Template->AnimalsCategorie = $Categorie;
		$this->Template->Animals = $Animals;

	}//end compile

}//end class
