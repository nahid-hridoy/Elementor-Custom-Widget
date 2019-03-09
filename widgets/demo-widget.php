<?php 
/** 
 * Usefull Link: https://code.elementor.com/classes/elementor-widget_base/
 */
class Elementor_Demo_Widget extends \Elementor\Widget_Base {

	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'DemoWidget';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'Demo Widget', 'elementorcw' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'fa fa-adn';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return array( 'general' );
	}

	// The _register_controls method lets you define which controls (setting fields) your widget will have.
	// $this->start_controls_section( string 'unique_id', array() )
	// $this->add_control( string 'name', array() )
	// $this->end_controls_section(); //ending of controls section
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementorcw' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title Text', 'elementorcw' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Hello Universe', 'elementorcw' ),
			]
		);

		$this->end_controls_section();
	}

	// The render() method, which is where you actually render the code and generate the final HTML on the frontend using PHP.
	protected function render() {
		$settings = $this->get_settings_for_display();
		$title = $settings['title'];
		echo "<h2>" . esc_html( $title ) . "</h2>";
	}

	// he _content_template() method, is where you render the editor output to generate the live preview using a Backbone JavaScript template.
	// protected function _content_template() {}

}