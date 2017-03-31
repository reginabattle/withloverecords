<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage With Love Records
 * @since 2017
 */
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>With Love Records</title>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class( $class ); ?>>
	
  <!-- Header -->
  <header class="header-wrapper wow fadeIn header-down" data-wow-duration="1.3" data-wow-delay="0.5s">
    <div class="header-inner row">
      
      <div class="site-search two mobile-one columns">
        <a class="search-button" href="#"><i class="material-icons">search</i></a>
      </div>

      <div class="site-title eight mobile-two columns">
        <a href="<?php echo home_url(); ?>">With Love Records</a>
      </div>

      <div class="header-right two mobile-one columns">
        <!-- <a class="view-button"><i class="material-icons">view_list</i></a> -->
        <a class="menu-button"><div class="bar"></div></a>
      </div>

    </div>
  </header>
  <!-- end header -->

  <nav class="main-menu wow fadeIn"  data-wow-duration="1.3" data-wow-delay="0.5s">
    <div class="row">
    <?php wp_nav_menu(array( 
        'theme_location' => 'main-menu', 
        'container' => false,
        'menu_id' => '',
        'menu_class' => '',
        'depth' => 0,
      )); 
    ?>
    </div>
  </nav>

  <!-- Container -->
  <main class="container wow fadeIn" data-wow-duration="1.3" data-wow-delay="0.5s">

    <div class="row">
      <div class="search-albums twelve columns">
        <form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
          <input type="text" class="search-field" placeholder="Search" name="s">
        </form>
      </div>
    </div>

