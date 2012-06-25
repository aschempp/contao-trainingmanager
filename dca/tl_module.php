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



// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['training_list'] 	= '{title_legend},name,headline,type,training_list_numberOfItems;jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['training_dates'] 	= '{title_legend},name,training_dates_courseId;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Add fields to tl_module
 */

// Maximum number of participants
$GLOBALS['TL_DCA']['tl_module']['fields']['training_list_numberOfItems'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['training_list_numberOfItems'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

// Redirect-page
$GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('fieldType'=>'radio')
);

// Field to select the course
$GLOBALS['TL_DCA']['tl_module']['fields']['training_dates_courseId'] = array
(
	'label'                  	=> &$GLOBALS['TL_LANG']['tl_module']['training_dates_courseId'],
	'exclude'               	=> true,
	'filter'                  	=> true,
	'sorting'					=> true,
	'inputType'               	=> 'select',
	'foreignKey'              	=> 'tl_training_course.name',
	'eval'                    	=> array('doNotCopy'=>true, 'mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50')
);



/**
 * Class tl_module_news
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_module_training_list extends Backend
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
	 * Get all news reader modules and return them as array
	 * @return array
	 */
	public function getReaderModules()
	{
		$arrModules = array();
	}
}



