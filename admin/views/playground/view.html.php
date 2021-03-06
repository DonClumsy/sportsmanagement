<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage playground
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Uri\Uri; 
use Joomla\CMS\Language\Text;
use Joomla\CMS\Environment\Browser;

/**
 * sportsmanagementViewPlayground
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewPlayground extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewPlayground::init()
	 * 
	 * @return
	 */
	public function init ()
	{
        $this->document->addScript('https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');	
        if ( $this->item->latitude == 255 )
        {
            $this->app->enqueueMessage(Text::_('COM_SPORTSMANAGEMENT_NO_GEOCODE'),'Error');
            $this->map = false;
        }
        else
        {
            $this->map = true;
        }
		
		$this->extended	= sportsmanagementHelper::getExtended($this->item->extended, 'playground');
        
$this->document->addScript((Browser::getInstance()->isSSLConnection() ? "https" : "http") . '://maps.googleapis.com/maps/api/js?libraries=places&language=de');
$this->document->addScript(Uri::base() . 'components/'.$this->option.'/assets/js/geocomplete.js');

if( version_compare(JSM_JVERSION,'4','eq') ) 
{
	}
		else
		{		
		$this->document->addScript(Uri::base() . 'components/'.$this->option.'/views/playground/tmpl/edit.js');
		}

	}
 
	
	/**
	 * sportsmanagementViewPlayground::addToolBar()
	 * 
	 * @return void
	 */
	protected function addToolBar() 
	{
        $this->jinput->set('hidemainmenu', true);
        parent::addToolbar();
	}
    
	
}
