<?php

if ( ! function_exists('usAjaxPortfolio'))
{
    function usAjaxPortfolio() {

        if (empty($_POST['project_id'])) {
            die();
        }
        $post = get_post($_POST['project_id']);
        if (empty($post)) {
            die();
        }

        $content = apply_filters('the_content', $post->post_content);
        echo $content;

        die();
    }

    add_action( 'wp_ajax_nopriv_usAjaxPortfolio', 'usAjaxPortfolio' );
    add_action( 'wp_ajax_usAjaxPortfolio', 'usAjaxPortfolio' );
}