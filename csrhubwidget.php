<?php
/*
Plugin Name: CSRHub widget
Plugin URI: http://www.csrhub.com/content/our-widget-and-api
Description: This plugin will help you to install CSRHub widget to your blog
Author: CSRHub team
Version: 1.0
Author URI: http://www.csrhub.com/
*/

class CSRHubWidget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'csrhubwidget',
			__('CSRHub widget'),
			array(
				'classname' => 'CSRHubWidget',
				'description' => 'CSRHub widget on your blog\'s pages'
			)
		);
	}

	function widget($args, $instance) {
		echo $this->build_widget_code((array) $instance);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'hash' => '',
				'teaser' => 'no',
				'company' => '',
				'cobrand' => '',
				'size' => '300x400',
				//'shorttitle' => 'yes'
			)
		);
		?>
<p>
	<label for="<?php echo $this->get_field_id('size'); ?>">Size</label>
	<br/>
	<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>">
		<option value="300x400"<?php if ( '300x400' == $instance['size'] ) echo ' selected'; ?>>300x400</option>
		<option value="300x300"<?php if ( '300x300' == $instance['size'] ) echo ' selected'; ?>>300x300</option>
		<option value="170x200"<?php if ( '170x200' == $instance['size'] ) echo ' selected'; ?>>170x200</option>
		<option value="650x100"<?php if ( '650x100' == $instance['size'] ) echo ' selected'; ?>>650x100</option>
	</select>
	<br/>
	Choose preferred widget size.
	Different widget sizes can fit different areas on your site.
</p>

<p>
	<label for="<?php echo $this->get_field_id('hash'); ?>">Hash code</label>
	<br/>
	<input type="text" name="<?php echo $this->get_field_name('hash'); ?>" id="<?php echo $this->get_field_id('hash'); ?>" value="<?php echo $instance['hash']; ?>" size="6" maxlength="6"/>
	<br/>
	If you received a hash code from CSRHub, you may enter the code here. Otherwise, simply leave this field empty.
</p>

<p>
	<label for="<?php echo $this->get_field_id('cobrand'); ?>">Cobrand</label>
	<br/>
	<input type="text" name="<?php echo $this->get_field_name('cobrand'); ?>" id="<?php echo $this->get_field_id('cobrand'); ?>" value="<?php echo $instance['cobrand']; ?>" style="width: 100%;"/>
	<br/>
	To associate your widget with a CSRHub cobrand, enter the code here. Or simply leave this field empty.
</p>

<p>
	<label for="<?php echo $this->get_field_id('company'); ?>">Company</label>
	<br/>
	<input type="text" name="<?php echo $this->get_field_name('company'); ?>" id="<?php echo $this->get_field_id('company'); ?>" value="<?php echo $instance['company']; ?>" style="width: 100%;"/>
	<br/>
	Enter the default company code to show on the widget. If you have a hash code, you may leave this field empty. Or, if you have a hash code, you may "override" and list a new default company to show on the widget.
</p>

<p>
	<label for="<?php echo $this->get_field_id('teaser'); ?>">Teaser</label>
	<br/>	
	<input type="text" name="<?php echo $this->get_field_name('teaser'); ?>" id="<?php echo $this->get_field_id('teaser'); ?>" value="<?php echo $instance['teaser']; ?>" style="width: 100%;"/>
	<br/>
	If you received a teaser code from CSRHub, enter the code here. If you have a hash code, simply leave this field empty.
</p>
	
<?php /*
<p>
	<input type="checkbox" name="<?php echo $this->get_field_name('shorttitle'); ?>" id="<?php echo $this->get_field_id('shorttitle'); ?>" value="<?php echo $instance['shorttitle']; ?><?php checked($instance['shorttitle'], false); ?>"/>
	<label for="<?php echo $this->get_field_id('shorttitle'); ?>">Shortened title</label>
	<br/>
	Widget title will be shortened.
</p>
*/ ?>
		<?php
	}

	function tag($attr) {
		return self::build_widget_code($attr);
	}

	private function build_widget_code($attr) {
		unset($attr['type']);
		unset($attr['language']);
		unset($attr['src']);

		$j = '<script language="javascript" type="text/javascript" src="http://www.csrhub.com/files/api/embed.js"';
		foreach ( $attr as $name => $value ) {
			$j .= ' ' . htmlspecialchars($name) . '="' . htmlspecialchars($value) . '"';
		}
		$j .= '></script>';
		return $j;
	}

}

add_action(
	'widgets_init',
	create_function('', 'return register_widget("CSRHubWidget");')
);

add_shortcode('csrhubwidget', array('CSRHubWidget', 'tag'));

