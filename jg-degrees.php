<?php get_header(); ?>

<?php 
global $post;

	$degree = get_the_title();
	$permalink = get_permalink($post->ID);
	
	$degree_types = get_the_term_list( $post->ID, 'degree_types', '<strong>Degree Type</strong>: ', ', ', '' );

	$acc_agency = get_post_meta($post->ID, 'acc_agency', true);
	$address = get_post_meta($post->ID, 'address', true);
	//$city = get_post_meta($post->ID, 'city', true);
	$state = get_post_meta($post->ID, 'state', true);
	//$zip = get_post_meta($post->ID, 'zip', true);

	//$area_code = get_post_meta($post->ID, 'area_code', true);
	$phone = get_post_meta($post->ID, 'phone', true);
	//$ext = get_post_meta($post->ID, 'ext', true);

	$website = get_post_meta($post->ID, 'website', true);
	$tuition_fees = get_post_meta($post->ID, 'tuition_fees', true);
	$percent_fin_aid = get_post_meta($post->ID, 'percent_fin_aid', true);
	
	$school_type = get_post_meta($post->ID, 'school_type', true);
	$programs_offered = get_post_meta($post->ID, 'programs_offered', true);

	//$college_programs = get_the_term_list( $post->ID, 'college_programs', '<strong>Programs Offered</strong>: ', ', ', '' );
	//$college_school_type = get_the_term_list( $post->ID, 'college_school_type', '<strong>Type of School</strong>: ', ', ', '' );
	
	// Add Programs list if this post was so tagged
	//if ( $college_programs != '' ) { $taxo_text .= "<p>". $college_programs. "</p>\n"; }
	//if ( $college_school_type != '' ) { $taxo_text .= "<p>". $college_school_type. "</p>\n"; }

if ( have_posts() ) while ( have_posts() ) : the_post(); $currentPost = $post->ID; ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">

					<header class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
			
					<?php the_content(); ?>


		<? if($acc_agency){ ?><p><strong>Accrediting Agency</strong>: <?php echo $acc_agency;?></p><?php } ?>

		<p><strong>Address</strong>: <?php echo $address;?></p>

		<p><strong>Contact</strong>: <?php echo $phone;?></p>

		<p><strong>Website</strong>: <a href="<?php echo 'http://'. $website;?>" rel="bookmark" class="url"><?php echo $website;?></a></p>
		
		<? if($school_type){ ?><p><strong>Type of School</strong>: <?php echo $school_type;?></p><?php } ?>
		
		<? if($programs_offered){ ?><p><strong>Programs Offered</strong>: <?php echo $programs_offered;?></p><?php } ?>

		<? if($tuition_fees){ ?><p><strong>Tuition &amp; Fees</strong>: $<?php echo $tuition_fees;?></p><?php } ?>
		
		<? if($percent_fin_aid){ ?><p><strong>Percent of Students Receiving Financial Aid</strong>: <?php echo $percent_fin_aid;?>%</p><?php } ?>

		
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>Pages:</span>', 'after' => '</div>' ) ); ?>
					<?php edit_post_link('Edit', '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; // end of the loop. ?>

			</section><!-- #page-content -->
		</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
