<?php

add_action( 'after_setup_theme', 'child_theme_setup_before_parent', 0 );
add_action( 'after_setup_theme', 'child_theme_setup1', 11 );
add_action( 'after_setup_theme', 'child_theme_setup2', 14 );
add_filter( 'hybopress_posts_pagination_args', 'child_theme_posts_pagination_args' );
add_filter( 'hybopress_content_area_classes', 'child_theme_content_area_classes' );

add_action( 'wp', 'child_theme_conditional_setup' );

function child_theme_conditional_setup() {
	if ( is_single() ) {
		//setting priority to 18, so it executes after portfolio closing wrapper
		remove_action( 'hybopress_after_endwhile', 'hybopress_posts_nav', 18 );
		//add_action( 'hybopress_after_endwhile', 'child_theme_posts_nav', 18 );
		//add_action( 'hybopress_after_endwhile', 'hybopress_posts_nav', 18 );
		add_action( 'hybopress_after_entry', 'hybopress_posts_nav', 6 );
		//
	}

	if( is_singular() ) {
		//add_filter( 'hybopress_show_the_featured_image_on_single', 'child_theme_show_the_featured_image_on_single' );
	}
}


function child_theme_show_the_featured_image_on_single( $show_on_single ) {
	return true;
}

function child_theme_content_area_classes( $classes ) {

	foreach( $classes as $key => $value ) {
		if ( $value == 'col-md-8' ) {
			$classes[$key] = 'col-md-9';
		}
	}

	return $classes;
}

add_filter( 'hybopress_sidebar_area_classes', 'child_theme_sidebar_area_classes' );

function child_theme_sidebar_area_classes( $classes ) {

	foreach( $classes as $key => $value ) {
		if ( $value == 'col-md-4' ) {
			$classes[$key] = 'col-md-3';
		}
	}

	return $classes;
}


function child_theme_posts_pagination_args( $args ) {

		$args['prev_text'] = __( '&laquo;', 'author' );
		$args['next_text'] = __( '&raquo;', 'author' );

		return $args;

}

add_filter( 'hybopress_hide_page_background', 'child_theme_hide_page_background', 11 );

function child_theme_setup_before_parent() {
}

function child_theme_setup1() {

	// Register site styles and scripts
	add_action( 'wp_enqueue_scripts', 'child_register_styles' );

	// Enqueue site styles and scripts
	add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );

}

function child_theme_use_cache( $use_cache ) {
	return true;
}


function child_theme_setup2() {
	remove_action( 'hybopress_the_featured_image', 'hybopress_do_the_featured_image' );
	remove_action( 'hybopress_post_info_comments', 'hybopress_do_post_info_comments' );
	remove_action( 'hybopress_post_meta_tags', 'hybopress_do_meta_tags' );
	remove_action( 'hybopress_after_entry', 'hybopress_do_social_share', 7 );
	remove_action( 'hybopress_pings', 'hybopress_do_pings' );

	add_action( 'hybopress_post_info_comments', 'child_theme_do_post_info_comments' );
	add_action( 'hybopress_post_meta_tags', 'child_theme_do_meta_tags' );
	add_action( 'hybopress_after_entry', 'child_theme_do_social_share', 7 );

	//add_action( 'hybopress_entry', 'hybopress_entry_wrap_start', 5 );
	//add_action( 'hybopress_entry', 'hybopress_before_the_featured_image', 6 );
	add_action( 'hybopress_entry', 'hybopress_do_the_featured_image', 7 );
	//add_action( 'hybopress_entry', 'hybopress_after_the_featured_image', 8 );
	//add_action( 'hybopress_entry', 'hybopress_entry_wrap_close', 15 );

	add_action( 'hybopress_pings', 'child_theme_do_pings' );


	add_filter( 'hybopress_use_cache', 'child_theme_use_cache' );

	remove_action( 'comment_form_defaults', 'hybopress_override_comment_form_defaults' );
	add_action( 'comment_form_defaults', 'child_theme_override_comment_form_defaults' );


}

