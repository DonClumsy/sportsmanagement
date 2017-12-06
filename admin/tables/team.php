<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

// import Joomla table library
jimport('joomla.database.table');

// Include library dependencies
jimport('joomla.filter.input');


/**
 * sportsmanagementTableTeam
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementTableTeam extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
	   $db = sportsmanagementHelper::getDBConnection();
		parent::__construct('#__'.COM_SPORTSMANAGEMENT_TABLE.'_team', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		if (empty($this->name)) {
			$this->setError(JText::_('NAME REQUIRED'));
			return false;
		}
		
		// add default middle size name
		if (empty($this->middle_name)) {
			$parts = explode(" ", $this->name);
			$this->middle_name = substr($parts[0], 0, 20);
		}
	
		// add default short size name
		if (empty($this->short_name)) {
			$parts = explode(" ", $this->name);
			$this->short_name = substr($parts[0], 0, 2);
		}
	
		// setting alias
        $this->alias = JFilterOutput::stringURLSafe( $this->name );
        
//		if ( empty( $this->alias ) )
//		{
//			$this->alias = JFilterOutput::stringURLSafe( $this->name );
//		}
//		else {
//			$this->alias = JFilterOutput::stringURLSafe( $this->alias ); // make sure the user didn't modify it to something illegal...
//		}
		
		return true;
	}
	
    /**
     * sportsmanagementTableTeam::bind()
     * 
     * @param mixed $array
     * @param string $ignore
     * @return
     */
    public function bind($array, $ignore = '')
   {
      //$app = JFactory::getApplication();
      //$option = JFactory::getApplication()->input->getCmd('option');
      //$app->enqueueMessage(JText::_('sportsmanagementTableTeam bind season_ids<br><pre>'.print_r($array,true).'</pre>'   ),'');
      //$app->enqueueMessage(JText::_('sportsmanagementTableTeam bind season_ids<br><pre>'.print_r($array['season_ids'],true).'</pre>'   ),'');
        
      if (isset($array['season_ids']) && is_array($array['season_ids'])) {
         $array['season_ids'] = implode(',', $array['season_ids']);
      }
      return parent::bind($array, $ignore);
   }
    
    
	
	
}
?>
