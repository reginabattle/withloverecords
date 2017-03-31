<?php get_header(); ?>
 
<section class="album-list row">
		
	<header class="twelve columns">
		<h1>Search results for &ldquo;<?php echo get_search_query(); ?>&rdquo;</h1>
	</header>

	<?php 
		add_filter('posts_fields', 'wpcf_create_temp_column');
		add_filter('posts_orderby', 'wpcf_sort_by_temp_column');

		remove_filter('posts_fields','wpcf_create_temp_column');
		remove_filter('posts_orderby', 'wpcf_sort_by_temp_column');
	?> 		

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<!-- Entry -->
	<article class="album-entry twelve columns wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
	  <div class="album-cover three columns">
	  	<?php $attachment_id = get_post_thumbnail_id(); $size = "cover"; $image = wp_get_attachment_image_src($attachment_id, $size); ?>
	    <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?> album cover" />
	  </div>

	  <div class="album-details four columns">
	    <h1><?php the_title(); ?></h1>
			
			<?php $artist = get_field('artist'); ?>
    	<h2><a href="<?php echo get_permalink($artist); ?>"><?php echo get_the_title($artist); ?></a></h2>
	  </div>

	  <div class="album-genre two columns">
	    <p><?php the_category( ', ' ); ?></p>
	  </div>

	  <div class="album-year two columns">
	    <p><?php the_field('year'); ?></p>
	  </div>
	</article>
	<!-- end entry --> 

	<?php endwhile; endif; ?>

	<nav class="pagination twelve columns">
		<?php the_posts_pagination(array(
			'mid_size'  => 2,
			'prev_text' => __( '<i class="material-icons">keyboard_arrow_left</i>', 'textdomain' ),
			'next_text' => __( '<i class="material-icons">keyboard_arrow_right</i>', 'textdomain' ),
			'screen_reader_text' => ' '
		));
		?>
	</nav>

</section>

<?php get_footer(); ?>