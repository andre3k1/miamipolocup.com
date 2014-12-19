<?php 
/**
 * Functions: designer-functions.php
 *
 * Functions to format get_option values in different ways
 * e.g. echo, image, Google webfont, color calculation... etc.
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
 
// GET OPTIONS FUNCTIONS

// echo, with default value
function le($opname) {
	$opt = get_option($opname);
	if ($opt != '') echo nl2br($opt); 
}

// return
function ler($opname) {
	$opt = get_option($opname);
	if ($opt != '') return $opt; 
}

// images: checks if the image is disabled, checks if the image is blank
function leimg($opname, $opdisable, $optionspanel_name) {
	// upgrade routine for previously saved images
	$options = get_option($optionspanel_name); 
	if ( is_array($options) && isset($options[$opname]) ) {
		update_option($opname, $options[$opname]);
		unset($options[$opname]);
		update_option($optionspanel_name, $options);
	}
	$opt = get_option($opname);
	if ($opt != '' && get_option($opdisable) != true) return $opt;
}

// google webfonts for CSS: strips the colon
function legogl($opname, $default) {
	$str = get_option($opname);
	if ($str != '') { 
		$pos = strpos($str,':'); 
		echo ($pos === false) ? $str : substr($str, 0, strpos($str, ':'));
	} else { 
		echo ler($default); 
	}
}

// font weight 
function lewt($opname) {
	$opt = get_option($opname);
	echo ($opt == 'bold' || $opt == 'bold italic') ? 'bold' : 'normal';
}

// font style 
function lestyle($opname) {
	$opt = get_option($opname);
	echo ($opt == 'italic' || $opt == 'bold italic') ? 'italic' : 'normal';
}

// calculates a darker color
function darker($opname) {
	$color = ler($opname);
	if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) {
		$array = array();
		
		for($i = 1; $i <= 3; $i++) {
			$parts[$i] = round(hexdec($parts[$i]) * 0.85);
			$parts[$i] = dechex($parts[$i]);
			
			if ($parts[$i] == '0') $parts[$i] = str_pad($parts[$i], 2, "0", STR_PAD_LEFT);
			array_push($array, $parts[$i]);
		}
		
		array_unshift( $array, '#' );
		$newcolor = implode('',$array);
		return $newcolor;
	}
}

// calculates a darker color (version 2)
function darker2($opname) {
	$color = ler($opname);
	if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) {
		$array = array();
		
		for($i = 1; $i <= 3; $i++) {
			$parts[$i] = round(hexdec($parts[$i]) * 0.70);
			$parts[$i] = dechex($parts[$i]);
			
			if (($parts[$i]) == '0') $parts[$i] = str_pad($parts[$i], 2, "0", STR_PAD_LEFT);
			array_push($array, $parts[$i]);
		}
		
		array_unshift( $array, '#' );
		$newcolor = implode('',$array);
		return $newcolor;
	}
}

// calculates a lighter color
function lighter($opname) {
	$color = ler($opname);
	if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) {
		$array = array();
		
		for($i = 1; $i <= 3; $i++) {
			$parts[$i] = hexdec($parts[$i]);
			$parts[$i] = ($parts[$i] < 16) ? 70 : round($parts[$i]*1.2);

			if ($parts[$i] > 255) $parts[$i] = 255;
			$parts[$i] = dechex($parts[$i]);

			if ($parts[$i] == '0') $parts[$i] = str_pad($parts[$i], 2, "9", STR_PAD_LEFT);
			array_push($array, $parts[$i]);
		}
		
		array_unshift( $array, '#' );
		$newcolor = implode('',$array);
		return $newcolor;
	}
}

// calculates whether something should be black or white depending on the background brightness
function blacknwhite($opname) {
	$color = ler($opname);
	if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) {
		$array = array();
		for($i = 1; $i <= 3; $i++) {
			$parts[$i] = hexdec($parts[$i]);
			array_push($array, $parts[$i]);
		}
		$grayscale = round(($parts[1] + $parts[2] + $parts[3])/3);
		return ($grayscale < 125) ? '#FFFFFF' : '#222222';
	}
}
