<?php

/*
 * Palettes
 */

// buttons palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_button extends _bootstrap_empty_'] = array
(
	'link'      => array('url', 'target', 'linkTitle', 'titleText', 'rel', 'bootstrap_icon', 'bootstrap_dataAttributes'),
	'expert'    => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

// panel palettes
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_accordionGroupStart extends _bootstrap_default_'] = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_accordionGroupEnd extends _bootstrap_default_'] = array();

// carousel palettes
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselPart extends _bootstrap_empty_']  = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselEnd extends _bootstrap_empty_']   = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselStart extends _bootstrap_empty_'] = array
(
	'config' => array(
		'bootstrap_showIndicators',
		'bootstrap_showControls',
		'bootstrap_autostart',
		'bootstrap_interval',
	),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

// bootstrap tabs palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabPart extends _bootstrap_default_']  = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabEnd extends _bootstrap_default_']   = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabStart extends _bootstrap_default_'] = array
(
	'config' => array(
		'bootstrap_tabs', 'bootstrap_fade',
	)
);

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_buttons extends _bootstrap_default_'] = array
(
	'config' => array('bootstrap_buttons', 'bootstrap_buttonStyle'),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonStyle'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonStyle'],
	'exclude'   => true,
	'inputType' => 'text',
	'reference' => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'      => array('tl_class' => 'w50',),
	'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttons'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons'],
	'exclude'   => true,
	'inputType' => 'multiColumnWizard',

	'eval'      => array(
		'tl_class'       => 'bootstrapMultiColumnWizard hideSubLabels',
		'decodeEntities' => true,
		'columnFields'   => array
		(
			'type'       => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_type'],
				'exclude'   => true,
				'inputType' => 'select',
				'options'   => array('link', 'group', 'dropdown', 'child', 'header'),
				'reference' => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
				'eval'      => array('style' => 'width: 90px;', 'valign' => 'top'),
			),

			'label'      => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_label'],
				'exclude'   => true,
				'inputType' => 'text',
				'eval'      => array('style' => 'width: 90px', 'valign' => 'top', 'allowHtml' => true,),
			),

			'url'        => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_url'],
				'exclude'   => true,
				'inputType' => 'text',
				'eval'      => array('style' => 'width: 90px', 'valign' => 'top', 'rgxp' => 'url', 'decodeEntities' => true, 'tl_class' => 'wizard'),
				'wizard'    => array
				(
					array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'pagePicker')
				),
			),

			'attributes' => array
			(
				'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes'],
				'exclude'   => true,
				'inputType' => 'multiColumnWizard',
				'options'   => array('data-dismiss="modal"', 'class="btn-default"'),
				'eval'      => array
				(

					'decodeEntities' => true,
					'columnFields'   => array
					(
						'name'  => array
						(
							'inputType' => 'text',
							'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_name'],
							'options'   => array('class', 'title', 'data-'),
							'exclude'   => true,
							'eval'      => array
							(
								'includeBlankOption' => true,
								'style'              => 'width: 80px;',
								'placeholder'        => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_name'],
							),
						),

						'value' => array
						(
							'inputType' => 'text',
							'label'     => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_value'],
							'exclude'   => true,
							'eval'      => array('style' => 'width: 100px', 'placeholder' => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes_value']),
						),
					),
				),
			),
		),
	),
	'sql'       => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_showIndicators'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_showIndicators'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_showControls'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_showControls'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_autostart'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_autostart'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_interval'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_interval'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'clr'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_tabs'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class'=>'clr',
		'submitOnChange' => true,
		'columnFields' => array
		(
			'title' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_title'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array(),
			),
			'type' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_type'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options'                 => array('dropdown', 'child'),
				'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_type'],
				'eval'                    => array('includeBlankOption' => true, 'style' => 'width: 140px;'),
			),
		)
	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_fade'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_fade'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);