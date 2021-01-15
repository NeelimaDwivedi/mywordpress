<?php
/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<aside class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		
		<?php
   			$args = array(
               'taxonomy' => 'product_category',
               'orderby' => 'name',
               'order'   => 'ASC'
           	);
			$cats = get_categories($args);?>
			<ul><!--list start-->
			<?php _e( '<h5>Product Category</h5>'); ?>
			<?php
   			foreach($cats as $cat) {
		?>
		<li>
      	<a href="<?php echo get_category_link( $cat->term_id ) ?>">
           <?php echo $cat->name; ?>
      	</a>
		</li>

		<?php
			}
		?>		   
		</ul><!--list end-->
	
	</aside><!-- .widget-area -->

<?php endif; ?>
