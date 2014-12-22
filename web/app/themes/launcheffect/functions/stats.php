<?php
/**
 * Functions: stats.php
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

class LE_Stats_Admin_Page extends LE_Admin_Page {

	function __construct($args){
		parent::__construct($args);
		$this->suppress_submenu = false;
		if ( is_admin() ) {
			add_action('init', array(&$this, 'export_csv'));
			add_action('admin_menu', array(&$this, 'add_export_menu'));
			add_filter('set-screen-option', array(&$this, 'stats_set_screen_option'), 10, 3);
			add_action('admin_head', array(&$this, 'highlight_current_submenu'), 20);
		}
		add_action('admin_bar_menu', array(&$this, 'insert_le_items'), 20);
	}

	function insert_le_items($admin_bar) {
		$args = array(
			'id'     => 'lefx_designer',
			'parent' => 'site-name',
			'title'  => __('Launch Effect Settings', 'launcheffect'),
			'href'   => admin_url('admin.php?page=lefx_designer'),
			'meta'   => array(
				'title' => __('Edit Launch Effect Settings'),
			),
		);
		$admin_bar->add_menu( $args);
	}

	function highlight_current_submenu() {
		global $menu, $submenu, $submenu_file, $parent_file;
		$exclusions = array( 'lefx_designer', 'lefx_integrations', 'lefx_stats' );
		if ( isset($submenu['lefx_designer']) ) {
			foreach( $submenu['lefx_designer'] as $idx => $menu_set ) {
				// array( 'title', 'capability', 'slug', 'title' );
				if ( !in_array( $menu_set[2], $exclusions) ) {
					unset( $submenu['lefx_designer'][$idx] );
					if ( isset($_GET['page']) && !in_array( $_GET['page'], $exclusions) ) {
						$parent_file = $submenu_file = 'lefx_designer';
						if ( 'lefx_export' == $_GET['page'] ) {
							$submenu_file = 'lefx_stats';
						}
					}
				}
			}
		}
	}

	function add_export_menu(){
	    add_menu_page(
			__('Export CSV', 'launcheffect'),
			__('Export CSV', 'launcheffect'),
			'manage_options',
			'lefx_export',
			array(&$this, 'build_le_export_page')
		);
		remove_menu_page('lefx_export');
		add_action("load-".$this->handle, array(&$this, "stats_screen_options"));
	}

	function stats_screen_options() {
		$screen = get_current_screen();

		// get out of here if we are not on our settings page
		if(!is_object($screen) || $screen->id != $this->handle) return;

		$args = array(
			'label' => __('Results per page', 'launcheffect'),
			'default' => 10,
			'option' => 'stats_per_page'
		);
		add_screen_option( 'per_page', $args );
	}
	function stats_set_screen_option($status, $option, $value) {
		if ( 'stats_per_page' == $option ) return $value;
		return $status;
	}

	function build_le_stats_page(){
		global $wpdb;

	    if (!current_user_can('manage_options')) {
			wp_die( __('You do not have sufficient permissions to access this page.', 'launcheffect') );
	    }
		$view = isset($_GET['view']) ? $_GET['view'] : false;

		if ( isset($_REQUEST['action']) || isset($_REQUEST['action2']) ) {
			$id = $_REQUEST['id'];
			switch($_REQUEST['action']) {
				case "trash":
					// To Delete Rows
					$count = is_array($id)?count($id):1;
					$plurality = _n('These items have', 'This item has', $count, $domain);
					$id = is_array($id) ? 'IN('.implode(',',$id).')' : "= '$id'";
					$stats_table = LE_TABLE;
					$handle = $wpdb->query("DELETE FROM $stats_table WHERE id $id");
					$msg = "$plurality been removed.";
				break;
			}
			if ($handle) {
				add_settings_error(
					'Removed', // setting title
					'item-removed', // error ID
					$msg, // error message
					'updated' // type of message
				);
			}
		} ?>

		<div class="wrap" id="stats-wrapper">

			<?php lefx_tabs($this->panel_name); ?>

			<?php if ($view) : $results = getDetail(LE_TABLE, 'referred_by', $view); ?>

			<ul class='subsubsub' style="float:none; border:none;">
				<li><a href="<?php echo admin_url("admin.php?page=lefx_stats"); ?>"><?php _e('&laquo; Back to Main', 'launcheffect'); ?></a></li>
			</ul>
			<div class="stats-header">
			<?php $emails = getDetail(LE_TABLE, 'code', $view); ?>
			<?php foreach ($emails as $email) : ?>
				<h3><?php echo $email->email; ?></h3>
				<?php if($email->referred_by != 'direct') : ?><br /><span class="refby"><?php _e('Signed Up Via: ', 'launcheffect'); ?><a href="<?php
					echo admin_url("admin.php?page=lefx_stats&amp;view={$email->referred_by}");
				?>"><?php
					$referred_by = $email->referred_by;
					$referrers = getDetail(LE_TABLE, 'code', $referred_by);
					foreach ($referrers as $referrer) echo $referrer->email; ?></a></span>
				<?php endif; ?>
			<?php endforeach; ?>

			</div>
			<hr/>
			<?php if ($emails && ($firstfield = get_option("lefx_cust_field1"))): ?>

			<h3><?php _e('Custom Fields', 'launcheffect'); ?></h3>
			<table id="user" class="widefat">
				<thead>
					<tr>
						<th class="nosort"><?php _e('Field', 'launcheffect'); ?></th>
						<th class="nosort"><?php _e('Response', 'launcheffect'); ?></th>
					</tr>
				</thead>
				<tbody><?php for($i=1;$i<=10;$i++) : ?>
					<?php
						$the_fieldname = get_option("lefx_cust_field$i");
						$the_fieldvalue = $email->{"custom_field$i"};
						if (empty($the_fieldname)) continue; ?>

					<tr<?php if ((int)$i%2) : ?> class="alternate"<?php endif; ?>>
						<th><?php echo $the_fieldname; ?></th>
						<td><?php echo (!empty($the_fieldvalue)?$the_fieldvalue:sprintf('<i>%s</i>', __('Not Entered', 'launcheffect'))); ?></td>
					</tr><?php endfor; ?>

				</tbody>
			</table>
			<?php endif; ?>

			<h3><?php _e('Conversions', 'launcheffect'); ?>: <?php echo count($results); ?></h3>
			<?php if (!$results) : ?><p><?php _e('Nothing to see here yet.', 'launcheffect'); ?></p><?php else: ?><table id="individual" class="widefat">
				<thead>
					<tr>
						<th class="nosort"><?php _e('Time', 'launcheffect'); ?></th>
						<th class="nosort"><?php _e('Converted User', 'launcheffect'); ?></th>
						<th class="nosort"><?php _e('IP', 'launcheffect'); ?></th>
					</tr>
				</thead>
				<tbody><?php foreach ($results as $idx => $result) : ?>

					<tr<?php if ((int)$idx%2<1) : ?> class="alternate"<?php endif; ?>>
						<td style="white-space:nowrap;"><?php echo $result->time; ?></td>
						<td><a href="<?php echo admin_url("admin.php?page=lefx_stats&amp;view={$result->code}"); ?>"><?php echo $result->email; ?></a></td>
						<td><?php echo $result->ip; ?></td>
					</tr><?php endforeach; ?>

				</tbody>
			</table>
			<?php endif; ?>
			<?php else : ?>

			<?php settings_errors(); ?>

			<ul class='subsubsub' style="float:none; border:none;">
				<li><a class="current" href="<?php echo admin_url("admin.php?page=lefx_stats"); ?>"><?php _e('Stats', 'launcheffect'); ?></a> |</li>
				<li><a href="<?php echo admin_url("admin.php?page=lefx_export"); ?>"><?php _e('Export as CSV', 'launcheffect'); ?></a></li>
			</ul>
			<form id="signup" action="<?php echo admin_url("admin.php?page=lefx_stats"); ?>" method="POST">
				<?php
				require_once(dirname(__FILE__).'/class-custom-list-tables.php');
				$args = array(
					'columns' => array(
						'cb'=>__('ID','launcheffect'),
						'col_time'=>__('Time','launcheffect'),
						'col_email'=>__('Email','launcheffect'),
						'col_visits'=>__('Visits','launcheffect'),
						'col_conversions'=>__('Conversions','launcheffect'),
						'col_conversion_rate'=>__('Conversion Rate','launcheffect'),
						'col_ip'=>__('IP','launcheffect'),
					),
					'sort_columns' => array(
						'col_time'=>array('time', true),
						'col_email'=>array('email', true),
						'col_visits'=>array('visits', true),
						'col_conversions'=>array('conversions', true),
						'col_ip'=>array('ip', true),
					),
					'bulk_actions' => array( 'trash' => 'Delete'),
					'table_name' => 'launcheffect', // select all from this table
				);
				$wp_list_table = new Custom_List_Table($args);
				$wp_list_table->prepare_items();
				$wp_list_table->display();

				?>
			</form>

			<?php endif; ?>

		</div>
		<?php
	}

	function build_le_export_page() {
		?>

		<div class="wrap">
			<?php lefx_tabs('export'); ?>

			<ul class='subsubsub' style="float:none; border:none;">
				<li><a href="<?php echo admin_url('admin.php?page=lefx_stats'); ?>"><?php _e('Stats', 'launcheffect'); ?></a> |</li>
				<li><a class="current" href="<?php echo admin_url('admin.php?page=lefx_export'); ?>"><?php _e('Export as CSV', 'launcheffect'); ?></a></li>
			</ul>
			<div id="le-export">
			 	<h3>Save Your Stats Data as a CSV</h3>
				<p>Use this option if you'd like to save your stats data to your computer as an Excel-friendly file.</p>
			 	<form method="post" action="<?php echo admin_url(); ?>" id="csvform">
					<?php wp_nonce_field('export_csv','verify_export'); ?>
				 	<span class="submit export-button"><input type="submit" name="submit" value="<?php esc_attr_e('Export as CSV &rarr;'); ?>"/></span>
			 	</form>
		 	</div>
		</div>
		<?php
	}

	function export_csv() {
		if ( !isset($_POST['verify_export']) || !wp_verify_nonce($_POST['verify_export'], 'export_csv') ) return;

		global $wpdb;

		$table = LE_TABLE;
		$csv_terminated = "\n";
		$csv_separator = ",";
		$csv_enclosed = '"';
		$csv_escaped = "\\";

		// Gets the data from the database
		$results = $wpdb->get_results("SELECT * FROM $table", 'ARRAY_N');
		$fields_cnt = $wpdb->num_rows;
		$schema_insert = '';
	    $finfo = $wpdb->get_col_info('name');

		foreach ($finfo as $val) {
			$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes($val)) . $csv_enclosed;
			$schema_insert .= $l;
			$schema_insert .= $csv_separator;
		}

		$out = trim(substr($schema_insert, 0, -1));
		$out .= $csv_terminated;

		// Format the data
		foreach($results as $j => $row) {
			$schema_insert = '';
			for ($j=0; $j<$fields_cnt; $j++) {
				if ( !empty($row[$j])) {
					if ($csv_enclosed == '') {
						$schema_insert .= $row[$j];
					} else {
						$schema_insert .= $csv_enclosed .
						str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
					}
				} else {
					$schema_insert .= '';
				}

				if ($j < $fields_cnt - 1) {
					$schema_insert .= $csv_separator;
				}
			}

			$out .= $schema_insert;
			$out .= $csv_terminated;
		}
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=export.csv");
		echo $out;
		exit;
	}
}

new LE_Stats_Admin_Page(array(
	'title' => 'Stats',
	'name' => 'stats',
	'options' => array(),
));
