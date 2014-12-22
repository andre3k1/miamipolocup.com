<?php
/**
 * Progress Indicators (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
				<?php
					$launchDate = ler('lefx_proglaunchdate');

					if($launchDate == 0) { $launchDate = '1/1/2011'; }

					$launchDate = explode('/',$launchDate);

					$startDate = ler('lefx_progstartdate');
					$endDate = ler('lefx_proglaunchdate');

					if($startDate == 0) { $startDate = '1/1/2011'; }
					if($endDate == 0) { $endDate = '1/2/2011'; }

					$startDate =  strtotime($startDate);
					$nowDate = time();
					$endDate =  strtotime($endDate);

					$duration = $endDate - $startDate;
					$timeLeft = $endDate - $nowDate;

					if ($timeLeft < 1) { $timeLeft = 0; }

					$daysLeft = $timeLeft/86400;

					if ($duration > 0) {
						$complete = (($duration - $timeLeft)/$duration)*100;
					}

				?>

				<input type="hidden" id="launchMonth" value="<?php echo $launchDate[0]; ?>" />
				<input type="hidden" id="launchDay" value="<?php echo $launchDate[1]; ?>" />
				<input type="hidden" id="launchYear" value="<?php echo $launchDate[2]; ?>" />
				<?php if(get_option('lefx_progbarenable') == 'true' || get_option('lefx_progcountenable') == 'true'): ?>

					<div id="progress-container">

						<h3>
						<?php

							if($timeLeft !== 0) {
								le('lefx_progtitle');
							} else {
								le('lefx_progtitlecomplete');
							}

						?>
						</h3>

				<?php endif; ?>
				<?php if(get_option('lefx_progbarenable') == 'true'): ?>

					<div id="bar" <?php if(ler('lefx_progbarstyle') == 'Stylish') { echo 'class="stylish"'; } ?>>

						<input type="hidden" class="barComplete" value="<?php echo round($complete); ?>" />
						<div id="bar-complete"><span><?php echo round($complete); ?>%</span></div>

					</div>

				<?php endif; ?>
				<?php if(get_option('lefx_progcountenable') == 'true'):

						echo '<div id="tearoff" class="';

						$countdownStyle = ler('lefx_progcountstyle');
						$countdownBg = ler('lefx_progunit');

						switch ($countdownStyle) {
						    case "Minimal":
						        echo "simple fliplight ";
						        break;
						    case "Stylish Light":
						        echo "stylish fliplight ";
						        break;
						    case "Stylish Dark":
						        echo "stylish flipdark ";
						        break;
						}

						echo '">';

					?>

						<input type="hidden" class="daysLeft" value="<?php echo round($daysLeft); ?>" />

						<div class="tearoff">
							<span class="overlay"></span>
							<span class="background"><span class="number">{dnn}</span></span>
							<span class="unit"><?php le('lefx_progcountdays'); ?></span>
						</div>
						<div class="tearoff" id="minutes">
							<span class="overlay"></span>
							<span class="background"><span class="number">{hnn}</span></span>
							<span class="unit"><?php le('lefx_progcounthours'); ?></span>
						</div>
						<div class="tearoff" id="hours">
							<span class="overlay"></span>
							<span class="background"><span class="number">{mnn}</span></span>
							<span class="unit"><?php le('lefx_progcountmins'); ?></span>
						</div>
						<div class="tearoff" id="seconds">
							<span class="overlay"></span>
							<span class="background seconds"><span class="number">{snn}</span></span>
							<span class="unit"><?php le('lefx_progcountsecs'); ?></span>
						</div>
						<div class="over"></div>
					</div>

					<div class="over"></div>

				<?php endif; ?>
				<?php if(get_option('lefx_progbarenable') == 'true' || get_option('lefx_progcountenable') == 'true') echo '</div>'; ?>
