<?php


function wpdev_before_after($content) {
    if(is_page() || is_single()) {
        $poll = get_post_meta( get_the_ID(), 'sp_poll', true );
//        print_r($poll);
//        echo esc_html( $text );
        $beforecontent = 'This goes before the content. Isn\'t that awesome!';
        $aftercontent = 'And this will come after, so that you can remind them of something, like following you on Facebook for instance.';
        $fullcontent = $beforecontent . $content . $aftercontent. get_the_ID();
    } else {
        $fullcontent = $content;
    }


    return $fullcontent;
}
add_filter('the_content', 'wpdev_before_after');