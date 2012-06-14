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
 * Table tl_training_participant
 */
$GLOBALS['TL_DCA']['tl_training_participant'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'ptable'						=> 'tl_training_registration',
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 1,
			'fields'					=> array('name'),
			'flag'						=> 1,
			'panelLayout'				=> 'filter;search,limit',
		),
		'label' => array
		(
			'fields'					=> array('name'),
			'format'					=> '%s',
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
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_participant']['edit'],
				'href'					=> 'act=edit',
				'icon'					=> 'edit.gif'
			),
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_participant']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.gif'
			),
			'cut' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_participant']['cut'],
				'href'					=> 'act=paste&amp;mode=cut',
				'icon'					=> 'cut.gif',
				'attributes'			=> 'onclick="Backend.getScrollOffset();"'
			),
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_participant']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_participant']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'						=> '{name_legend},pid,gender,firstname,lastname',
	),

	// Fields
	'fields' => array
	(
		'pid' => array
		(
			'label'                  	=> &$GLOBALS['TL_LANG']['tl_training_registration']['id'],
			'exclude'               	=> true,
			'filter'                  	=> true,
			'sorting'					=> true,
			'inputType'               	=> 'select',
			'foreignKey'              	=> 'tl_training_registration.id',
			'eval'                    	=> array('doNotCopy'=>true, 'mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50')
		),
		'gender' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_training_participant']['gender'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('male', 'female'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('mandatory'=>true, 'includeBlankOption'=>true, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'personal', 'tl_class'=>'w50')
		),
		'firstname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_participant']['firstname'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50'),
		),
		'lastname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_training_participant']['lastname'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'feEditable'=>true, 'tl_class'=>'w50'),
		),
	)
);


class tl_training_participant extends Backend
{

	/**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @return string
	 */
	public function addIcon($row, $label)
	{
		$image = 'published';

		if (!$row['published'] || (strlen($row['start']) && $row['start'] > time()) || (strlen($row['stop']) && $row['stop'] < time()))
		{
			$image = 'un'.$image;
		}

		return sprintf('<div class="list_icon" style="background-image:url(\'system/themes/%s/images/%s.gif\');">%s</div>', $this->getTheme(), $image, $label);
	}
}

