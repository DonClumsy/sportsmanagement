<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage agegroups
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;

/**
 * sportsmanagementViewagegroups
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewagegroups extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewagegroups::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
        $mdlSportsType = BaseDatabaseModel::getInstance('SportsType', 'sportsmanagementModel');
       
        $this->table = Table::getInstance('agegroup', 'sportsmanagementTable');
		
        //build the html select list for sportstypes
		$sportstypes[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_SPORTSTYPE_FILTER'),'id','name');
		$mdlSportsTypes = BaseDatabaseModel::getInstance('SportsTypes', 'sportsmanagementModel');
		$allSportstypes = $mdlSportsTypes->getSportsTypes();
		$sportstypes = array_merge($sportstypes, $allSportstypes);
        $this->sports_type = $allSportstypes;
		
		$lists['sportstypes'] = HTMLHelper::_( 'select.genericList',
							$sportstypes,
							'filter_sports_type',
							'class="inputbox" onChange="this.form.submit();" style="width:120px"',
							'id',
							'name',
							$this->state->get('filter.sports_type'));
		unset($sportstypes);
        
        //build the html options for nation
		$nation[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_COUNTRY'));
		if ($res = JSMCountries::getCountryOptions())
		{
			$nation = array_merge($nation,$res);
			$this->search_nation = $res;
		}
		
        $lists['nation'] = $nation;
        $lists['nation2'] = JHtmlSelect::genericlist(	$nation,
						'filter_search_nation',
						'class="inputbox" style="width:140px; " onchange="this.form.submit();"',
						'value',
						'text',
						$this->state->get('filter.search_nation'));
        
        foreach ( $this->items as $item )
        {
            $sportstype = $mdlSportsType->getSportstype($item->sportstype_id);
            if ( $sportstype )
            {
            $item->sportstype = $sportstype->name;
            }
            else
            {
            $item->sportstype = NULL;    
            }
        }
        
        if ( count($this->items)  == 0 )
        {
            $databasetool = BaseDatabaseModel::getInstance("databasetool", "sportsmanagementModel");
            $insert_agegroup = $databasetool->insertAgegroup($this->state->get('filter.search_nation'),$this->state->get('filter.sports_type'));
        $this->app->enqueueMessage(Text::_('COM_SPORTSMANAGEMENT_ADMIN_AGEGROUPS_NO_RESULT'),'Error');
        }

		$this->lists = $lists;
		
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
        // Set toolbar items for the page
        $this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_AGEGROUPS_TITLE');
		JToolbarHelper::addNew('agegroup.add');
		JToolbarHelper::editList('agegroup.edit');
        JToolbarHelper::apply('agegroups.saveshort');
		JToolbarHelper::custom('agegroups.import','upload','upload',Text::_('JTOOLBAR_UPLOAD'),false);
		JToolbarHelper::archiveList('agegroup.export',Text::_('JTOOLBAR_EXPORT'));
        parent::addToolbar();
	}
}
?>