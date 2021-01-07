<?php /* Template Name: Example Template */ ?>
<?php
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Nineteen
* @since Twenty Nineteen 1.0
*/
get_header();
?>

<div id="primary" class="site-content">
    <div id="content" role="main">
      <div><h3>My Demo Template</h3></div>
      <?php while ( have_posts() ) : the_post(); 
        get_template_part( 'template-parts/content/content', 'mytemplate' ); 
       endwhile; ?>

    </div>
  </div>
<?php get_footer(); ?>