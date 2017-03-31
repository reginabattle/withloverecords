<?php get_header(); ?>
 
<section class="page-content row">
	<div class="seven columns centered">
		
		<header>
			<h1><?php the_title(); ?></h1>
		</header>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; endif; ?>

		<!-- <?php if(is_page('about')) : $count_posts = wp_count_posts(); $published_posts = $count_posts->publish;?>
		<p><strong>Current Total:</strong> <?php echo $published_posts; ?> </p>
		<?php endif; ?> -->
	   
	</div>
</section>




<?php get_footer(); ?>