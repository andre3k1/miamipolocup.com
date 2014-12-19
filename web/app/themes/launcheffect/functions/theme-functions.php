<?php
/**
 * Functions: theme-functions.php
 *
 * Functions utilized by referral/stats functionality
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
 
// CREATE REFERRAL CODE
function randomString() {
    $length = 3;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
	$string = substr($string.strrev(uniqid()),0,5);
	return $string;
}

// GET REFERRED_BY CODE
function get_referral_index() {
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$parseurl = parse_url($url, PHP_URL_PATH);
	$parseurlstr = substr($parseurl, -5, 5);

	if (isset($_GET['ref'])||isset($_GET['fb_ref'])) { 
		$referralindex = htmlspecialchars(!isset($_GET['ref'])?$_GET['fb_ref']:$_GET['ref']);
	} elseif(strstr($parseurlstr, '/') OR $parseurlstr == '') {
		$referralindex = 'direct';
	} else {
		$referralindex = $parseurlstr;
	}
	$_SESSION['referredBy'] = $referralindex; // TODO: This SESSION global never used and should be utilized or removed.
	return $referralindex;
}

// WPDB QUERY
function wpdbQuery($query, $type, $args = false) {
	global $wpdb;
	if ($args && is_array($args)) $result = $wpdb->$type($query, $args);
	else $result = $wpdb->$type($query);
	return $result;
}

// LOG VISITS 
function log_visits() {
	global $wpdb;
	$referral = get_referral_index();
	$table = $wpdb->prefix . "launcheffect";
	$update = wpdbQuery("UPDATE $table SET visits = visits+1 WHERE code = '$referral'", 'query');
	return $update;
}
add_action('get_header', 'log_visits');

// POST DATA
function postData($table, $referral, $premium = null) {
	$prem_fields = '';
	$prem_values = '';
	if ( !is_null($premium) && count($premium['fields'])) {
		$prem_fields = ", " . implode(", ", $premium['fields']);
		$prem_values = ",'" . implode("','", $premium['values']) . "'";
	}	
	$query = "INSERT INTO $table (time, email, code, referred_by, visits, conversions, ip" . $prem_fields . ")"
		." VALUES('" . date('Y-m-d H:i:s') . "','$_POST[email]', '$_POST[code]','$referral',0,0,'" . $_SERVER['REMOTE_ADDR'] . "'" . $prem_values . ")";
	$result = wpdbQuery($query, 'query');
	$update2 = wpdbQuery("UPDATE $table SET conversions = conversions+1 WHERE code = '$referral'", 'query');
}

// CLEAR COLUMN
function clearColumn($table, $colname) {
	if (lefx_version() == 'premium') {
		$query = "UPDATE $table SET $colname = NULL";
		$result = wpdbQuery($query, 'query');
		echo 'success';
	}
}

// COUNT CHECK (RETURN COUNT OF INSTANCES WHERE X = Y)
function countCheck($table, $entry, $value) {
	$query = wpdbQuery(
		"SELECT COUNT(*) FROM $table WHERE $entry = '$value'", 
		'get_var'
	);
	return $query;
}

// REPEAT CODE CHECK
function codeCheck() {
	global $wpdb;
	$code = randomString(); 
	$count = countCheck($wpdb->prefix . 'launcheffect', 'code', $code);
	if ($count > 0) { 
		/*
		 * This should create another randomString() and check
		 * against the database before outputting the string
		 */
		codeCheck(); 
	} else { 
		echo $code; 
	}	
}

// GET DATA, PAGINATE IT
function getPaginatedData($table, $order, $ad, $offset, $rowsperpage) {
	$result = wpdbQuery("SELECT * FROM $table ORDER BY $order $ad LIMIT $offset, $rowsperpage", 'get_results');
	return $result;
}

// GET DATA
function getData($table) {
	$result = wpdbQuery("SELECT * FROM $table ORDER BY time DESC", 'get_results');
	return $result;
}

// GET DETAIL (RETURN X WHERE Y = Z)
function getDetail($table, $entry, $value) {
	$result = wpdbQuery("SELECT * FROM $table WHERE $entry = '$value' ORDER BY time DESC", 'get_results');
	return $result;
}

// COUNT DATA
function countData($table) {
	$count = wpdbQuery( 
		"SELECT COUNT(*) FROM $table",
		'get_var'
	);
	return $count;
}

// FLATTEN ARRAYS
function array_flatten($array, $return = array()) {
	foreach ($array as $k => $item) {
		if (is_array($item))
			$return = array_flatten($item, $return);
		elseif ($item)
			$return[] = $item;
	}
	return $return;
}
