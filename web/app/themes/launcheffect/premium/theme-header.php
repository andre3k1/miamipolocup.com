<?php
/**
 * Theme Header (Premium)
 *
 * Contains the top portion of the content area:
 * 		Launch module slide-down
 * 		Logo/Heading area
 * 		Sidebar (nav and widgets) include
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */
?>

<div id="nav-responsive">
	<a href="#" id="nav-responsive-menu-link"><?php echo ($lefx_pages_nav_text = ler('lefx_pages_nav_text')) ? $lefx_pages_nav_text : 'Menu'; ?>&nbsp;<span class="plus">&equiv;</span><span class="minus">&times;</span></a>
	<div id="nav-responsive-menu-items">
		<nav>
			<?php wp_nav_menu( array( 'theme_location' => 'lefx-nav', 'menu_class' => 'nav') ); ?>

		</nav>
		
		<?php if(ler('lefx_pages_tab_disable') != true) : ?>
		
		<div id="launchlite">
			<div id="launchtab">
				<a href="#"><?php le('lefx_pages_tab_text'); ?><span>&rsaquo;</span></a>
			</div>
			<div id="launchlitemodule">
				<?php get_template_part('premium/launch','lite'); ?>

			</div>
		</div>
		<?php endif; ?>
		
	</div>
</div>
<div id="wrapper">
	<header class="no-margin">
		<?php 
			$logo_src = leimg('lefx_pages_logo', 'lefx_pages_logo_disable', 'pages_options'); 
			$logo_href = ler('lefx_pages_logolink');
			$logo_text = ler('lefx_pages_textlogo');
		?><h1 class="<?php 
			echo ($logo_src) ? 'haslogo' : 'nologo'; 
			echo (ler('lefx_pages_textlogo_disable') == false) ? ' hastextheading' : ' notextheading'; 
		?>"><?php 
			$inner = sprintf('<span>%s</span>', $logo_text);
			if($logo_src) $inner = sprintf('<img src="%s" alt="%s"/>%s', $logo_src, strip_tags($logo_text), $inner); 
			if($logo_href) printf('<a href="%s">%s</a>', $logo_href, $inner);
			else echo $inner;
		?></h1>
	</header>