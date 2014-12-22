<?php
/**
 * Search Form Template (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>

	<form action="<?php echo home_url(); ?>" method="get" id="search-form">
		<input type="text" id="search_box" name="s" value="Enter to Search" class="empty" onfocus="if(this.value == 'Enter to Search') this.value = '';" onblur="if(this.value == '') this.value = 'Enter to Search';">
		<a id="search_btn" style="">Search</a>
	</form>