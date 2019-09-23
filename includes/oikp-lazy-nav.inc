<?php // (C) Copyright Bobbing Wide 2012
/**
 * Create a nav menu for oik-presntation slides
 */
function oikp_lazy_nav( $post ) {
  bw_trace2(); 
  stag( "nav", null, "navsingle" );
  h3( "Post navigation", "assistive-text" );
  $oobit = site_url(); 
  /* We need a better way of determining the Table of Contents (TOC) for a particular presentation. **?** */ 
  alink( "toc",  $oobit . "/oik-presentations/table-of-contents", "TOC" );  
  alink( "home", $oobit, "home" );
  $up = get_permalink( $post->post_parent ); 
  alink( "up", $up , "up" );
  oik_require( "includes/bw_posts.inc" );
  $next = oikp_next( $post );
  alink( "next", $next , "next" );
  
  $prev = oikp_prev( $post );
  alink( "prev", $prev, "prev" );
  etag( "nav" );
  bw_flush();
}  

/* This is how it was coded in Twenty Eleven's single.php

<nav id="nav-single">
<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>
<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
</nav><!-- #nav-single -->

}

*/

/**
 * Build a simple array which represents the tree of posts
 * Do we need to know if the tree is hierarchical?
 
 * Note: We pass exclude=-1 so that the current post IS included.
 * could we have done include= instead?
 * We need to start from the top so that we know where to go at the end of a list of children
 
 */
function oikp_tree( $post_type, $post_parent=0) {
  global $oikp_post_tree;
  $atts["post_parent"] = $post_parent;
  $atts["post_type"] = $post_type;
  $atts["orderby"] = "menu_order" ;
  $atts["order"] = "ASC";
  $atts["numberposts"] = -1;
  $atts["exclude"] = -1;
  
  
  // $oikp_post_tree[] = $post;
  $posts = bw_get_posts( $atts );
  if ( count( $posts ) ) {
    foreach ( $posts as $post ) {
      $oikp_post_tree[] = $post->ID;
      oikp_tree( $post->post_type, $post->ID );
    }
  }  
}

/**
 * Get the ID of the next post in menu order.
 * This may be the first child OR the next one at this level or the next one at the previous level
 * OR we may go back round to the beginning
 */
function oikp_next( $post ) {
  global $oikp_post_tree;
  if ( !isset( $post_tree ) ) {
    oikp_tree( $post->post_type );
  }
  bw_trace2( $oikp_post_tree );
  $key = array_search( $post->ID, $oikp_post_tree);
  bw_trace2( $key, "key", false );
  
  $key++;
  $result = bw_array_get( $oikp_post_tree, $key, $oikp_post_tree[0] );
  return( get_permalink( $result) );
}


/**
 * Get the ID of the previous post in menu order.
 * The reverse of next
 */

function oikp_prev( $post ) {
  global $oikp_post_tree;
  if ( !isset( $post_tree ) ) {
    oikp_tree( $post->post_type );
  }
  bw_trace2( $oikp_post_tree );
  
  $key = array_search( $post->ID, $oikp_post_tree);
  bw_trace2( $key, "key", false );
  $key--;
  $result = bw_array_get( $oikp_post_tree, $key, null ); 
  if ( !$result) { 
    $result = end( $oikp_post_tree);
  }    
  return( get_permalink( $result) );
  
  
}
