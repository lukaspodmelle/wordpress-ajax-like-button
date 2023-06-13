<?php
include_once( __DIR__ . '/inc/like-metabox.php');
include_once( __DIR__ . '/inc/like-post.php');

/*
* Ajax URL
*/

function add_ajax_url() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}
add_action('wp_head', 'add_ajax_url');


/*
* Shortcode for like button
*/

function like_button_shortcode() {

    // Check IP address to see if the user has already liked
    $ips = get_post_meta(get_the_ID(), '_likers');
    $currentip = $_SERVER['REMOTE_ADDR'];

    foreach ($ips as $value) {
        if (strpos($value, $currentip) !== false) {
            $results[] = $value;
        }
    }
    if (! empty($results)) {
        $userliked = "liked";
    }
    
    // HTML content of the button
    global $post;
    ob_start();
    ?>

    <div class="like__container">
        <div class="like__icon">
            <a class="like <?= $userliked; ?>" rel="<?php echo $post->ID; ?>">
                <svg class="icon__heart" fill="#ff0000" height="32" width="32" stroke="grey" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </a>
        </div>
        <div id="like__count"><?php echo likeCount($post->ID); ?></div>
    </div>
    
    <?php
    return ob_get_clean();
}
add_shortcode( 'like-button', 'like_button_shortcode' );

?>