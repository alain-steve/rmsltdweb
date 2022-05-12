<?php if(! defined('ABSPATH')){ return; }

	class ZnBeforeAfterImage extends ZnElements {
		/**
		 * Output the inline css to head or after the element in case it is loaded via ajax
		 */
		function css() {

			$uid = $this->data['uid'];
			$css = '';
			$_ba_precent 	  = $this->opt('ba_precent', '40');
			$dragBarSize 	  = $this->opt('ba_drag_size', '2');
			$custom_color     = $this->opt('ba_drag_color', '#cd2122');
			$positionBar 	  = $this->opt('ba_position', 'horizontal');
			$rotate           = $this->opt('ba_rotate', 'no');
			$checkPosition    = ( $positionBar === 'horizontal' );
			$outputBarSize    = ( $checkPosition ) ? "height:{$dragBarSize}px" : "width:{$dragBarSize}px";

			$css .= '#'.$uid.' .beforeAfter-dragBar {background:'.$custom_color.';}'; //set color for dragbar
			$css .= '#'.$uid.' .beforeAfter-dragBar {'.$outputBarSize.'}'; //set width or height for dragbar

			$translate = "
				-webkit-transform: translate(-50%, -50%);
			    -moz-transform: translate(-50%, -50%);
			    transform: translate(-50%, -50%);
			";
			$translateRotate = "
				-webkit-transform: translate(-50%, -50%) rotate(90deg);
			    -moz-transform: translate(-50%, -50%) rotate(90deg);
			    transform: translate(-50%, -50%) rotate(90deg);
			";

			if($checkPosition) {
				$css .= '#'.$uid.'.beforeAfter--horizontal .beforeAfter-dragBar {top:'.$_ba_precent.'%}'; //set start position
				$css .= '#'.$uid.'.beforeAfter--horizontal .beforeAfter-imgAfter  {height:'.$_ba_precent.'%}'; //set start position
			}else{
				$css .= '#'.$uid.'.beforeAfter--vertical .beforeAfter-dragBar {left:'.$_ba_precent.'%}'; //set start position
				$css .= '#'.$uid.'.beforeAfter--vertical .beforeAfter-imgAfter {width:'.$_ba_precent.'%}'; //set start position
			}

			//  Check to see if we also need to rotate the image
			if( $rotate == 'yes' ){
				$css .= "#{$uid} .beforeAfter-dragIcon { {$translateRotate}; }";
			}
			else{
				$css .= "#{$uid} .beforeAfter-dragIcon { {$translate}; }";
			}

			return $css;
		}

		function js(){ }
		/**
		 * This method is used to display the output of the element.
		 *
		 * @return void
		 */
		function element()
		{
			$uid = $this->data['uid'];

			$options = $this->data['options'];

			$slide_image   = $this->opt( 'image_box_image_before' );
			$slide_image2  = $this->opt( 'image_box_image_after' );
			$_ba_drag_icon = $this->opt( 'ba_drag_icon', '' );

			$image_before = null;
			$image_after = null;
			$image_dragIcon = null;

			$classes = array();
			$classes[] = $uid;
			$classes[] = zn_get_element_classes($options);

			if( empty($slide_image) || empty($slide_image2) )
			{
				return;
			}
			else
			{
				$image_before = '<img src="'.$slide_image.'" />';
				$image_after  = '<img src="'.$slide_image2.'" />';
			}

			if( !empty($_ba_drag_icon) )
			{
				$image_dragIcon = '<div class="beforeAfter-dragIcon"><img src="'.$_ba_drag_icon.'"></div>';
			}

			echo '<div class="beforeAfter '.zn_join_spaces($classes).'" id="'.$uid.'" data-auto="'.$this->opt('ba_auto', 'false').'" data-position="'.$this->opt('ba_position', 'vertical').'" data-reveal="'.$this->opt('ba_reveal', 'false').'">
				'. $image_before .'
					<div class="beforeAfter-imgAfter">
					'. $image_after .'
				</div>
				<div class="beforeAfter-dragBar">'.$image_dragIcon.'</div>
			</div>';
		}

		/**
		 * This method is used to retrieve the configurable options of the element.
		 * @return array The list of options that compose the element and then passed as the argument for the render() function
		 */
		function options()
		{
			$uid = $this->data['uid'];

			$options = array(
				'has_tabs'  => true,
				'general' => array(
					'title' => 'General options',
					'options' => array(
						array (
							"name"        => __( "Image Before", 'zn_framework' ),
							"description" => __( "Please select an image with the same resolution as the second one", 'zn_framework' ),
							"id"          => "image_box_image_before",
							"std"         => "",
							"type"        => "media",
							"alt"         => true,
						),
						array (
							"name"        => __( "Image After", 'zn_framework' ),
							"description" => __( "Please select an image with the same resolution as the first one", 'zn_framework' ),
							"id"          => "image_box_image_after",
							"std"         => "",
							"type"        => "media",
							"alt"         => true,
						),

						array (
							"name"        => __( "Auto Dragging?", 'zn_framework' ),
							"description" => __( "The dragging will start automatically when the mouse reach inside the element", 'zn_framework' ),
							"id"          => "ba_auto",
							"std"         => "0",
							"type"        => "zn_radio",
							"options"     => array (
								'1' => 	__( 'Yes', 'zn_framework' ),
								'0' => 	__( 'No', 'zn_framework' )
							),
						),
						array (
							"name"        => __( "Start position of Drag Bar", 'zn_framework' ),
							"description" => __( "Please insert the start position in precent of Drag Bar.", 'zn_framework' ),
							"id"          => "ba_precent",
							"std"         => "vertical",
							'type'        => 'slider',
							'std'         => '40',
							'helpers'     => array(
								'min' => '0',
								'max' => '100',
								'step' => '1'
							),
						),
						array (
							"name"        => __( "Drag Bar Position", 'zn_framework' ),
							"description" => __( "The Drag Bar position influences the dragging style as well. If the horizontal mode is choosen, the image will be revealed from top to bottom.", 'zn_framework' ),
							"id"          => "ba_position",
							"std"         => "vertical",
							"type"        => "zn_radio",
							"options"     => array (
								'horizontal' => __( 'Horizontal', 'zn_framework' ),
								'vertical' => 	__( 'Vertical', 'zn_framework' )
							),
						),
						array (
							"name"        => __( "Reveal on Click?", 'zn_framework' ),
							"description" => __( "It will reveal the after image when you click anywhere", 'zn_framework' ),
							"id"          => "ba_reveal",
							"std"         => "0",
							"type"        => "zn_radio",
							"options"     => array (
								'1' => __( 'Yes', 'zn_framework' ),
								'0' => __( 'No', 'zn_framework' )
							),
						),
					),
				),
				'style' => array(
					'title' => 'Style options',
					'options' => array(

						array(
							'description' => 'Select the Drag Bar Size in pixels.',
							'name'        => 'Drag Bar Size',
							'id'          => 'ba_drag_size',
							'type'        => 'slider',
							'std'         => '2',
							'helpers'     => array(
								'min' => '1',
								'max' => '50',
								'step' => '1'
							),
						),
						array (
							"name"        => __( "Drag Bar Color", 'zn_framework' ),
							"description" => __( "Select the DragBar background color.", 'zn_framework' ),
							"id"          => "ba_drag_color",
							"std"         => "rgba(204, 204, 204, 0.5)",
							"type"        => "colorpicker",
							'alpha'        => true,
							'live' => array(
								'type'      => 'css',
								'css_class' => '#'.$uid.' .beforeAfter-dragBar',
								'css_rule'  => 'background',
								'unit' 		=> ''
							)
						),
						array (
							"name"        => __( "Drag Bar Center Icon", 'zn_framework' ),
							"description" => __( "Add a center icon on the DragBar.", 'zn_framework' ),
							"id"          => "ba_drag_icon",
							"std"         => "",
							"type"        => "media",
						),
						array (
							"name"        => __( "Rotate the image?", 'zn_framework' ),
							"description" => __( "Choose yes if you want to rotate the image 90 degrees", 'zn_framework' ),
							"id"          => "ba_rotate",
							"std"         => "no",
							"type"        => "zn_radio",
							"options"     => array (
								'yes' => __( 'Yes', 'zn_framework' ),
								'no' => __( 'No', 'zn_framework' )
							),
						),
					),
				),
				'help' => znpb_get_helptab( array(
					'video'   => sprintf( '%s', esc_url('https://my.hogash.com/video_category/kallyas-wordpress-theme/#aKNFr7BfB5k') ),
					'docs'    => sprintf( '%s', esc_url('https://my.hogash.com/documentation/image-box/') ),
					'copy'    => $uid,
					'general' => true,
				)),

			);
			return $options;
		}
	}