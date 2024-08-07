<?php

/**
 * Registers the `books` post type.
 */
function books_init() {
	register_post_type(
		'books',
		[
			'labels'                => [
				'name'                  => __( 'Books', 'book-library' ),
				'singular_name'         => __( 'Book', 'book-library' ),
				'all_items'             => __( 'All Books', 'book-library' ),
				'archives'              => __( 'Book Archives', 'book-library' ),
				'attributes'            => __( 'Book Attributes', 'book-library' ),
				'insert_into_item'      => __( 'Insert into Book', 'book-library' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Book', 'book-library' ),
				'featured_image'        => _x( 'Featured Image', 'books', 'book-library' ),
				'set_featured_image'    => _x( 'Set featured image', 'books', 'book-library' ),
				'remove_featured_image' => _x( 'Remove featured image', 'books', 'book-library' ),
				'use_featured_image'    => _x( 'Use as featured image', 'books', 'book-library' ),
				'filter_items_list'     => __( 'Filter Books list', 'book-library' ),
				'items_list_navigation' => __( 'Books list navigation', 'book-library' ),
				'items_list'            => __( 'Books list', 'book-library' ),
				'new_item'              => __( 'New Book', 'book-library' ),
				'add_new'               => __( 'Add New', 'book-library' ),
				'add_new_item'          => __( 'Add New Book', 'book-library' ),
				'edit_item'             => __( 'Edit Book', 'book-library' ),
				'view_item'             => __( 'View Book', 'book-library' ),
				'view_items'            => __( 'View Books', 'book-library' ),
				'search_items'          => __( 'Search Books', 'book-library' ),
				'not_found'             => __( 'No Books found', 'book-library' ),
				'not_found_in_trash'    => __( 'No Books found in trash', 'book-library' ),
				'parent_item_colon'     => __( 'Parent Book:', 'book-library' ),
				'menu_name'             => __( 'Books', 'book-library' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-book-alt',
			'show_in_rest'          => true,
			'rest_base'             => 'books',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'books_init' );

/**
 * Sets the post updated messages for the `books` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `books` post type.
 */
function books_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['books'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Book updated. <a target="_blank" href="%s">View Book</a>', 'book-library' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'book-library' ),
		3  => __( 'Custom field deleted.', 'book-library' ),
		4  => __( 'Book updated.', 'book-library' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s', 'book-library' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Book published. <a href="%s">View Book</a>', 'book-library' ), esc_url( $permalink ) ),
		7  => __( 'Book saved.', 'book-library' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Book submitted. <a target="_blank" href="%s">Preview Book</a>', 'book-library' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Book</a>', 'book-library' ), date_i18n( __( 'M j, Y @ G:i', 'book-library' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Book draft updated. <a target="_blank" href="%s">Preview Book</a>', 'book-library' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'books_updated_messages' );

/**
 * Sets the bulk post updated messages for the `books` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `books` post type.
 */
function books_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['books'] = [
		/* translators: %s: Number of Books. */
		'updated'   => _n( '%s Book updated.', '%s Books updated.', $bulk_counts['updated'], 'book-library' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Book not updated, somebody is editing it.', 'book-library' ) :
						/* translators: %s: Number of Books. */
						_n( '%s Book not updated, somebody is editing it.', '%s Books not updated, somebody is editing them.', $bulk_counts['locked'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'deleted'   => _n( '%s Book permanently deleted.', '%s Books permanently deleted.', $bulk_counts['deleted'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'trashed'   => _n( '%s Book moved to the Trash.', '%s Books moved to the Trash.', $bulk_counts['trashed'], 'book-library' ),
		/* translators: %s: Number of Books. */
		'untrashed' => _n( '%s Book restored from the Trash.', '%s Books restored from the Trash.', $bulk_counts['untrashed'], 'book-library' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'books_bulk_updated_messages', 10, 2 );
