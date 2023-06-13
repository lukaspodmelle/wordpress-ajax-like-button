<?php

/*
 * Add / show metabox
*/

function add_like_metabox() {

   $show_on = array('post');
   if(in_array(get_post_type(), $show_on)){

      add_meta_box(
         'like_metabox',
         __('Likes', 'text-domain'),
         'render_like_metabox',
         get_post_type(),
         'side',
         'low'
      );

   }

}

add_action('add_meta_boxes', 'add_like_metabox');

/*
 * Render the metabox
*/

function render_like_metabox(){
   global $post;
   $likers = get_post_meta($post->ID, '_likers', true);
   $likes_count = get_post_meta($post->ID, '_likes_count', true);

   wp_nonce_field(__FILE__, 'wp_nonce');
   ?>

   <p style="display:flex;align-items:center;gap:5px">
      <svg class="icon__heart" fill="#ff0000" height="24" width="24" stroke="#ff0000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
      <input type="text" name="_likes_count" id="likes_count" class="widefat" value="<?php echo $likes_count; ?>" style="border:0;padding: 0 0 0 10px;font-size:1.2rem;height:1rem;" />
   </p>
   <p>
      <p style="margin-bottom:10px;"><?= __('IP addresses of likers', 'pivik'); ?></p>
      <textarea name="_likers" id="likers" class="widefat"><?php echo $likers; ?></textarea>
   </p>
   <?php
}

/*
 * Save the metabox
*/

function save_like_metabox_NEW($post_id) {
	
   if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
      
       if (array_key_exists('_likes_count', $_POST) && wp_verify_nonce($_POST['wp_nonce'], __FILE__)) {
           update_post_meta($post_id,'_likes_count',$_POST['_likes_count']);
       }    
      if (array_key_exists('_likers', $_POST) && wp_verify_nonce($_POST['wp_nonce'], __FILE__)) {
           update_post_meta($post_id,'_likers',$_POST['_likers']);
       }
   }
   add_action('save_post', 'save_like_metabox_NEW');

?>