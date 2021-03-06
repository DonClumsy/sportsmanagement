<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage jlextdfbkeyimport
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * sportsmanagementViewjlextdfbkeyimport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2013
 * @access public
 */
class sportsmanagementViewjlextdfbkeyimport extends sportsmanagementView {

    /**
     * sportsmanagementViewjlextdfbkeyimport::init()
     * 
     * @return
     */
    public function init() {
        $tpl = '';
        $this->division_id = $this->jinput->get('divisionid');
        
        switch ($this->getLayout())
        {
        case 'default':  
        case 'default_3':
        case 'default_4':
        $this->setLayout('default');
        $this->_displayDefault($tpl);
        return;  
        break;
        case 'default_createdays':  
        case 'default_createdays_3':
        case 'default_createdays_4':
        $this->setLayout('default_createdays');
        $this->_displayDefaultCreatedays($tpl);
        return;  
        break;
        case 'default_firstmatchday':  
        case 'default_firstmatchday_3':
        case 'default_firstmatchday_4':
        $this->setLayout('default_firstmatchday');
        $this->_displayDefaultFirstMatchday($tpl);
        return;  
        break; 
        case 'default_savematchdays':  
        case 'default_savematchdays_3':
        case 'default_savematchdays_4':
        $this->setLayout('default_savematchdays');
        $this->_displayDefaultSaveMatchdays($tpl);
        return;  
        break; 
        case 'default_getdivision':  
        case 'default_getdivision_3':
        case 'default_getdivision_4':
        $this->setLayout('default_getdivision');
        $this->_displayDefaultGetDivision($tpl);
        return;  
        break;     
        }
        
       
     
    }

