<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      projectlist.php
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
 * FormFieldprojectlist
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class JFormFieldprojectlist extends \JFormFieldList
{
	/**
	 * field type
	 * @var string
	 */
	public $type = 'projectlist';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$app = JFactory::getApplication();
        // Initialize variables.
		$options = array();
    
    $db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$query->select('l.id AS value, l.name AS text');
            if ( defined(COM_SPORTSMANAGEMENT_TABLE) )
            {
            $query->from('#__'.COM_SPORTSMANAGEMENT_TABLE.'_project as l');    
            }
            else
            {
            $query->from('#__sportsmanagement_project as l');    
            }
			
			$query->order('l.name');
           
			$db->setQuery($query);
			$options = $db->loadObjectList();
    
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
