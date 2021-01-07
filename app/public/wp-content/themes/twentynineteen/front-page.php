<?php 
get_header();
?>
<div><h3>this is the newly created frontpage</h3></div>
<?php 
if ( have_posts() ) {
    $args = array( 'posts_per_page' => 3 );
    $the_query = new WP_Query( $args );
    // Load posts loop.
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        get_template_part( 'template-parts/content/content', 'front-page' );
        //the_content();
    }

    // Previous/next page navigation.
    the_post_navigation(
        array(
            'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twentynineteen' ) . '</span> ' .
                '<span class="screen-reader-text">' . __( 'Next post:', 'twentynineteen' ) . '</span> <br/>' .
                '<span class="post-title">%title</span>',
            'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twentynineteen' ) . '</span> ' .
                '<span class="screen-reader-text">' . __( 'Previous post:', 'twentynineteen' ) . '</span> <br/>' .
                '<span class="post-title">%title</span>',
        )
    );

} else {

    // If no content, include the "No posts found" template.
    get_template_part( 'template-parts/content/content', 'none' );

}

get_footer();
?>
