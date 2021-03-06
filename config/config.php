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
 * Backend modules
 */
array_insert($GLOBALS['BE_MOD'], 1, array
(
	'trainingmanager' => array
	(
		'training_date' => array
		(
			'tables'		=> array('tl_training_date', 'tl_training_registration', 'tl_training_participant'),
			'icon'			=> 'system/modules/trainingmanager/html/date.png',
		),
		'training_course' => array
		(
			'tables'		=> array('tl_training_course'),
			'icon'			=> 'system/modules/trainingmanager/html/course.png',
		),
		'training_category' => array
		(
			'tables'		=> array('tl_training_category'),
			'icon'			=> 'system/modules/trainingmanager/html/category.png',
		)
	)
));


/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['trainingmanager'] = array
(
	'training_list'  			=> 'ModuleTrainingList',
	'training_registration'   	=> 'ModuleTrainingRegistration'
);


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['trainingmanager'] = array
(
	'training_dates'			=> 'ContentTrainingDates'
);


$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('TrainingManager', 'replaceTags');

