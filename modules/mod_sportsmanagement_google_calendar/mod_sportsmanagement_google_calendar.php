<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      mod_sportsmanagement_google_calendar.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage mod_sportsmanagement_google_calendar
 */

defined('_JEXEC') or die;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;

try
{
	// Require the module helper file
	require_once __DIR__ . '/helper.php';

	// Get a new ModGCalendarHelper instance
	$helper = new ModJSMGoogleCalendarHelper($params);

	// Setup joomla cache
	$cache = Factory::getCache();
	$cache->setCaching(true);
	$cache->setLifeTime($params->get('api_cache_time', 60));

	// Get the next events
	$events = $cache->call(
		array($helper, 'nextEvents'),
		(int) $params->get('max_list_events', 5)
	);

	// Get the Layout
	require ModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));
}
catch(Exception $e)
{
	Factory::getApplication()->enqueueMessage(
		'JSM Google Calendar error: ' . $e->getMessage(), 'error'
	);
}
