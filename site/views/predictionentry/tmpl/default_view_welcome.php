<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_view_welcome.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage predictionentry
 */

defined('_JEXEC') or die(Text::_('Restricted access'));
use Joomla\CMS\Language\Text;

?><p><?php
	echo Text::_('COM_SPORTSMANAGEMENT_PRED_ENTRY_WELCOME_INFO_01');
	?></p><p><?php
		echo Text::sprintf('COM_SPORTSMANAGEMENT_PRED_ENTRY_WELCOME_INFO_02',$this->config['ownername'],'<b>' . $this->websiteName . '</b>');
	?></p><hr><br />