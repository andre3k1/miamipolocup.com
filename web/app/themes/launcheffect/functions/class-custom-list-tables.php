<?php

if(!class_exists('WP_List_Table')) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/**
 * Extended class for displaying a list of items in an HTML table.
 *
 * @usage
 *		// be sure to modify the display_rows function to customize the output of the rows
 *		$args = array(
 *			'columns' => array(
 *				'cb'=>__('ID','textdomain'),
 *				'col_last_name'=>__('Last Name','textdomain'),
 *				'col_first_name'=>__('First Name','textdomain'),
 *			),
 *			'sort_columns' => array(
 *				'col_first_name'=>array('first_name', true),
 *				'col_last_name'=>array('last_name', true),
 *			),
 *			'bulk_actions' => array(
 *				"delete" => "Delete Permanently",
 *				"approve" => "Approve",
 *				"reject" => "Reject",
 *			),
 *			'table_name' => 'table_name', // select all from this table
 *			'where' => 'WHERE_CLAUSE', // add WHERE clause without the WHERE
 *			'query' => 'CUSTOM_QUERY, // overrides where and table_name
 *			'search' => array( 'searchable_columns' )
 *		);
 *		$wp_list_table = new Custom_List_Table($args);
 *		$wp_list_table->prepare_items();
 *		$wp_list_table->display();
 * @endusage
 */
class Custom_List_Table extends WP_List_Table {
	var $_sort_columns, $_bulk_actions, $_query, $_where, $_search, $_table_name;
	
	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	function __construct( $args ) {
		parent::__construct( array(
			'singular'=> 'wp_review_item', //Singular label
			'plural' => 'wp_review_items', //plural label, also this well be one of the table css class
			'ajax'	=> false //We won't support Ajax for this table
		) );
		if ( is_null($args) ) return false;
		if ( is_array($args) ) {
			foreach ($args as $var => $val) $this->{"_".$var} = $val;
		}
	}

	function get_table_classes() {
		return array( 'widefat', $this->_args['plural'] );
	}

	/**
	 * Add extra markup in the toolbars before or after the list
	 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
	 */
	function extra_tablenav( $which ) {
		$search = @$_POST['s']?esc_attr($_POST['s']):"";
		if ( empty($_search) ) return;
		if ( $which == "top" ) : ?>
		<div class="actions">
			<p class="search-box">
				<label for="post-search-input" class="screen-reader-text">Search Pages:</label>
				<input type="search" value="<?php echo $search; ?>" name="s" id="post-search-input">
				<input type="submit" value="Search" class="button" id="search-submit" name="">
			</p>
		</div>
		<?php endif;
	}

	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $this->_columns;
	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		return $this->_sort_columns;
	}

	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
		global $wpdb, $_wp_column_headers;
		$screen = get_current_screen();
		$user = get_current_user_id();

		/* -- Preparing your query -- */
		if ( !isset($this->_table_name) ) return false;
		$tbl = $wpdb->prefix . $this->_table_name;
		$page = @$_GET['page'];
		
		if (! isset($where) && isset($this->_where) ) $where = "WHERE ({$this->_where})";
		
		// the query
		if ( isset($this->_query) ) $query = $this->_query;
		else $query = "SELECT * FROM $tbl".(isset($where)?" $where":"");

		/* -- Ordering parameters -- */
	    //Parameters that are going to be used to order the result
	    $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : '';
	    $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : 'ASC';
	    if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }

		/* -- Pagination parameters -- */
        $total_items = $wpdb->query($query);
		$per_page = get_user_meta($user, 'stats_per_page', true);
		if ( empty( $per_page ) || $per_page < 1 ) {
			echo 'nothing';
			$per_page = $screen->get_option( 'per_page', 'default' );
		}
        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
        if(empty($paged) || !is_numeric($paged) || $paged<=0 ) $paged=1;
        $total_pages = ceil($total_items/$per_page);
	    if(!empty($paged) && !empty($per_page)){
		    $offset=($paged-1)*$per_page;
    		$query.=' LIMIT '.(int)$offset.','.(int)$per_page;
	    }

		/* -- Register the pagination -- */
		$this->set_pagination_args( array(
			"total_items" => $total_items,
			"total_pages" => $total_pages,
			"per_page" => $per_page,
		) );
		//The pagination links are automatically built according to those parameters

		 /* — Register the Columns — */
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		/* -- Fetch the items -- */
		$this->items = $wpdb->get_results($query);
	}

	/**
	 * Get an associative array ( option_name => option_title ) with the list
	 * of bulk actions available on this table.
	 *
	 * @since 3.1.0
	 * @access protected
	 *
	 * @return array
	 */
	function get_bulk_actions() {
		return $this->_bulk_actions;
	}
	
	function column_cb( $item) {
		$this->column_default( $item, $column_name = 'cb');
	}

	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function column_default( $item, $column_name) {
		$page = @$_GET['page'];

		//links
		$editlink  = admin_url("admin.php?page=$page&view={$item->code}");
		$deleteLink = admin_url("admin.php?page=$page&id={$item->id}&action=trash");
	
		//Display the cell
		$actions = array(
			'view' => '<a class="view" href="'.$editlink.'" title="View">View</a>',
			'trash' => '<a class="remove" href="'.$deleteLink.'" title="Delete">Delete</a>',
		);
		switch ( $column_name ) {
			case "cb":
				echo '<input type="checkbox" name="id[]" value="'.$item->id.'" />'; 
				break;
			case "col_conversion_rate": 
				$rate = ($item->visits + $item->conversions != 0 ) ? (($item->conversions/$item->visits) * 100) : ''; 
				echo round($rate, 2) . '%'; 
				break;
			case "col_email": 
				echo '<a href="'.$editlink.'">'.$item->email.'</a>'.$this->row_actions($actions); 
				break;
			default : 
				echo $item->{str_replace('col_', '', $column_name)}; 
		}
	}
}
