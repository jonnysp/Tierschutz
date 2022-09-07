<?php

class TierschutzCategorieViewer extends ContentElement
{
	protected $strTemplate = 'ce_tierschutzcategorieviewer';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objCat = \TierschutzCategoriesModel::findByPK($this->tierschutzcategorie);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['tierschutz_categories_legend']) . ' ###';
			$objTemplate->title = '['. $objCat->id.'] - '. $objCat->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate

	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_tierschutz');
		$this->loadLanguageFile('tl_tierschutz_categories');

		//gets the categorie
		$objCategorie = \TierschutzCategoriesModel::findByPK($this->tierschutzcategorie);
		
		$Tierschutz = array();

		$filterTierschutz = \TierschutzModel::findAll(
			array('column' => array('pid=?','published=?'),'value' => array($this->tierschutzcategorie,1) ,'order' => 'sorting')
		);

		//get Categorie data
		$TierschutzImage = \FilesModel::findByPk($objCategorie->image);

		$TierschutzCategorie = array(
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


		//get Recipes data
		if (count($filterRecipes) > 0){
			foreach ($filterRecipes as $key => $value) {

				//main Image
				$TierschutzImage = \FilesModel::findByPk($value->image);
				
				//additional sorted Images
				$RTierschutzImages = array();
				$TierschutzUnsortedImages = \FilesModel::findMultipleByUuids(StringUtil::deserialize($value->images));
				$TierschutzImagesSort = StringUtil::deserialize($value->imagessort);

		 		if ($TierschutzImagesSort){
		 			foreach ($TierschutzImagesSort as $sortkey => $uuid) {
						if ($TierschutzUnsortedImages){
							foreach ($TierschutzUnsortedImages as $Image) {
								if ($Image->uuid == $uuid) {
									array_push($TierschutzImages, array
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
				$Tierschutz[$key] = array(
					"id" => $value->id,
					"title" => $value->title,
					"description" => $value->description,
					"ingredients" => $value->ingredients,
					"preparation" => $value->preparation,
					"published" => $value->published,
					"tags" => StringUtil::deserialize($value->tags),
					"categories" => StringUtil::deserialize($value->categories),
					"image" =>  array(
							"meta" => $this->getMetaData($TierschutzImage->meta, $objPage->language),
							"path" => $TierschutzImage->path,
							"name" => $TierschutzImage->name,
							"extension" => $TierschutzImage->extension
							),
					"images" => $TierschutzImages
				);
			}
		}

		$this->Template->TierschutzCategorie = $TierschutzCategorie;
		$this->Template->Tierschutz = $Tierschutz;

	}//end compile

}//end class
