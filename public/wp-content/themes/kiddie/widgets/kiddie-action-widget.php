<?php
/**
 * Kiddie action widget
 *
 * @package Kiddie
 */

// Load and register widget
add_action( 'widgets_init', function () {
	register_widget( 'Kiddie_Action_Widget' );
	wp_enqueue_script( 'underscore' );
	wp_enqueue_style( 'admin_custom', get_template_directory_uri() . '/css/widgets.css' );
});

// Kiddie action widget
class Kiddie_Action_Widget extends WP_Widget
{
	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_action_widget',
			esc_html__( 'Kiddie Action Widget', 'kiddie' ),
			array( 'description' => esc_html__( 'Action widget for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// these are our widget options, everything is escaped before print also default is set
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? ( $instance['title'] ) : '' );
		$description = isset( $instance['description'] ) ? ( $instance['description'] ) : '';
		$button_url = isset( $instance['button_url'] ) ? ( $instance['button_url'] ) : '';
		$button_name = isset( $instance['button_name'] ) ? ( $instance['button_name'] ) : '';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
        <div class="container ztl-widget-action">
            <div class="row">
                <div class="col-xs-12 ztl-action-element">
                        <span class="ztl-action-content-box">
                            <span class="ztl-action-title">
								<?php
								if ( $title ) {
									echo esc_html( $title );
								}
								?>
                            </span>
                            <span>
								<?php
								if ( $description ) {
									echo esc_html( $description );
								}
								?>
                            </span>

                        </span>
                        <span class="ztl-action-button">
							<a href="<?php echo esc_url( $button_url ); ?>" title="<?php echo esc_attr( $button_name ); ?>"
                               class="ztl-button">
								<?php echo esc_html( $button_name ); ?>
                            </a>
                        </span>
                    <div class="clear"></div>
                </div>

            </div>
        </div>
		<?php
		echo wp_kses( $after_widget,  array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['button_url'] = strip_tags( $new_instance['button_url'] );
		$instance['button_name'] = strip_tags( $new_instance['button_name'] );
		return $instance;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance ,
			array(
			'title' => 'How to Enroll',
			'description' => 'Your Child to a Class?',
			'button_url' => '#',
			'button_name' => 'Learn More',
				)
		);

		$title = isset( $instance['title'] ) ? ( $instance['title'] ) : '';
		$description = isset( $instance['description'] ) ? ( $instance['description'] ) : '';
		$button_url = isset( $instance['button_url'] ) ? ( $instance['button_url'] ) : '';
		$button_name = isset( $instance['button_name'] ) ? ( $instance['button_name'] ) : '';
		?>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"
				   value="<?php echo esc_attr( $description ); ?>"/>
        </p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_name' ) ); ?>"><?php esc_html_e( 'Action Button Name', 'kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_name' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'button_name' ) ); ?>"
				   value="<?php echo esc_attr( $button_name ); ?>"/>
        </p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Button URL', 'kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>"
				   value="<?php echo esc_attr( $button_url ); ?>"/>
        </p>

        <br/>
		<?php
	}
}
