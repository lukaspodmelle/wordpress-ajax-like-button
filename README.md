WordPress post like button ♥
===================
A like button for WordPress that can be used anywhere you want.

It utilizes a post's metabox to store the number of likes, as well as the IP addresses of those who liked. Based on the IP address, it can remember who previously liked and keep the heart icon active. It's very easy to insert into your theme or site - using a shortcode.

### Include the php files (functions.php):
```php
<?php
include_once('inc/like-metabox.php');
include_once('inc/like-post.php');
?>
```

### Don't forget to enqueue the js file (functions.php):
```php
<?php
function enqueue_scripts() {
   wp_enqueue_script( 'like_post', get_template_directory_uri() . "/assets/js/like-post.js", array('jquery'), false, '1.0', true);  
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
?>
```

### Localize ajax (functions.php):
```php
<?php
function add_ajax_url() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}
add_action('wp_head', 'add_ajax_url');
?>
```

### Shortcode HTML structure (functions.php):
```php
<?php
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
```

### Show the like button on frontend
Since a shortcode for the like button is created, you can simply use ``[like-button]`` anywhere on your site. If you want to use it inside a php page-template/template-part, use this instead:
```html
<?php echo do_shortcode("[like-button]"); ?>
```

### Show the metabox on multiple post types
Simply add new ones to the array and the metabox will show up on those pages. Just don't forget to add the like button in the front-end
```php
// You can find this on line 9 in the like-metabox.php file
$show_on = array('post', 'pets');
```