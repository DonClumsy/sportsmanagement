<?php
/**
 * @copyright	Copyright (C) 2013 fussballineuropa.de. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');


/**
 * Sportsmanagement Component Leagues Model
 *
 * @package	Sportsmanagement
 * @since	0.1
 */
class sportsmanagementModelsmquotes extends JModelList
{
	var $_identifier = "smquotes";
	
	public function __construct($config = array())
        {   
                $config['filter_fields'] = array(
                        'obj.quote',
                        'obj.id',
                        'obj.ordering'
                        );
                parent::__construct($config);
        }
    
    /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        // Initialise variables.
		$app = JFactory::getApplication('administrator');
        
        //$mainframe->enqueueMessage(JText::_('sportsmanagementModelsmquotes populateState context<br><pre>'.print_r($this->context,true).'</pre>'   ),'');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
		$this->setState('filter.category_id', $categoryId);


//		// Load the parameters.
//		$params = JComponentHelper::getParams('com_sportsmanagement');
//		$this->setState('params', $params);

		// List state information.
		parent::populateState('obj.quote', 'asc');
	}
    
    
    
    
    protected function getListQuery()
	{
		$mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $search	= $this->getState('filter.search');
        $filter_state = $this->getState('filter.state');
        $filter_catid = $this->getState('filter.category_id');

        // Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('obj.*');
		// From the hello table
		$query->from('#__'.COM_SPORTSMANAGEMENT_TABLE.'_rquote as obj');
        // Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id = obj.checked_out');
        
        // Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = obj.catid');
        
        

        if ( $search  )
		{
        $query->where('LOWER(obj.author) LIKE '.$this->_db->Quote('%'.$search.'%'));
        }
        if ( $filter_state )
		{
        $query->where('obj.published = '.$filter_state);
        }
        if ( $filter_catid )
		{
        $query->where('obj.catid = '.$filter_catid);
        }
        

        
        $query->order($db->escape($this->getState('list.ordering', 'obj.quote')).' '.
                $db->escape($this->getState('list.direction', 'ASC')));
 
		//$mainframe->enqueueMessage(JText::_('leagues query<br><pre>'.print_r($query,true).'</pre>'   ),'');
        return $query;
	}

	
}
?>