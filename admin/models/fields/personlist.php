<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      personlist.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage fields
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;

jimport('joomla.filesystem.folder');
FormHelper::loadFieldClass('list');

/**
 * FormFieldpersonlist
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class JFormFieldpersonlist extends \JFormFieldList
{
	/**
	 * field type
	 * @var string
	 */
	public $type = 'personlist';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$app = Factory::getApplication();
        $option = Factory::getApplication()->input->getCmd('option');
        // Initialize variables.
		$options = array();
    
    $db = Factory::getDbo();
			$query = $db->getQuery(true);
			
			$query->select("id AS value, concat(lastname,' - ',firstname,'' ) AS text");
			$query->from('#__'.COM_SPORTSMANAGEMENT_TABLE.'_person ');
			$query->order('lastname');
			$db->setQuery($query);
			$options = $db->loadObjectList();
    
    
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
