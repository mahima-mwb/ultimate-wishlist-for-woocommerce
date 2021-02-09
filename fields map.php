<?php
public static function get_general_sections_settings() {
		
		$settings = array();


		$settings[] = array(
			'title' => esc_html__( 'This will be heading for General Tab.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
		);
		$settings[] = array(
			'title'             => esc_html__( 'Textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-textarea-field-id',
			'type'              => 'textarea',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-textarea-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'textarea-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);
		$settings[] = array(
			'title'             => esc_html__( 'Enable Select2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'multiselect',
			'desc'              => esc_html__( 'This will be a select2 desctiption', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array( 
									''	=>	esc_html__( 'Options default', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'one'	=>	esc_html__( 'Options 1', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'two'	=>	esc_html__( 'Options 2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'		        => 'mwb-wfw-multi-select',
			'id'   				=> 'mwb-wfw-multi-select-field-id',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'user-role', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'Enable Select', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'This will be a select desctiption', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array( 
									''	=>	esc_html__( 'Options default', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'one'	=>	esc_html__( 'Options 1', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'two'	=>	esc_html__( 'Options 2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'name'          	=> 'true',
			'class'		        => 'mwb-wfw-select',
			'id'   				=> 'mwb-wfw-select-field-id',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'user-role', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title' => esc_html__( 'Enable /Disable Toggle', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' => 'mwb-wfw-toggle-checkbox',
			'type'  => 'checkbox',
			'desc_tip'          => true,
			'id'    => 'mwb-wfw-checkbox-field-id',
			'desc'  => esc_html__( 'Enable /Disable Toggle for any settings', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		$settings[] = array(
			'title' => esc_html__( 'classic checkbox', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' => 'mwb-wfw-classic-checkbox',
			'type'  => 'checkbox',
			'name'  => 'gender',
			'desc_tip'          => true,
			'id'    => 'mwb-wfw-checkbox-classic-id',
			'desc'  => esc_html__( 'Checkbox for any settings', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);
		

		$settings[] = array(
			'title'             => esc_html__( 'Input type Text', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-input-field-id',
			'type'              => 'text',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'input fields', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-input-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'input-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'password type Text', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-password-field-id',
			'type'              => 'password',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'password', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-password-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'password-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'Textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-textarea-field-id',
			'type'              => 'textarea',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-textarea-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'textarea-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'type' => 'sectionend',
		);
		return $settings;
	}