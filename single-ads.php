<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
global $post;
get_header(); ?>
<?php


$price_ad = get_post_meta( $post->ID, 'price_ad' );
$textarea_ad = get_post_meta( $post->ID, 'textarea_ad' );
if ( metadata_exists( 'post', $post->ID, '_mtst_images' ) ) {
                    $mtst_images = get_post_meta( $post->ID, '_mtst_images', true );
                } 
                $attachments = array_filter( explode( ',', $mtst_images ) );
?>
		<div class="mtst-content">
			<div class="container">
				<div class="row">
					<div class="col-12 left-column">
						
						<!-- Start the Loop. -->
						<?php
							if ( have_posts() ) :
						 	while ( have_posts() ) :
						 	the_post();
						?>
						
			 			<div <?php  post_class();  ?>>

				 			<div class="meta"><span><?php _e( 'Posted by', 'mtst-text-domain' ); ?> <?php the_author_posts_link(); ?><?php echo ' / '?></span><span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago / '; ?></div>
                            <h2 class="title-post"><?php the_title(); ?></h2>

				 		</div> <!-- closes the first div box -->

                                
                    	 <div>
                               <?php echo __( 'About :', 'mtst-text-domain' ) . $textarea_ad[0] ?>
                        </div> 
                        <div>
                            <?php echo __( 'Price :', 'mtst-text-domain' ) . $price_ad[0] ?>
                        </div>                                    
                        <div>
							<?php 
                                if ( ! empty( $attachments ) ) {
				                    foreach ( $attachments as $attachment_id ) {
				                        $attachment = wp_get_attachment_image( $attachment_id, array(150) );?>
				                        <div>
				                        	<?php echo $attachment ?>                 		
				                        </div>
				                        <?php							                       
				                    }
				                }
							?> 								                                  
                        </div> 	
                                
						<?php endwhile;
						 	else : ?>
							<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'mtst-text-domain' ); ?></p>
						 	<?php endif; ?>
							
					</div><!-- .right-column -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .content-wrapper -->
<?php get_footer(); ?>
