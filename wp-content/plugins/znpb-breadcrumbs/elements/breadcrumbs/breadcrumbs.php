<?php if(! defined('ABSPATH')){ return; }
/*
	Name: Breadcrumbs Element
	Description: This element will generate a breadcrumb element
	Class: znBreadcrumbsElem
	Category: content
	Level: 3
	Style: true
*/


class znBreadcrumbsElem extends ZnElements {

	public static function getName(){
		return __( "Breadcrumbs", 'znpb-breadcrumbs-element' );
	}
	function options() {

		$uid = $this->data['uid'];

		$options = array(
			'has_tabs'  => true,

			'general' => array(
				'title' => 'Content',
				'options' => array(

					array (
						"name"        => __( "Delimiter", 'znpb-breadcrumbs-element' ),
						"description" => __( "Add the delimiter. This only works for minimal style", 'znpb-breadcrumbs-element' ),
						"id"          => "delimiter",
						"std"         => "/",
						"type"        => "text",
						"class"       => "zn_input_sm",
						"dependency"  => array( 'element' => 'style' , 'value'=> array('minimal') ),
					),

					array (
						"name"        => __( "Show Home?", 'znpb-breadcrumbs-element' ),
						"description" => __( "Choose whether to show Home or not.", 'znpb-breadcrumbs-element' ),
						"id"          => "show_home",
						"std"         => "yes",
						'type'        => 'zn_radio',
						'options'        => array(
							'yes' => __( "Yes", 'znpb-breadcrumbs-element' ),
							'no' => __( "No", 'znpb-breadcrumbs-element' ),
						),
						'class'        => 'zn_radio--yesno',
					),

					array (
						"name"        => __( "Home Text", 'znpb-breadcrumbs-element' ),
						"description" => __( "Choose the Home text.", 'znpb-breadcrumbs-element' ),
						"id"          => "home_text",
						"std"         => "Home",
						"type"        => "text",
						"dependency"  => array( 'element' => 'show_home' , 'value'=> array('yes') ),
						// "class"       => "zn_input_sm",
					),

					array (
						"name"        => __( "Custom Home URL", 'znpb-breadcrumbs-element' ),
						"description" => __( "Choose if you want to have a custom Homepage URL.", 'znpb-breadcrumbs-element' ),
						"id"          => "home_link",
						"std"         => "",
						"type"        => "text",
						"dependency"  => array( 'element' => 'show_home' , 'value'=> array('yes') ),
					),

					array (
						"name"        => __( "Show Current?", 'znpb-breadcrumbs-element' ),
						"description" => __( "Show current post/page title in breadcrumbs?", 'znpb-breadcrumbs-element' ),
						"id"          => "show_current",
						"std"         => "yes",
						'type'        => 'zn_radio',
						'options'        => array(
							'yes' => __( "Yes", 'znpb-breadcrumbs-element' ),
							'no' => __( "No", 'znpb-breadcrumbs-element' ),
						),
						'class'        => 'zn_radio--yesno',
					),
				),
			),

			'style' => array(
				'title' => 'Style',
				'options' => array(

					array (
						"name"        => __( "Breadcrumbs Style", 'znpb-breadcrumbs-element' ),
						"description" => __( "Please select the style.", 'znpb-breadcrumbs-element' ),
						"id"          => "style",
						"std"         => "black",
						'type'        => 'select',
						'options'        => array(
							'black' => __( "Background Bar", 'znpb-breadcrumbs-element' ),
							'minimal' => __( "Minimal", 'znpb-breadcrumbs-element' ),
						),
					),

					array (
						"name"        => __( "Background", 'znpb-breadcrumbs-element' ),
						"description" => __( "Choose the background color.", 'znpb-breadcrumbs-element' ),
						"id"          => "black_bg",
						"std"         => "",
						"type"        => "colorpicker",
						"alpha"       => "true",
						"dependency"  => array( 'element' => 'style' , 'value'=> array('black') ),
					),

					array (
						"name"        => __( "Caret Color", 'znpb-breadcrumbs-element' ),
						"description" => __( "Choose the separator color.", 'znpb-breadcrumbs-element' ),
						"id"          => "sep_color",
						"std"         => "",
						"type"        => "colorpicker",
						"alpha"       => "true",
					),

					array (
						"name"        => __( "Typography", 'znpb-breadcrumbs-element' ),
						"description" => __( "Specify the typography properties for the breadcrumbs.", 'znpb-breadcrumbs-element' ),
						"id"          => "typo",
						"std"         => '',
						'supports'   => array( 'size', 'font', 'style', 'line', 'color', 'weight', 'spacing', 'case' ),
						"type"        => "font",
						'live' => array(
							'multiple' => array(
								array(
									'type'      => 'font',
									'css_class' => '.'.$uid,
								),
								array(
									'type'      => 'font',
									'css_class' => '.'.$uid. ' .breadcrumbs li',
								),
							)
						)
					),

					array (
						"name"        => __( "Alignment", 'zn_framework' ),
						"description" => __( "Select the breadcrumb's alignment.", 'zn_framework' ),
						"id"          => "alignment",
						"std"         => "left",
						'type'        => 'select',
						'options'        => array(
							'left' => __( "Left", 'zn_framework' ),
							'center' => __( "Center", 'zn_framework' ),
							'right' => __( "Right", 'zn_framework' ),
						),
						'live'        => array(
							'type'    => 'class',
							'css_class' => '.'.$uid,
							'val_prepend'  => 'text-',
						),
					),

					array (
						"name"        => __( "Items Spacing", 'znpb-breadcrumbs-element' ),
						"description" => __( "Select the spacing between items.", 'znpb-breadcrumbs-element' ),
						"id"          => "spacing",
						"std"         => "",
						"type"        => "text",
						"class"       => "zn_input_xs",
						"numeric"        => true,
						"helpers"        => array(
							"min" => 0,
							"max" => 40,
							"step" => 1,
						),
					),

					/**
					 * Margins and padding
					 */
					array (
						"name"        => __( "Edit element margins for each device breakpoint. ", 'znpb-breadcrumbs-element' ),
						"description" => __( "This will enable you to have more control over the padding of the container on each device. Click to see <a href='http://hogash.d.pr/1f0nW' target='_blank'>how box-model works</a>.", 'znpb-breadcrumbs-element' ),
						"id"          => "spacing_breakpoints",
						"std"         => "lg",
						"tabs"        => true,
						"type"        => "zn_radio",
						"options"     => array (
							"lg"        => __( "LARGE", 'znpb-breadcrumbs-element' ),
							"md"        => __( "MEDIUM", 'znpb-breadcrumbs-element' ),
							"sm"        => __( "SMALL", 'znpb-breadcrumbs-element' ),
							"xs"        => __( "EXTRA SMALL", 'znpb-breadcrumbs-element' ),
						),
						"class"       => "zn_full zn_breakpoints"
					),
					// MARGINS
					array(
						'id'          => 'margin_lg',
						'name'        => 'Margin (Large Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container. Accepts negative margin.',
						'type'        => 'boxmodel',
						'std'	  => '',
						'placeholder' => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('lg') ),
						'live' => array(
							'type'		=> 'boxmodel',
							'css_class' => '.'.$uid,
							'css_rule'	=> 'margin',
						),
					),
					array(
						'id'          => 'margin_md',
						'name'        => 'Margin (Medium Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('md') ),
					),
					array(
						'id'          => 'margin_sm',
						'name'        => 'Margin (Small Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('sm') ),
					),
					array(
						'id'          => 'margin_xs',
						'name'        => 'Margin (Extra Small Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('xs') ),
					),

					// PADDINGS
					array(
						'id'          => 'padding_lg',
						'name'        => 'Padding (Large Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => '',
						'placeholder' => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('lg') ),
						'live' => array(
							'type'		=> 'boxmodel',
							'css_class' => '.'.$uid,
							'css_rule'	=> 'padding',
						),
					),
					array(
						'id'          => 'padding_md',
						'name'        => 'Padding (Medium Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('md') ),
					),
					array(
						'id'          => 'padding_sm',
						'name'        => 'Padding (Small Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('sm') ),
					),
					array(
						'id'          => 'padding_xs',
						'name'        => 'Padding (Extra Small Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'spacing_breakpoints' , 'value'=> array('xs') ),
					),

				),
			),


		);

		return $options;
	}

	function element() {

		$options = $this->data['options'];

		//Class
		$classes[] 	= $uid = $this->data['uid'];
		$classes[] 	= zn_get_element_classes($options);
		$classes[] 	= 'text-'.$this->opt('alignment','left');

		$attributes = zn_get_element_attributes($options);

		// Style
		$box_style = $this->opt('box_style', 1);

	?>

	<div class="znBreacrumbEl <?php echo implode(' ', $classes); ?>" <?php echo $attributes; ?>>

		<?php
			zn_breadcrumbs(array(
				'delimiter' => $this->opt('delimiter', '/'),
				'show_home' => $this->opt('show_home', 'yes') == 'yes' ? true : false,
				'home_text' => $this->opt('home_text', 'Home'),
				'home_link' => $this->opt('home_link', home_url()),
				'show_current' => $this->opt('show_current', 'yes') == 'yes' ? true : false,
				'style' => $this->opt('style', 'black'),
			));
		?>

	</div>

	<?php

	}

	function css(){

		$uid = $this->data['uid'];
		$css = $delim_css = '';
		$style = $this->opt('style','black');

		// Delimiter
		if( $delimiter = $this->opt('delimiter', '/') ){
			$delimiter = str_replace( '\\', '\\\\', $delimiter );
			$delim_css .= "content:'".$delimiter."';";
		}
		// Spacing
		if($spacing = $this->opt('spacing','')){
			$delim_css .= 'margin-left:'.$spacing.'px; margin-right:'.$spacing.'px;';
		}
		// Color
		if($sep_color = $this->opt('sep_color','')){
			$prop = 'color';
			if($style == 'black'){
				$prop = 'border-left-color';
			}
			$delim_css .= $prop.':'.$sep_color.';';
		}
		if(!empty($delim_css)){
			$css .= ".".$uid." .breadcrumbs li:before{ {$delim_css} }";
		}

		$black_bg = $this->opt('black_bg','');
		if( !empty($black_bg) && $style == 'black' ){
			$css .= '.'.$uid.' .breadcrumbs li {background:'. $black_bg .'}';
		}

		// Typography
		$typo['lg'] = $this->opt('typo', array());
		if( !empty($typo) ){
			$typo['selector'] = '.'.$uid.' .breadcrumbs li, .'.$uid.' .breadcrumbs li a';
			$css .= zn_typography_css( $typo );
		}

		// Margins
		$margins = array();
		if($this->opt('margin_lg', '' )) $margins['lg'] = $this->opt('margin_lg');
		if($this->opt('margin_md', '' )) $margins['md'] = $this->opt('margin_md');
		if($this->opt('margin_sm', '' )) $margins['sm'] = $this->opt('margin_sm');
		if($this->opt('margin_xs', '' )) $margins['xs'] = $this->opt('margin_xs');
		if( !empty($margins) ){
			$margins['selector'] = '.'.$uid;
			$margins['type'] = 'margin';
			$css .= zn_push_boxmodel_styles( $margins );
		}
		// Paddings
		$paddings = array();
		if($this->opt('padding_lg', '' )) $paddings['lg'] = $this->opt('padding_lg');
		if($this->opt('padding_md', '' )) $paddings['md'] = $this->opt('padding_md');
		if($this->opt('padding_sm', '' )) $paddings['sm'] = $this->opt('padding_sm');
		if($this->opt('padding_xs', '' )) $paddings['xs'] = $this->opt('padding_xs');
		if( !empty($paddings) ){
			$paddings['selector'] = '.'.$uid;
			$paddings['type'] = 'padding';
			$css .= zn_push_boxmodel_styles( $paddings );
		}


		return $css;

	}

}