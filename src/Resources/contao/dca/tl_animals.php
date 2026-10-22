<?php
use Contao\DC_Table;

/**
 * Table tl_animals
 */
$GLOBALS['TL_DCA']['tl_animals'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               =>  DC_Table::class,
		'ptable'                      => 'tl_animals_categories',
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
			'panelLayout'             => 'filter;search,limit'
		),

        'label' => [
            'fields'                  => ['title'],
            'format'                  => '%s',
        ],

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
        	'edit',
        	'copy',
        	'cut',
        	'delete',
        	'toggle' => array
        	(
        	        'href'                => 'act=toggle&field=published',
        	        'icon'                => 'visible.svg',
        	        'primary'             => true
        	),
        	'show',
        )
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,published;{title_images},image,images;{title_description},description;'
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
			'label'                 => &$GLOBALS['TL_LANG']['tl_animals']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                   => ['type' => 'string', 'length' => 128, 'default' => '']
		),
		'image' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_animals']['image'],
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'%contao.image.valid_extensions%'),
			'sql'                     => ['type' => 'binary','notnull' => false,'length' => 16,'fixed' => true]
		),
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_animals']['images'],
			'inputType'               => 'fileTree',
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'isSortable'=>true , 'files'=>true,'tl_class'=>'long clr','filesOnly'=>true, 'extensions'=>'%contao.image.valid_extensions%'),
			'sql'                     => ['type' => 'blob','notnull' => false]
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_animals']['description'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','tl_class'=>'clr'),
			'sql'                     => ['type' => 'text','notnull' => false]
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_animals']['toggle'],
            'toggle'                  => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true,'doNotCopy'=>true, 'tl_class'=>'w50'),
            'sql'                     => array('type'=>'boolean', 'default'=>false)
		)
	)
);
