<?php get_header(); ?>
	<div class="mtst-content ">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-9 left-column">
					<div class="row">
                    <?php echo do_shortcode( '[list-posts-basic]' ) ?>
				</div><!-- .left-column -->

				<div class="col-12 col-md-3 d-sm-none d-md-block right-column">
					<?php get_sidebar() ?>
				</div><!-- .right-column -->
			</div><!-- .row -->
		</div><!-- .container -->
	
<?php get_footer(); ?>
