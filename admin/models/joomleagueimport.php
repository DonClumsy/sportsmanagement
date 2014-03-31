<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
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
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');
jimport('joomla.application.component.modellist');

$maxImportTime = 1920;
if ((int)ini_get('max_execution_time') < $maxImportTime){@set_time_limit($maxImportTime);}

/**
 * sportsmanagementModeljoomleagueimport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModeljoomleagueimport extends JModelList
{




/**
 * sportsmanagementModeljoomleagueimport::newstructur()
 * 
 * @param mixed $step
 * @param integer $count
 * @return void
 */
function newstructur($step,$count=5)
{
    $mainframe = JFactory::getApplication();
        $db = JFactory::getDbo(); 
        $option = JRequest::getCmd('option');
        $starttime = microtime(); 
        
        $season_id = $mainframe->getUserState( "$option.season_id", '0' );
        
//        $post = JRequest::get('post');
//        $exportfields = array();
//        $cid = $post['cid'];
//        $jl = $post['jl'];
//        $jsm = $post['jsm'];
    

            // Select some fields
            $query = $db->getQuery(true);
            $query->clear();
		    $query->select('pt.id,pt.project_id,pt.team_id');
            $query->select('p.season_id');
            // From table
		    $query->from('#__sportsmanagement_project_team AS pt');
            $query->join('INNER','#__sportsmanagement_project AS p ON p.id = pt.project_id');
            $query->where('pt.import = 0');
            
            if ( $season_id )
            {
                $query->where('p.season_id = '.$season_id);
            }
            
            $db->setQuery($query,$step,$count);
            
            if ( COM_SPORTSMANAGEMENT_SHOW_QUERY_DEBUG_INFO )
        {
        $mainframe->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' Ausfuehrungszeit query<br><pre>'.print_r(sportsmanagementModeldatabasetool::getQueryTime($starttime, microtime()),true).'</pre>'),'Notice');
        }
        
            $result = $db->loadObjectList();
            
            foreach ( $result as $row )
            {
                // Create and populate an object.
                $temp = new stdClass();
                $temp->season_id = $row->season_id;
                $temp->team_id = $row->team_id;
                // Insert the object into the user profile table.
                $result = JFactory::getDbo()->insertObject('#__sportsmanagement_season_team_id', $temp);
                if ( $result )
                {
                    $new_id = $db->insertid();
                }
                else
                {
                    // Select some fields
                    $query = $db->getQuery(true);
                    $query->clear();
		            $query->select('id');
                    // From table
                    $query->from('#__sportsmanagement_season_team_id');
                    $query->where('season_id = '.$row->season_id);
                    $query->where('team_id = '.$row->team_id);
                    $new_id = $db->loadResult();
                }
                
                // Create an object for the record we are going to update.
                $object = new stdClass();
                // Must be a valid primary key value.
                $object->id = $row->id;
                $object->team_id = $new_id;
                $object->import = 1;
                // Update their details in the users table using id as the primary key.
                $result = JFactory::getDbo()->updateObject('#__sportsmanagement_project_team', $object, 'id'); 
                
                
            }
            
            
            // danach die alten datens�tze l�schen
            //$db->truncateTable($jsm_table);
 
            
            
             

}


            
}    

?>