<?php
/**
 * Cherry Projects
 *
 * @package   RV_Portfolio
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

/**
 * Class for register post types.
 *
 * @since 1.0.0
 */
class RV_Portfolio_Registration {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up needed actions/filters.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Adds the team post type.
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		add_action( 'post.php',          array( $this, 'add_post_formats_support' ) );
		add_action( 'load-post.php',     array( $this, 'add_post_formats_support' ) );
		add_action( 'load-post-new.php', array( $this, 'add_post_formats_support' ) );
	}

	/**
	 * Register the custom post type.
	 *
	 * @since 1.0.0
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_post_type() {

		$labels = array(
			'name'               => __( 'RV Portfolio', 'rv-portfolio' ),
			'singular_name'      => __( 'Portfolio items', 'rv-portfolio' ),
			'add_new'            => __( 'Add Portfolio Item', 'rv-portfolio' ),
			'add_new_item'       => __( 'Add Portfolio Item', 'rv-portfolio' ),
			'edit_item'          => __( 'Edit Portfolio Item', 'rv-portfolio' ),
			'new_item'           => __( 'New Portfolio Item', 'rv-portfolio' ),
			'view_item'          => __( 'View Portfolio Item', 'rv-portfolio' ),
			'search_items'       => __( 'Search Portfolio Items', 'rv-portfolio' ),
			'not_found'          => __( 'No Portfolio Items found', 'rv-portfolio' ),
			'not_found_in_trash' => __( 'No Portfolio Items found in trash', 'rv-portfolio' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'page-attributes',
			'post-formats',
			'comments',
			'cherry-layouts',
			'page-attributes',
			'cherry-grid-type',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'rv-portfolio-archive', ), // Permalinks format
			'menu_position'   => null,
			'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-portfolio' : '',
			'can_export'      => true,
			'has_archive'     => true,
			'taxonomies'      => array( 'post_format' )
		);


		$args = apply_filters( 'rv_portfolio_post_type_args', $args );

		register_post_type( RV_PORTFOLIO_NAME, $args );
	}

	/**
	 * Post formats.
	 *
	 * @since 1.0.0
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function add_post_formats_support() {
		global $typenow;

		if ( RV_PORTFOLIO_NAME != $typenow ) {
			return;
		}

		$args = apply_filters( 'rv_portfolio_add_post_formats_support', array( 'image', 'gallery', 'audio', 'video', ) );

		add_post_type_support( RV_PORTFOLIO_NAME, 'post-formats', $args );
		add_theme_support( 'post-formats', $args );
	}

	/**
	 * Register the custom taxonomy.
	 *
	 * @since 1.0.0
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public static function register_taxonomy() {

		//Register the category taxonomy
		$category_taxonomy_labels = array(
			'name'          => __( 'RV Portfolio Categories', 'rv-portfolio' ),
			'label'         => __( 'Categories', 'rv-portfolio' ),
			'singular_name' => __( 'Category', 'rv-portfolio' ),
			'menu_name'     => __( 'Categories', 'rv-portfolio' ),
		);
		$category_taxonomy_args = array(
			'labels'		=> $category_taxonomy_labels,
			'hierarchical'	=> true,
			'rewrite'		=> true,
			'query_var'		=> true
		);
		register_taxonomy( RV_PORTFOLIO_NAME . '_category', RV_PORTFOLIO_NAME, $category_taxonomy_args );

		//Register the tag taxonomy
		$tag_taxonomy_labels = array(
			'name'          => __( 'RV Portfolio Tags', 'rv-portfolio' ),
			'label'         => __( 'Tags', 'rv-portfolio' ),
			'singular_name' => __( 'Tag', 'rv-portfolio' ),
			'menu_name'     => __( 'Tags', 'rv-portfolio' ),
		);
		$tag_taxonomy_args = array(
			'labels'		=> $tag_taxonomy_labels,
			'hierarchical'	=> false,
			'rewrite'		=> true,
			'query_var'		=> true
		);
		register_taxonomy( RV_PORTFOLIO_NAME . '_tag', RV_PORTFOLIO_NAME, $tag_taxonomy_args );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

/**
 * Returns instanse of plugin configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function rv_portfolio_registration() {
	return RV_Portfolio_Registration::get_instance();
}

rv_portfolio_registration();

