<!doctype html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<title>The HTML5 Herald</title>
    	<meta name="description" content="The HTML5 Herald"/>
    	<meta name="author" content="SitePoint"/>
    	<?php wp_head(); ?>    	
    </head>
	<body <?php body_class();?>>

	<div class="container-wraper">
		<div class="mtst-header">
			<div class="mtst-header-top container-fluid">
				<div class="container">
					<div class="row">
                        <?php
	                        wp_nav_menu( array(
	                            'theme_location'  => 'mtstmenu',
	                            'container_class' => 'custom-menu-class'
	                        ) );
                        ?>
					</div><!-- .row -->
				</div><!-- .container -->
												
			</div><!-- .mtst-header-top -->

		</div><!-- .mtst-header -->
