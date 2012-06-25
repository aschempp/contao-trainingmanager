<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @author     Jan Reuteler <jan.reuteler@iserv.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_training_date
 */
$GLOBALS['TL_DCA']['tl_training_date'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'ctable'						=> array('tl_training_registration'),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 2,
			'fields'					=> array('startDate DESC'),
			'panelLayout'				=> 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'					=> array('code', 'startDate', 'endDate'),
			'format'					=> '%s <span style="color:#b3b3b3; padding-left:3px;">%s - %s</span>',

		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'					=> 'act=select',
				'class'					=> 'header_edit_all',
				'attributes'			=> 'onclick="Backend.getScrollOffset();" accesskey="e"'
			),
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['edit'],
				'href'					=> 'act=edit',
				'icon'					=> 'edit.gif'
			),
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.gif'
			),
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
			'registrations' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['registrations'],
				'href'					=> 'table=tl_training_registration',
				'icon'					=> 'system/modules/trainingmanager/html/registrations.png'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'						=> '{name_legend},pid,code;{date_legend},startDate,endDate,timeForApplication;{publish_legend},published',
	),

	// Fields
	'fields' => array
	(

		'pid' => array
		(
			'label'                  	=> &$GLOBALS['TL_LANG']['tl_training_date']['pid'],
			'exclude'               	=> true,
			'filter'                  	=> true,
			'sorting'					=> true,
			'inputType'               	=> 'select',
			'foreignKey'              	=> 'tl_training_course.name',
			'eval'                    	=> array('doNotCopy'=>true, 'mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50')
		),
		'code' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_date']['code'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
		),
		'startDate' => array
		(
			'label'                   	=> &$GLOBALS['TL_LANG']['tl_training_date']['startDate'],
			'exclude'                 	=> true,
			'sorting'					=> true,
			'flag'						=> 8,
			'inputType'               	=> 'text',
			'eval'                    	=> array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'endDate' => array
		(
			'label'                   	=> &$GLOBALS['TL_LANG']['tl_training_date']['endDate'],
			'exclude'                 	=> true,
			'flag'						=> 8,
			'inputType'               	=> 'text',
			'eval'                    	=> array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'timeForApplication' => array
		(
			'label'                   	=> &$GLOBALS['TL_LANG']['tl_training_date']['timeForApplication'],
			'exclude'                 	=> true,
			'inputType'               	=> 'text',
			'eval'                    	=> array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'published' => array
		(
			'label'                		=> &$GLOBALS['TL_LANG']['tl_training_date']['published'],
			'exclude'                 	=> true,
			'filter'                  	=> true,
			'inputType'              	=> 'checkbox',
			'eval'                   	=> array('doNotCopy'=>true)
		)
	)
);

