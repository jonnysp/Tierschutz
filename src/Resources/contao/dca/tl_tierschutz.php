<?php

/**
 * Table tl_tierschutz
 */
$GLOBALS['TL_DCA']['tl_tierschutz'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tierschutz_categories',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		 'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'flag'        			  => 1,
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_tierschutz', 'generateReferenzRow')
		),

		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		
		'operations' => array
		(

			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),

			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tierschutz']['toggle'],
				'icon'                => 'visible.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_tierschutz', 'toggleIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,published;{title_images},image,images;{title_description},description,ingredients,preparation,tags'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => ['type' => 'integer','notnull' => false, 'unsigned' => true,'default' => '0','fixed' => true]
		),
		'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_tierschutz']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                   => ['type' => 'string', 'length' => 128, 'default' => '']
		),
		'image' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['image'],
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => ['type' => 'binary','notnull' => false,'length' => 16,'fixed' => true]
		),
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['images'],
			'inputType'               => 'fileTree',
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'imagessort', 'files'=>true,'tl_class'=>'long clr','filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
			'sql'                     => ['type' => 'blob','notnull' => false],
			'load_callback' => array
			(
				array('tl_tierschutz', 'setFileTreeFlags')
			)
		),
		'imagessort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_products']['imagessort'],
			'sql'                     => ['type' => 'blob','notnull' => false]
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['description'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','tl_class'=>'clr'),
			'sql'                     => ['type' => 'text','notnull' => false]
		),
		'ingredients' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['ingredients'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','tl_class'=>'clr'),
			'sql'                     => ['type' => 'text','notnull' => false]
		),
		'preparation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['preparation'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','tl_class'=>'clr'),
			'sql'                     => ['type' => 'text','notnull' => false]
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tierschutz']['toggle'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);

use Contao\Image\ResizeConfiguration;

class tl_tierschutz extends Backend{

	public function generateReferenzRow($arrRow)	{
		$this->loadLanguageFile('tl_tierschutz');

		$label = $arrRow['title'];

		if ($arrRow['image'] != '')
		{
			$objFile = FilesModel::findByUuid($arrRow['image']);
			if ($objFile !== null)
			{
				$container = System::getContainer();
				$rootDir = $container->getParameter('kernel.project_dir');

				$label = Image::getHtml($container->get('contao.image.image_factory')->create($rootDir.'/'.$objFile->path,(new ResizeConfiguration())->setWidth(80)->setHeight(80)->setMode(ResizeConfiguration::MODE_BOX))->getUrl($rootDir), '', 'style="float:left;"') . ' ' . $label;

			}
		}
		return $label;
    }


	public function setFileTreeFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
				$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
		}
		return $varValue;
	}


	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}


	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{

		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_tierschutz']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_tierschutz']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_tierschutz SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);
	}

}