function hybopress_entry_wrap_start() {
	echo '<div class="row">';
}

function hybopress_before_the_featured_image() {
	echo '<div class="col-sm-3">';
}

function hybopress_after_the_featured_image() {
	echo '</div>';
	echo '<div class="col-sm-9">';
}

function hybopress_entry_wrap_close() {
	echo '</div>';
	echo '</div><!-- end .entry row wrap -->';
}

function child_theme_do_pings() {

	global $wp_query;

	//* If have pings
	if ( have_comments() && ! empty( $wp_query->comments_by_type['pings'] ) ) {

		echo '<div id="pings" class="comments entry-pings clearfix">';

			echo apply_filters( 'hybopress_title_pings', __( '<h3>Trackbacks</h3>', 'author' ) );
			echo '<ol class="ping-list list-unstyled comment-list">';
				do_action( 'hybopress_list_pings' );
			echo '</ol>';

		echo '</div><!-- #pings -->';

	} else {

		echo apply_filters( 'hybopress_no_pings_text', '' );

	}

}

function child_theme_do_social_share() {

	if ( ! get_theme_mod( 'enable_social_share_icons', 1 ) || ! is_single() ) {
		return;
	}

	echo do_shortcode( '[hybopress_social_icons icons_type="share" area="social_share" /]' );
}

function child_theme_do_meta_tags(){

	if ( get_theme_mod( 'disable_tags_meta', 0 ) ) {
		return;
	}

	hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'author' ), 'before' => '' ) );

}

function child_theme_do_post_info_comments() {

	if ( get_theme_mod( 'disable_comments_meta', 0 ) ) {
		return;
	}

	//comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' );
	comments_popup_link( false, false, false, 'comments-link' );
}

function child_theme_hide_page_background( $show_hide ) {
	return false;
}

function child_register_styles() {

	wp_register_style( 'child-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400' );

	$main_styles = trailingslashit( HYBRID_CHILD_URI ) . "assets/css/child-style.css";

	wp_register_style(
		sanitize_key(  'child-style' ), esc_url( $main_styles ), array( 'skin' ), PARENT_THEME_VERSION, esc_attr( 'all' )
	);

}

function child_enqueue_styles() {
	wp_enqueue_style( 'child-fonts' );
	wp_enqueue_style( 'child-style' );
}


function child_theme_override_comment_form_defaults( $defaults ) {

	$defaults['class_submit'] = $defaults['class_submit'] . ' btn btn-primary';

	foreach ( $defaults['fields'] as $key => $field ) {
		$defaults['fields'][$key] = child_theme_make_comment_field_horizontal( $field );
	}

	$defaults['comment_field']        = child_theme_make_comment_field_horizontal( $defaults['comment_field'] );
	$defaults['logged_in_as']         = hybopress_make_comment_notes_help_block( $defaults['logged_in_as'] );
	$defaults['comment_notes_before'] = hybopress_make_comment_notes_help_block( $defaults['comment_notes_before'] );
	$defaults['comment_notes_after']  = hybopress_make_comment_notes_help_block( $defaults['comment_notes_after'] );

	return $defaults;

}


/**
* Rewrite markup to strip paragraph and wrap in horizontal form block markup.
*
* @param string $field
*
* @return string
*/

function child_theme_make_comment_field_horizontal( $field ) {

	$field = preg_replace( '|<p class="(.*?)">|', '<div class="$1 form-group">', $field );

	$field =
	strtr(
		$field,
		array(
			'<label'    => '<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left comment-label"', //control-label
			'<input'    => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-field"><input class="form-control"',
			'<textarea' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-field"><textarea cols="45" rows="8" class="form-control"',
			'</p>'      => '</div>',
		)
	);

	$field .= '</div>';

	return $field;

}
