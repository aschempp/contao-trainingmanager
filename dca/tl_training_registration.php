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
 * Table tl_training_registration
 */
$GLOBALS['TL_DCA']['tl_training_registration'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'closed'						=> true,
		'ptable'						=> 'tl_training_date',
		'ctable'						=> array('tl_training_participant'),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 4,
			'fields'					=> array('lastname'),
			'flag'						=> 1,
			'panelLayout'				=> 'filter;search,limit',
			'headerFields'				=> array('pid', 'code', 'startDate', 'endDate', 'timeForApplication'),
			'child_record_callback'		=> array('tl_training_registration', 'listRows')
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
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_registration']['edit'],
				'href'					=> 'act=edit',
				'icon'					=> 'edit.gif'
			),
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_registration']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.gif'
			),
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_registration']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_registration']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'						=> '{name_legend},gender,firstname,lastname,company,street,postal,city,phone,email,comments',
	),


	// Fields
	'fields' => array
	(
		'gender' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['gender'],
			'exclude'					=> true,
			'inputType'					=> 'select',
			'options'					=> array('male', 'female'),
			'reference'					=> &$GLOBALS['TL_LANG']['tl_training_registration'],
			'eval'						=> array('mandatory'=>true, 'includeBlankOption'=>true, 'feEditable'=>true, 'tl_class'=>'clr')
		),
		'firstname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['firstname'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50'),
		),
		'lastname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['lastname'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50'),
		),
		'company' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['company'],
			'exclude'					=> true,
			'search'					=> true,
			'sorting'					=> true,
			'flag'						=> 1,
			'inputType'					=> 'text',
			'eval'						=> array('maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'street' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['street'],
			'exclude'					=> true,
			'search'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'postal' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['postal'],
			'exclude'					=> true,
			'search'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>32, 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'city' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['city'],
			'exclude'					=> true,
			'filter'					=> true,
			'search'					=> true,
			'sorting'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'phone' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['phone'],
			'exclude'					=> true,
			'search'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>64, 'rgxp'=>'phone', 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'email' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['email'],
			'exclude'					=> true,
			'search'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>255, 'unique'=>true, 'decodeEntities'=>true, 'feEditable'=>true, 'tl_class'=>'w50')
		),
		'comments' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_registration']['comments'],
			'exclude'					=> true,
			'inputType'					=> 'textarea',
			'eval'						=> array('feEditable'=>true, 'tl_class'=>'clr'),
		),
	)
);


class tl_training_registration extends Backend
{

	/**
	 * Return a formatted label for the registration
	 * @param array
	 * @return string
	 */
	public function listRows($arrRow)
	{
		$strBuffer = '<strong>' . $arrRow['lastname'] . ' '.$arrRow['firstname'] . '</strong> - ' . $arrRow['company'] . "\n<ul>";

		$objParticipants = $this->Database->execute("SELECT * FROM tl_training_participant WHERE pid=" . (int) $arrRow['id']);

		while( $objParticipants->next() )
		{
			$strBuffer .= '<li>' . $GLOBALS['TL_LANG']['tl_training_registration'][$objParticipants->gender] . ' ' . $objParticipants->firstname . ' ' . $objParticipants->lastname . '</li>';
		}

		return $strBuffer . '</ul>';
	}
}

