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





class ModuleTrainingRegistration extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_training_registration';

	/**
	 * Form id
	 * @var string
	 */
	protected $strFormId = 'tl_training_registration';

	/**
	 * Submitable
	 * @var boolean
	 */
	protected $doNotSubmit = false;


	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### TRAINING REGISTRATION ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = $this->Environment->script.'?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	public function generateAjax()
	{
		$id = $this->Input->get('coursedate');
		$this->import('TrainingManager');
		$courses = $this->TrainingManager->getAvailableCourseDate($id);

		$objTemplate = new FrontendTemplate('mod_training_registration_course');
		$objTemplate->setData($courses[0]);

		return $objTemplate->parse();
	}


	protected function compile()
	{

		$this->import('TrainingManager');
		$courses = $this->TrainingManager->availableCourses();
		$this->Template->courses  = $courses;


		$arrParticipants = array();

		$arrRegistration = $this->generateFields('tl_training_registration');

		for( $i=0; $i<4; $i++ )
		{
			$arrParticipants[] = $this->generateFields('tl_training_participant', $i, ($i > 0 ? false : true));
		}

		$this->Template->formId = $this->strFormId;
		$this->Template->slabel = "Submit..";
		$this->Template->action = $this->getIndexFreeRequest();
		$this->Template->registration = $arrRegistration;
		$this->Template->participants = $arrParticipants;

		// Create new user if there are no errors
		if ($this->Input->post('FORM_SUBMIT') == $this->strFormId && !$this->doNotSubmit)
		{
			$this->createNewRegistration((int) $this->Input->post('pid'), $arrRegistration, $arrParticipants);
		}

	}

	// TODO: move down
	protected function createNewRegistration($intCourse, $arrRegistration, $arrParticipants)
	{
		$time = time();
		$arrData = array('tstamp'=>$time);

		foreach($arrRegistration as $field=>$objWidget)
		{
			$arrData[$field] = $objWidget->value;
		}
		$arrData['pid'] = $intCourse;

		// Create Registration
		$objNewRegistration = $this->Database->prepare("INSERT INTO tl_training_registration %s")->set($arrData)->execute();
		$insertId = $objNewRegistration->insertId;

		foreach($arrParticipants as $arrParticipant)
		{
			$arrData = array('tstamp'=>$time);

			foreach($arrParticipant as $field=>$objWidget)
			{
				$arrData[$field] = $objWidget->value;
			}

			$arrData['pid'] = $insertId;

			// Create Participant
			$objNewParticipant = $this->Database->prepare("INSERT INTO tl_training_participant %s")->set($arrData)->execute();
		}

	}

	private function generateFields($strTable, $strSuffix='', $blnMandatoryCheck=true)
	{
		$this->loadLanguageFile($strTable);
		$this->loadDataContainer($strTable);

		$arrWidgets = array();
		$arrFields = &$GLOBALS['TL_DCA'][$strTable]['fields'];

		if ($blnCheckMandatory == false)
		{
			foreach( $arrFields as $field => $arrData)
			{
				if ($arrData['eval']['mandatory'] && $this->Input->post($field.$strSuffix) != '')
				{
					$blnMandatoryCheck = true;
				}
			}
		}

		// Build form
		foreach($arrFields as $field => $arrData)
		{
			// Don't display hidden formfields
			if (!$arrData['eval']['feEditable'])
			{
				continue;
			}

			$strClass = $GLOBALS['TL_FFL'][$arrData['inputType']];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}

			$arrData['eval']['tableless'] = false;
			$arrData['eval']['mandatory'] = ($arrData['eval']['mandatory'] && $blnCheckMandatory);
			$arrData['eval']['required'] = $arrData['eval']['mandatory'];

			$objWidget = new $strClass($this->prepareForWidget($arrData, $field.$strSuffix, $arrData['default']));
			$objWidget->storeValues = true;

			// Validate input
			if ($this->Input->post('FORM_SUBMIT') == $this->strFormId)
			{
				$objWidget->validate();

				if ($objWidget->hasErrors())
				{
					$this->doNotSubmit = true;
				}
			}

			$arrWidgets[$field] = $objWidget;
		}

		return $arrWidgets;
	}
}

