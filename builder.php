<!-- 
    Template Name: Custom builder
 -->
<?php get_header(); 
$flexibleContentPath = dirname(__FILE__) . '/templates/';
if ( have_rows( 'builder' ) ) :
	while ( have_rows( 'builder' ) ) : the_row();
		$file = ( $flexibleContentPath . str_replace( '_', '-', get_row_layout()) . '.php' );
		if ( file_exists( $file ) ) {
			include( $file );
		}
	endwhile;
endif;
get_footer();