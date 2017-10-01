<?php
/**
 * @package		jVArcade
 * @version		2.14
 * @date		2016-03-12
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */


defined('_JEXEC') or die;?>
<script>
jQuery(document).ready(function($) {
	   $('#avatarUpload').on('hide', function (){
		   $("#avatar-img").load(location.href+" #avatar-img>*",""); 
		   $('body').removeClass('modal-open');   
	   });
});
</script>
<div id="puarcade_wrapper">
<?php include_once(JVA_TEMPLATES_INCPATH . 'menu.php');?>
	<?php echo JHtml::_('bootstrap.renderModal', 'avatarUpload', array('url' => JRoute::_('index.php?option=com_jvarcade&task=uploadavatar&tmpl=component&id=' . $this->user->id, false), 'title' => JText::_('COM_JVARCADE_UPLOAD_AVATAR_MODAL_TITLE'), 'height' => '250', 'backdrop' => 'static', 'modalWidth' => '50'));?>

<div class="pu_heading" style="text-align: center;"><?php echo JText::_('COM_JVARCADE_PROFILE_TITLE'); ?></div>
	<div class="profile-row">
		
			<div class="avatar-clickarea">
				<?php if ($this->user->id == $this->userToProfile->id) :?>
					<a href="#avatarUpload" data-toggle="modal" id="edit-avatar" class="hasTooltip" data-original-title="<strong><?php echo JText::_('COM_JVARCADE_PROFILE_EDIT_AVATAR'); ?></strong>" >
				<?php endif; ?>
					<div id="avatar-img"><?php echo jvaHelper::showProfileAvatar($this->userToProfile->id);?></div>
				<?php if ($this->user->id == $this->userToProfile->id) :?>
					</a>
				<?php endif; ?>
				<div class="user-online">
				<?php if ($this->useronline) :?>
					<img src="<?php echo JVA_IMAGES_SITEPATH . 'icons/online.png' ?>">
				<?php else :?>
					<img src="<?php echo JVA_IMAGES_SITEPATH . 'icons/offline.png' ?>">
				<?php endif; ?>
				</div>
			</div>
			<div class="pu_AddMargin"></div>
			<div class="info-area">
			<h4><?php echo JText::_('COM_JVARCADE_USERNAME') . $this->userToProfile->username; ?></h4>
			<h4>Scores: <?php echo $this->totalScores; ?></h4>
			<h4>High Scores: <?php echo $this->totalHighScores; ?></h4>
			<h4>Leaderboard Position: <?php echo $this->lbPos; ?></h4>
			<h4>Leaderboard Points: <?php echo $this->lbPoints; ?></h4>
			</div>
	</div>


	<div class="pu_block_container">
		
		<?php echo JHtml::_('bootstrap.startTabSet', 'protabset', array('active' => 'scores'));
			echo JHtml::_('bootstrap.addTab', 'protabset', 'scores', JText::_('COM_JVARCADE_LATEST_SCORES'));?>
			<div class="pu_heading" style="text-align: center;"><?php echo JText::_('COM_JVARCADE_LATEST_SCORES'); ?></div>
			<div class="pu_ListContainer">
				<table class="pu_ListHeader">
					<tr>
						<th width="25%" style="text-align: center;">
						<?php echo JText::_('COM_JVARCADE_DATE'); ?>
						</th>
						<th width="25%" style="text-align: center;">
						<?php echo JText::_('COM_JVARCADE_GAME_SELECTION'); ?>
						</th>
						<th width="25%" style="text-align: center;">
						<?php echo JText::_('COM_JVARCADE_SCORES'); ?>
						</th>
					</tr>
				</table>
			</div>
				<div id="FlashTable">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<?php foreach ($this->userLatestScores as $score) : ?>
					<tr class="sectiontableentry1">
					<td width="25%" style="text-align: center;"><?php echo jvaHelper::formatDate($score['date']); ?></td>
					<td width="25%" style="text-align: center;"><a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=game&id=' . $score['id'], false); ?>">
						<img src="<?php echo JVA_IMAGES_SITEPATH . 'games/' . $score['imagename'];?>" height="50px" width="50px" class="hasTooltip" data-original-title="<strong><?php echo $score['title']; ?></strong>">
					</a></td>
					<td><a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=game&id=' . $score['id'], false); ?>" class="hasTooltip" data-original-title="<strong><?php echo $score['title']; ?></strong></br><?php echo $score['description']; ?>">
						<b><?php echo jvaHelper::truncate(stripslashes($score['title']), (int)$this->config->truncate_title); ?></b></a></td>
					<td width="25%" style="text-align: center;"><?php echo rtrim(rtrim(number_format($score['score'],2), '0'), '.'); ?></td>
				</tr>
					<?php endforeach;?>
					</table>
				</div>
			<table id="pufooter" class="pu_Listfooter"><tr><td>&nbsp;</td></tr></table>
	
		<?php echo JHtml::_('bootstrap.endTab'); 
		echo JHtml::_('bootstrap.addTab', 'protabset', 'faves', JText::_('Favourite Games'));?>
			<div class="pu_heading" style="text-align: center;"><?php echo JText::_('Favourite Games'); ?></div>
			<div class="pu_ListContainer">
				<table class="pu_ListHeader">
					<tr>
						<th width="10%" style="text-align: center;">
							<?php echo JText::_('COM_JVARCADE_GAME_ID'); ?>
						</th> 
						<th colspan="2" width="16%" style="text-align: center;">
							<?php echo JText::_('COM_JVARCADE_GAME_SELECTION'); ?>
						</th> 
						<th width="10%" style="text-align: center;">
							<?php echo JText::_('COM_JVARCADE_TIMES_PLAYED'); ?>
						</th>
						<th width="14%" style="text-align: center;">
							<b><?php echo JText::_('COM_JVARCADE_HIGH_SCORE'); ?></b>
						</th>
						<?php if ($this->config->contentrating == 1) : ?>
						<th width="7%" style="text-align: center;">
							<?php echo JText::_('COM_JVARCADE_CONTENT'); ?>
						</th>
						<?php endif; ?>
               			 <?php if ($this->config->enable_dload == 1 && $this->can_dload) : ?>
               			<th width="6%" style="text-align: center;"><b>Download</b>
               			</th>
               			<?php endif ?>
					</tr>
			</table>
		</div>
				<div id="FlashTable">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<?php foreach ($this->faves as $game) : ?>
					<?php $alt = htmlspecialchars(stripslashes($game['title'])); ?>
			<tr class="sectiontableentry">
				<td width="10%">
					<center><?php echo $game['game_id']; ?></center>
				</td>
				<td width="10%">
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=game&id=' . $game['id'], false); ?>">
						<img src="<?php echo JVA_IMAGES_SITEPATH . 'games/' . $game['imagename']; ?>" border="0" height="50" width="50" class="hasTooltip" data-original-title="<strong><?php echo $alt; ?></strong>"/>
					</a>
				</td>
				<td width="20%">
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=game&id=' . $game['id'], false); ?>" class="hasTooltip" data-original-title="<strong><?php echo $alt; ?></strong></br><?php echo html_entity_decode($game['game_desc'], ENT_QUOTES, 'UTF-8'); ?>">
						<b><?php echo jvaHelper::truncate(stripslashes($game['title']), (int)$this->config->truncate_title); ?></b>
					</a>
					<br /><?php //echo html_entity_decode($game['game_desc'], ENT_QUOTES, 'UTF-8'); ?>
				</td>
				<td width="10%">
					<center><?php echo $game['numplayed']; ?></center>
				</td>
				<td width="20%">
					<center>
					<?php if ($game['scoring']) : ?>
						<?php if (array_key_exists('highscore', $game) && count($game['highscore']) && (int)$game['highscore']['score']) : ?>
								<b><?php echo JText::_('COM_JVARCADE_HIGH_SCORE') ?> : <?php echo $game['highscore']['score'] ?></b><br/>
								<b><?php echo JText::_('COM_JVARCADE_SCORE_BY') ?> :<?php echo $game['highscore']['username'] ?></b><br/>
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=scores&id=' . $game['id'], false) ?>">[<?php echo JText::_('COM_JVARCADE_ALL_SCORES')?>]</a>
						<?php else : ?>
								<h4><?php echo JText::_('COM_JVARCADE_NO_SCORES') ?></h4>
						<?php endif; ?>
					<?php else : ?>
						<h4><?php echo JText::_('COM_JVARCADE_SCORING_DISABLED') ?></h4>
					<?php endif; ?>
					</center>
				</td>
				<?php if ($this->config->contentrating == 1) : ?>
				<td width="10%">
					<?php if ($game['rating_image']) : ?>
					<center><img src="<?php echo JVA_IMAGES_SITEPATH . 'contentrating/' . $game['rating_image']; ?>" alt="<?php echo $game['rating_desc']; ?>"  title="<?php echo $game['rating_desc']; ?>" /></center>
					<?php endif; ?>
				</td>
				<?php endif; ?>
                <?php if ($this->config->enable_dload == 1 && $this->can_dload) : ?>
                <td width="8%"><center><a href="javascript:void(0)" onclick="jQuery.jva.downloadGame(<?php echo $game['id']; ?>); return false;"><img src="<?php echo JVA_IMAGES_SITEPATH; ?>dl.png" /></a></td><?php endif; ?>
			</tr>
					<?php endforeach;?>
					</table>
				</div>
			<table id="pufooter" class="pu_Listfooter"><tr><td>&nbsp;</td></tr></table>
			<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&task=favourite&uid='. $this->userToProfile->id );?>"><?php echo JText::_('View Players Favourites'); ?></a>
		<?php echo JHtml::_('bootstrap.endTab');
			echo JHtml::_('bootstrap.endTabSet');?>
	</div>
	<?php include_once(JVA_TEMPLATES_INCPATH . 'footer.php'); ?>
</div>