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
			'label_callback'			=> array('tl_training_date', 'formatRow'),

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
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_training_date']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_training_date', 'toggleIcon')
			),
			'registrations' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_training_date']['registrations'],
				'href'					=> 'table=tl_training_registration',
				'icon'					=> 'system/modules/trainingmanager/html/registrations.png'
			)
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



class tl_training_date extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @return string
	 */
	public function formatRow($row, $label)
	{
		$label = $row['code'].' <span style="color:#b3b3b3; padding-left:3px;">' . TrainingManager::formatStartAndEndDate($row['startDate'], $row['endDate']) . '</span>';

		return $label;
	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_training_date::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_training_date']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_training_date']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_training_date SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);
	}

}
