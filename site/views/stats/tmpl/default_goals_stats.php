<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_goals_stats.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage stats
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use Joomla\CMS\Language\Text;
?>

<div id="jl_stats">

<div class="jl_substats">
<table class="<?php echo $this->config['goals_table_class'];?>">
<thead>
	<tr class="sectiontableheader">
		<th colspan="2"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS');?></th>
	</tr>
</thead>
<tbody>
	<tr  class="sectiontableentry1">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_TOTAL');?>:</td>
		<td class="statvalue"><?php echo $this->totals->sumgoals;?></td>
	</tr>
	<tr  class="sectiontableentry2">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_TOTAL_PER_MATCHDAY');?>:</td>
		<td class="statvalue"><?php
			if (	 $this->totals->playedmatches > 0 )
			{
				echo round ((($this->totals->sumgoals / $this->totals->playedmatches) *
				($this->totals->totalmatches / $this->totalrounds)),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	<tr  class="sectiontableentry1">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_TOTAL_PER_MATCH');?>:</td>
		<td class="statvalue"><?php
			if (	 $this->totals->playedmatches>0 )
			{
				echo round (($this->totals->sumgoals / $this->totals->playedmatches),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	
	<?php	if ( $this->config['home_away_stats'] ): ?>
	<tr  class="sectiontableentry2">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_HOME');?></td>
		<td class="statvalue"><?php echo $this->totals->homegoals;?></td>
	</tr>
	<tr  class="sectiontableentry1">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_HOME_PER_MATCHDAY');?>:</td>
		<td class="statvalue"><?php
			if ( $this->totals->playedmatches>0 )
			{
				echo round((($this->totals->homegoals / $this->totals->playedmatches) *
				($this->totals->totalmatches / $this->totalrounds)),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	<tr  class="sectiontableentry2">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_HOME_PER_MATCH');?>:</td>
		<td class="statvalue"><?php
			if ( $this->totals->playedmatches > 0 )
			{
				echo round(($this->totals->homegoals / $this->totals->playedmatches),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	<tr  class="sectiontableentry1">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_AWAY');?></td>
		<td class="statvalue"><?php echo $this->totals->guestgoals;?></td>
	</tr>
	<tr  class="sectiontableentry2">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_AWAY_PER_MATCHDAY');?>:</td>
		<td class="statvalue"><?php
			if ( $this->totals->playedmatches > 0 )
			{
				echo round((($this->totals->guestgoals / $this->totals->playedmatches) *
				($this->totals->totalmatches / $this->totalrounds)),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	<tr  class="sectiontableentry1">
		<td class="statlabel"><?php echo Text::_('COM_SPORTSMANAGEMENT_STATS_GOALS_AWAY_PER_MATCH');?>:</td>
		<td class="statvalue"><?php
			if ( $this->totals->playedmatches > 0 )
			{
				echo round(($this->totals->guestgoals / $this->totals->playedmatches),2);
			}
			else
			{
				echo '0';
			}
			?>
		</td>
	</tr>
	<?php endif;	?>
</tbody>	
</table>
</div>

</div>
