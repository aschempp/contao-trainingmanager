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


class TrainingManager extends System
{

	/**
	 * Returns available courses
	 * @param int
	 * @return array
	 */
	public function getAvailableDates($intMaxDates = null)
	{
		$arrProperties = array('blnAvailable' => true);
		if($intMaxDates) {
			$arrProperties['intMaxDates'] = (int)$intMaxDates;
		}

		return $this->findCourseDates($arrProperties);
	}


	/**
	 * Returns all courses
	 * @param int
	 * @return array
	 */
	public function getDatesForCourse($intCourse)
	{
		$arrProperties = array
		(
			'blnAvailable' 	=> false,
			'intCourse' 	=> (int) $intCourse
		);

		return $this->findCourseDates($arrProperties);
	}


	/**
	 * Returns all available courses
	 * @param int
	 * @return array
	 */
	public function getAvailableDatesForCourse($intCourse)
	{
		$arrProperties = array
		(
			'blnAvailable' 	=> true,
			'intCourse' 	=> (int) $intCourse
		);

		return $this->findCourseDates($arrProperties);
	}


	/**
	 * Returns a list of available course dates
	 * @param int
	 * @return array
	 */
	public function getAvailableDate($intCourseDate)
	{
		$arrProperties = array
		(
			'blnAvailable'	=> true,
			'intCourseDate'	=> (int) $intCourseDate
		);

		$arrResult = $this->findCourseDates($arrProperties);

		return is_array($arrResult[0]) ? $arrResult[0] : false;
	}


	/**
	 * Returns a list of course dates
	 * @param bool
	 * @param int
	 * @param int
	 * @return array
	 */
	protected function findCourseDates($arrProperties)
	{
		$this->import('Database');

		// create and set variables from properties array
		extract($arrProperties);

		$time = time();
		$arrDates = array();

		$objDates = $this->Database->prepare("SELECT
			tc.*, td.*,
			(SELECT count(*) FROM tl_training_participant WHERE pid IN (SELECT id FROM tl_training_registration WHERE pid=td.id) ) as participantCount
			FROM tl_training_date td


			LEFT JOIN
			tl_training_course tc ON td.pid=tc.id

			WHERE
			td.startDate >= $time AND
			td.timeForApplication >= $time
			" . (BE_USER_LOGGED_IN ? '' : " AND published='1'") . "
			" . ($intCourse !== null ? " AND tc.id=$intCourse " : '') . "
			" . ($intCourseDate !== null ? " AND td.id=$intCourseDate " : '') . "

			" . ($blnAvailable ? "HAVING participantCount<tc.maxParticipants" : "") ."

			ORDER BY td.startDate

			" . ($intMaxDates !== null ? " LIMIT 0, $intMaxDates " : ' ') . "

			")
		->execute();

		while ($objDates->next())
		{
			$arrDates[] = array_merge($objDates->row(), array
			(
				'available'				=> ($objDates->maxParticipants - $objDates->participantCount),
				'formattedStartDate'	=> $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objDates->startDate),
				'formattedEndDate'		=> $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objDates->endDate),
				'dateRange'				=> TrainingManager::formatStartAndEndDate($objDates->startDate, $objDates->endDate),
			));
		}

		return $arrDates;
	}


	/**
	 * Reformat start and end dates
	 * @param int
	 * @param int|null
	 * @return string
	 */
	public static function formatStartAndEndDate($startDateTS, $endDateTS = null)
	{
		// mday mon year
		$arrStartDate = getdate($startDateTS);
		$arrEndDate = getdate($endDateTS);

		$ded = $arrStartDate['mday'] == $arrEndDate['mday'];
		$mem = $arrStartDate['mon'] == $arrEndDate['mon'];
		$yey = $arrStartDate['year'] == $arrEndDate['year'];

		// No end date or both dates the same
		if ($endDateTS === null || ($yey && $mem && $ded))
		{
			$strFormat = '%1$02d.%2$02d.%3$04d';
		}

		// Year and month are the same
		elseif ($yey && $mem)
		{
			$strFormat = '%1$02d. - %4$02d.%5$02d.%6$04d';
		}

		// Year is the same
		elseif ($yey)
		{
			$strFormat = '%1$02d.%2$02d. - %4$02d.%5$02d.%6$04d';
		}

		// Totally different
		else
		{
			$strFormat = '%1$02d.%2$02d.%3$04d - %4$02d.%5$02d.%6$04d';
		}

		return sprintf($strFormat, $arrStartDate['mday'], $arrStartDate['mon'], $arrStartDate['year'], $arrEndDate['mday'], $arrEndDate['mon'], $arrEndDate['year']);
	}
}

