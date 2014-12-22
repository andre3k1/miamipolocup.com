<?php
/**
 * Custom Fields (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
						<?php
							$fields = array();
							for($i=1; $i<=10; $i++) {
								if(get_option("lefx_cust_field{$i}") != '') {
									$fields[get_option("lefx_cust_field{$i}_order")]['name'] = get_option("lefx_cust_field{$i}");
									$fields[get_option("lefx_cust_field{$i}_order")]['req'] = get_option("lefx_cust_field{$i}_required");
									$fields[get_option("lefx_cust_field{$i}_order")]['type'] = get_option("lefx_cust_field{$i}_type");
									$fields[get_option("lefx_cust_field{$i}_order")]['id'] = "field{$i}";
									$fields[get_option("lefx_cust_field{$i}_order")]['index'] = $i;
								}
							}
						?>
						<?php for($i=0; $i<count($fields); $i++) : ?>
							<?php if (isset($fields[$i]['name'])) : $field_type = $fields[$i]['type']; ?>

								<li>
									<label><?php echo $fields[$i]['name'] ?><?php if($fields[$i]['req'] && ler('lefx_req_indicator')) echo '<span> *</span>'; ?></label>
									<?php
									$close_field = false;
									if (substr($field_type, 0, 4) != 'text') {
										$close_field = true;
										echo '<div class="fieldset">';
										$options = get_option("lefx_cust_field{$fields[$i]['index']}_option_values");
										$options = explode(",", $options);
									}
									switch ($field_type) : case "textbox": ?>

									<input type="text" id="custom_field<?php echo $fields[$i]['index'] ?>" name="<?php echo $fields[$i]['id']; ?>" maxlength="250" />
										<?php break; case "textarea" :?>

									<textarea name="<?php echo $fields[$i]['id']; ?>" rows="10" cols="40" maxlength="250"></textarea>
										<?php break; case "dropdown":?>

										<select name="<?php echo $fields[$i]['id']; ?>">
											<?php foreach($options as $opt):?><option value="<?php echo htmlspecialchars($opt) ?>"><?php echo $opt?></option><?php endforeach;?>

										</select>
										<?php break; case "checkboxes": foreach($options as $k => $opt):?>

										<div class="checkbox-group">
											<input type="checkbox" id="<?php echo $fields[$i]['id'] . "$k"; ?>" value="<?php echo $opt?>" name="<?php echo $fields[$i]['id']; ?>[]" />
											<label for="<?php echo $fields[$i]['id'] . "$k"; ?>"><?php echo $opt?></label>
										</div>
										<?php endforeach; break; case "radiobuttons": foreach($options as $k => $opt):?>

										<div class="radio-group">
											<input type="radio" id="<?php echo $fields[$i]['id'] . "$k"; ?>" value="<?php echo $opt?>" name="<?php echo $fields[$i]['id']; ?>[]" />
											<label for="<?php echo $fields[$i]['id'] . "$k"; ?>"><?php echo $opt?></label>
										</div>
										<?php endforeach; break; endswitch; ?>

										<?php if ($close_field): ?>

										</div>
										<?php endif; ?>

									<div class="error" id="lefx_cust_field<?php echo $fields[$i]['index']; ?>">This field is required.</div>
								</li>
							<?php endif; ?>
						<?php endfor; ?>