 /**
  * sportsmanagementViewjlextdfbkeyimport::_displayDefaultGetDivision()
  * 
  * @param mixed $tpl
  * @return void
  */
 function _displayDefaultGetDivision($tpl) {

$mdl_divisions = BaseDatabaseModel::getInstance("Divisions", "sportsmanagementModel");  
$projectdivisions = $mdl_divisions->getDivisions($this->project_id);  
$this->division = 0;
$divisionsList[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_DIVISION'));
		
		if ($projectdivisions)
		{ 
			$projectdivisions = array_merge($divisionsList,$projectdivisions);
		}
		
		$lists['divisions'] = $projectdivisions;
        $this->lists = $lists;
JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects');  
JToolbarHelper::save('jlextdfbkeyimport.getdivisionfirst', 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_USE_DIVISION');

 }
 
    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefault()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefault($tpl) {

$this->division_id = $this->jinput->get('divisionid');
$project_type = $this->model->getProjectType($this->project_id);    

$this->app->enqueueMessage($project_type, 'notice');
if ( $project_type == 'DIVISIONS_LEAGUE' )
{
if ( !$this->division_id )
{
$this->app->redirect('index.php?option=' . $this->option . '&view=jlextdfbkeyimport&layout=default_getdivision'); 
}
}
        $istable = $this->model->checkTable();

        if (empty($this->project_id)) {
            JError::raiseWarning(500, Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_1'));
            $this->app->redirect('index.php?option=' . $this->option . '&view=projects');
        } else {
            // project selected. projectteams available ?
            //build the html options for projectteams
            if ( $res = $this->model->getProjectteams($this->project_id,$this->division_id) ) {
                $projectteams[] = HTMLHelper::_('select.option', '0', '- ' . Text::_('Select projectteams') . ' -');
                $projectteams = array_merge($projectteams, $res);
                $lists['projectteams'] = $projectteams;


                $dfbteams = count($projectteams) - 1;

                if ($resdfbkey = $this->model->getDFBKey($dfbteams, 'FIRST')) {
                    $dfbday = array();
                    $dfbday = array_merge($dfbday, $resdfbkey);
                    $lists['dfbday'] = $dfbday;
                    unset($dfbday);

                    // matchdays available ?
                    if ( $resmatchdays = $this->model->getMatchdays($this->project_id) ) {

                        // matches available
                        if ( $resmatches = $this->model->getMatches($this->project_id,$this->division_id) ) {
                            JError::raiseNotice(500, Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_2'));
                            JError::raiseWarning(500, Text::sprintf('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_7', $resmatches));
                            $this->app->redirect('index.php?option=' . $this->option . '&view=rounds');
                        } else {
//        JError::raiseWarning( 500, Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_3' ) );
//        JError::raiseNotice( 500, Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_4' ) );
                            $this->app->redirect('index.php?option=' . $this->option . '&view=jlextdfbkeyimport&layout=default_firstmatchday&divisionid='.$this->division_id);
                        }
                    } else {
                        JError::raiseWarning(500, Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_3'));
                        JError::raiseNotice(500, Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_4'));
                        $this->app->redirect('index.php?option=' . $this->option . '&view=jlextdfbkeyimport&layout=default_createdays&divisionid='.$this->division_id);
                    }
                } else {
                    $procountry = $this->model->getCountry($this->project_id);
                    //JError::raiseWarning( 500, Text::_( '[DFB-Key Tool] Error: No DFB-Key for '.$dfbteams.'  Teams available!' ) );
                    JError::raiseWarning(500, Text::sprintf('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_6', $dfbteams, JSMCountries::getCountryFlag($procountry), $procountry));
                    $this->app->redirect('index.php?option=' . $this->option . '&view=projects');
                }

                unset($projectteams);
            } else {
//    JError::raiseNotice( 500, Text::_( '[DFB-Key Tool] Notice: No Teams assigned!' ) );
                JError::raiseError(500, Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_5'));
                $this->app->redirect('index.php?option=' . $this->option . '&view=projectteams');
            }
        }
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultCreatedays()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultCreatedays($tpl) {

        $this->division_id = $this->jinput->get('divisionid');

	    
        if ( $res = $this->model->getProjectteams($this->project_id,$this->division_id) ) {
            $projectteams[] = HTMLHelper::_('select.option', '0', '- ' . Text::_('Select projectteams') . ' -');
            $projectteams = array_merge($projectteams, $res);
            $dfbteams = count($projectteams) - 1;
            if ($resdfbkey = $this->model->getDFBKey($dfbteams, 'ALL')) {
                /*
                  echo '<pre>';
                  print_r($resdfbkey);
                  echo '</pre>';
                 */
                $this->newmatchdays = $resdfbkey;
            }
            unset($projectteams);
        }

        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $this->document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects'); 
        JToolbarHelper::save('jlextdfbkeyimport.save', 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_INSERT_ROUNDS');
        JToolbarHelper::divider();
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultFirstMatchday()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultFirstMatchday($tpl) {
       
        $this->division_id = $this->jinput->get('divisionid');

        if ($res = $this->model->getProjectteams($this->project_id,$this->division_id)) {
            $projectteams[] = HTMLHelper::_('select.option', '0', '- ' . Text::_('Select projectteams') . ' -');
            $projectteams = array_merge($projectteams, $res);
            $lists['projectteams'] = $projectteams;


            $dfbteams = count($projectteams) - 1;
            if ($resdfbkey = $this->model->getDFBKey($dfbteams, 'FIRST')) {
                $dfbday = array();
                $dfbday = array_merge($dfbday, $resdfbkey);
                $lists['dfbday'] = $dfbday;
                unset($dfbday);
            }
        }

        $this->lists = $lists;
        $this->dfbteams = $dfbteams;

        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $this->document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_FIRST_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects');
        JToolbarHelper::apply('jlextdfbkeyimport.apply', 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_INSERT_FIRST_DAY');
        JToolbarHelper::divider();
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultSaveMatchdays()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultSaveMatchdays($tpl) {
// retrieve the value of the state variable. If no value is specified,
// the specified default value will be returned.
// function syntax is getUserState( $key, $default );
$post = $this->app->getUserState( "$this->option.first_post", '' );
        
        $this->division_id = $this->jinput->get('divisionid');
        $this->import = $this->model->getSchedule($post, $this->project_id,$this->division_id);

        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $this->document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_SAVE_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects');
        JToolbarHelper::save('jlextdfbkeyimport.insert', 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_INSERT_MATCHDAYS');
        JToolbarHelper::divider();

    }

}

?>
