<?php

class acf_field_nav_menu extends acf_field {

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	public function __construct() {
		/*
		* name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'nav_menu';

		/*
		* label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __('Nav Menu');

		/*
		* category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'relational';

		/*
		* defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array(
			'save_format' => 'id',
			'allow_null'  => 0,
			'container'   => 'div'
		);

		// do not delete!
		parent::__construct();
	}

	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	public function render_field_settings( $field ) {
		// Register the Return Value format setting
		acf_render_field_setting( $field, array(
			'label'        => __( 'Return Value' ),
			'instructions' => __( 'Specify the returned value on front end' ),
			'type'         => 'radio',
			'name'         => 'save_format',
			'layout'       => 'horizontal',
			'choices'      => array(
				'object' => __( 'Nav Menu Object' ),
				'menu'   => __( 'Nav Menu HTML' ),
				'id'     => __( 'Nav Menu ID' ),
			),
		));

		// Register the Menu Container setting
		acf_render_field_setting( $field, array(
			'label'        => __( 'Menu Container' ),
			'instructions' => __( "What to wrap the Menu's ul with (when returning HTML only)",'acf' ),
			'type'         => 'select',
			'name'         => 'container',
			'choices'      => $this->get_allowed_nav_container_tags(),
		));

		// Register the Allow Null setting
		acf_render_field_setting( $field, array(
			'label'        => __( 'Allow Null?' ),
			'type'         => 'radio',
			'name'         => 'allow_null',
			'layout'       => 'horizontal',
			'choices'      => array(
				1 => __( 'Yes' ),
				0 => __( 'No' ),
			),
		));
	}

	private function get_allowed_nav_container_tags() {
		$tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		$formatted_tags = array(
			array( '0' => 'None' )
		);
		foreach( $tags as $tag ) {
			$formatted_tags[0][$tag] = ucfirst( $tag );
		}
		return $formatted_tags;
	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	public function render_field( $field ) {
		$allow_null = $field['allow_null'];
		$nav_menus  = $this->get_nav_menus( $allow_null );

		if ( empty( $nav_menus ) ) {
			return;
		}
		?>
		<select id="<?php esc_attr( $field['id'] ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>">
		<?php foreach( $nav_menus as $nav_menu_id => $nav_menu_name ) : ?>
			<option value="<?php echo esc_attr( $nav_menu_id ); ?>" <?php selected( $field['value'], $nav_menu_id ); ?>>
				<?php echo esc_html( $nav_menu_name ); ?>
			</option>
		<?php endforeach; ?>
		</select>
		<?php
	}

	private function get_nav_menus( $allow_null = false ) {
		$navs = get_terms('nav_menu', array( 'hide_empty' => false ) );

		$nav_menus = array();

		if ( $allow_null ) {
			$nav_menus[''] = ' - Select - ';
		}

		foreach ( $navs as $nav ) {
			$nav_menus[ $nav->term_id ] = $nav->name;
		}

		return $nav_menus;
	}

	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	public function format_value( $value, $post_id, $field ) {
		// bail early if no value
		if ( empty( $value ) ) {
			return false;
		}

		// check format
		if ( 'object' == $field['save_format'] ) {
			$wp_menu_object = wp_get_nav_menu_object( $value );

			if( empty( $wp_menu_object ) ) {
				return false;
			}

			$menu_object = new stdClass;

			$menu_object->ID    = $wp_menu_object->term_id;
			$menu_object->name  = $wp_menu_object->name;
			$menu_object->slug  = $wp_menu_object->slug;
			$menu_object->count = $wp_menu_object->count;

			return $menu_object;
		} elseif ( 'menu' == $field['save_format'] ) {
			ob_start();

			wp_nav_menu( array(
				'menu' => $value,
				'container' => $field['container']
			) );

			return ob_get_clean();
		}

		return $value;
	}
}

// create field
new acf_field_nav_menu();
