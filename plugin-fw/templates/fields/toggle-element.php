<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

//delete_option('ywraq_toggle_element');
$defaults = array(
    'id'                => '',
    'add_button'        => '',
    'name'              => '',
    'class'             => '',
    'custom_attributes' => '',
    'elements'          => array(),
    'title'             => '',
    'subtitle'          => '',
    'onoff_field'       => array(),
    //is an array to print a onoff field, if need to call an ajax action, add  'ajax_action' => 'myaction' in the array args,
    'sortable'          => false,
    'save_button'       => array(),
    'delete_button'     => array()

);
$field    = wp_parse_args( $field, $defaults );

extract( $field );

$show_add_button   = isset( $add_button ) && $add_button;
$add_button_closed = isset( $add_button_closed ) ? $add_button_closed : '';
$values            = isset( $value ) ? $value : get_option( $name, array() );
$values            = maybe_unserialize( $values );
$sortable          = isset( $sortable ) ? $sortable : false;
$class_wrapper     = $sortable ? 'ui-sortable' : '';
$onoff_id          = isset( $onoff_field[ 'id' ] ) ? $onoff_field[ 'id' ] : '';
$ajax_nonce      = wp_create_nonce( 'save-toggle-element' );

if ( empty( $values ) && !$show_add_button && $elements ) {
    $values = array();
    //populate a toggle element with the default
    foreach ( $elements as $element ) {
        $values[ 0 ][ $element[ 'id' ] ] = $element[ 'default' ];
    }
}


?>
<div class="mwb-toggle_wrapper <?php echo $class_wrapper ?>" id="<?php echo $id ?>" data-nonce="<?php echo $ajax_nonce; ?>">
	<?php
		if( !empty( $label ) ):
	?>
		<label for="<?php esc_attr_e($id);?>"><?php echo esc_html( $label );?></label>
	<?php endif;?>
    <?php

    if ( $show_add_button ):

        ?>
        <button class="mwb-add-button mwb-add-box-button"
                data-box_id="<?php echo $id; ?>_add_box"
                data-closed_label="<?php echo esc_attr( $add_button_closed ) ?>"
                data-opened_label="<?php echo esc_attr( $add_button ) ?>"><?php echo $add_button; ?></button>
        <div id="<?php echo $id; ?>_add_box" class="mwb-add-box">
        </div>
        <script type="text/template" id="tmpl-mwb-toggle-element-add-box-content-<?php echo $id ?>">
            <?php foreach ( $elements as $element ):
                $element[ 'title' ] = $element[ 'name' ];

                $element[ 'type' ] = isset( $element[ 'mwb-type' ] ) ? $element[ 'mwb-type' ] : $element[ 'type' ];
                unset( $element[ 'mwb-type' ] );
                $element[ 'value' ] = isset( $element[ 'default' ] ) ? $element[ 'default' ] : '';
                $element[ 'id' ]    = 'new_' . $element[ 'id' ];
                $element[ 'name' ]  = $name . "[{{{data.index}}}][" . $element[ 'id' ] . "]";
                $class_element      = isset( $element[ 'class_row' ] ) ? $element[ 'class_row' ] : '';

                $is_required = !empty( $element[ 'required' ] );
                if ( $is_required ) {
                    $class_element .= ' mwb-plugin-fw--required';
                }
                ?>
                <div class="mwb-add-box-row <?php echo $class_element ?> <?php echo '{{{data.index}}}' ?>">

                    <label for="<?php echo $element[ 'id' ]; ?>"><?php echo( $element[ 'title' ] ); ?></label>
                    <div class="mwb-plugin-fw-option-with-description">
                        <?php
                        echo mwb_plugin_fw_get_field( $element, true ); ?>
                        <span class="description"><?php echo !empty( $element[ 'desc' ] ) ? $element[ 'desc' ] : ''; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if( !empty( $save_button ) ) : ?>
            <div class="mwb-add-box-buttons">
                <button class="button-primary mwb-save-button">
                    <?php echo $save_button[ 'name' ]; ?>
                </button>
            </div>
            <?php endif; ?>
        </script>
    <?php endif; ?>

    <div class="mwb-toggle-elements">
        <?php
        if ( $values ):
            //print toggle elements
            foreach ( $values as $i => $value ):
                $title_element = mwb_format_toggle_title( $title, $value );
                $title_element = apply_filters( 'mwb_plugin_fw_toggle_element_title_' . $id, $title_element, $elements, $value );
                $subtitle_element = mwb_format_toggle_title( $subtitle, $value );
                $subtitle_element = apply_filters( 'mwb_plugin_fw_toggle_element_subtitle_' . $id, $subtitle_element, $elements, $value );
                ?>

                <div id="<?php echo $id; ?>_<?php echo $i; ?>"
                     class="mwb-toggle-row <?php echo !empty( $subtitle ) ? 'with-subtitle' : ''; ?> <?php echo $class; ?>" <?php echo $custom_attributes; ?>
                     data-item_key="<?php echo esc_attr( $i ) ?>">
                    <div class="mwb-toggle-title">
                        <h3>
                    <span class="title"
                          data-title_format="<?php echo esc_attr( $title ) ?>"><?php echo $title_element ?></span>
                            <?php if ( !empty( $subtitle_element ) ): ?>
                                <div class="subtitle"
                                     data-subtitle_format="<?php echo esc_attr( $subtitle ) ?>"><?php echo $subtitle_element; ?></div>
                            <?php endif; ?>
                        </h3>
                        <span class="mwb-toggle">
            <span class="mwb-icon mwb-icon-arrow_right ui-sortable-handle"></span>
        </span>
                        <?php
                        if ( !empty( $onoff_field ) && is_array( $onoff_field ) ):
                            $action = !empty( $onoff_field[ 'ajax_action' ] ) ? 'data-ajax_action="' . $onoff_field[ 'ajax_action' ] . '"' : '';
                            $onoff_field[ 'value' ] = isset( $value[ $onoff_id ] ) ? $value[ $onoff_id ] : $onoff_field[ 'default' ];
                            $onoff_field[ 'type' ] = 'onoff';
                            $onoff_field[ 'name' ] = $name . "[$i][" . $onoff_id . "]";
                            $onoff_field[ 'id' ] = $onoff_id . '_' . $i;
                            unset( $onoff_field[ 'mwb-type' ] );
                            ?>
                            <span class="mwb-toggle-onoff" <?php echo $action; ?> >
                    <?php
                    echo mwb_plugin_fw_get_field( $onoff_field, true );
                    ?>
                </span>

                            <?php if ( $sortable ): ?>
                            <span class="mwb-icon mwb-icon-drag"></span>
                        <?php endif ?>

                        <?php endif; ?>
                    </div>
                    <div class="mwb-toggle-content">
                        <?php
                        if ( $elements && count( $elements ) > 0 ) {
                            foreach ( $elements as $element ):
                                $element[ 'type' ] = isset( $element[ 'mwb-type' ] ) ? $element[ 'mwb-type' ] : $element[ 'type' ];
                                unset( $element[ 'mwb-type' ] );
                                $element[ 'title' ]     = $element[ 'name' ];
                                $element[ 'name' ]      = $name . "[$i][" . $element[ 'id' ] . "]";
                                $element[ 'value' ]     = isset( $value[ $element[ 'id' ] ] ) ? $value[ $element[ 'id' ] ] : $element[ 'default' ];
                                $element[ 'id' ]        = $element[ 'id' ] . '_' . $i;
                                $element[ 'class_row' ] = isset( $element[ 'class_row' ] ) ? $element[ 'class_row' ] : '';

                                $is_required = !empty( $element[ 'required' ] );
                                if ( $is_required ) {
                                    $element[ 'class_row' ] .= ' mwb-plugin-fw--required';
                                }
                                ?>
                                <div class="mwb-toggle-content-row <?php echo $element[ 'class_row' ] . ' ' . $element[ 'type' ] ?>">
                                    <label for="<?php echo $element[ 'id' ]; ?>"><?php echo $element[ 'title' ]; ?></label>
                                    <div class="mwb-plugin-fw-option-with-description">
                                        <?php echo mwb_plugin_fw_get_field( $element, true ); ?>
                                        <span class="description"><?php echo !empty( $element[ 'desc' ] ) ? $element[ 'desc' ] : ''; ?></span>
                                    </div>
                                </div>
                            <?php endforeach;
                        }
                        ?>
                        <div class="mwb-toggle-content-buttons">
                            <div class="spinner"></div>
                            <?php
                            if ( $save_button && !empty( $save_button[ 'id' ] ) ):
                                $save_button_class = isset( $save_button[ 'class' ] ) ? $save_button[ 'class' ] : '';
                                $save_button_name = isset( $save_button[ 'name' ] ) ? $save_button[ 'name' ] : '';
                                ?>
                                <button id="<?php echo $save_button[ 'id' ]; ?>"
                                        class="mwb-save-button <?php echo $save_button_class; ?>">
                                    <?php echo $save_button_name; ?>
                                </button>
                            <?php endif; ?>
                            <?php
                            if ( $delete_button && !empty( $delete_button[ 'id' ] ) ):
                                $delete_button_class = isset( $delete_button[ 'class' ] ) ? $delete_button[ 'class' ] : '';
                                $delete_button_name = isset( $delete_button[ 'name' ] ) ? $delete_button[ 'name' ] : '';
                                ?>
                                <button id="<?php echo $delete_button[ 'id' ]; ?>"
                                        class="button-secondary mwb-delete-button <?php echo $delete_button_class; ?>">
                                    <?php echo $delete_button_name; ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach;
        endif;
        ?>


    </div>
    <!-- Schedule Item template -->
    <script type="text/template" id="tmpl-mwb-toggle-element-item-<?php echo $id ?>">
        <div id="<?php echo $id; ?>_{{{data.index}}}"
             class="mwb-toggle-row  highlight <?php echo !empty( $subtitle ) ? 'with-subtitle' : ''; ?> <?php echo $class; ?>"
             data-item_key="{{{data.index}}}" <?php echo $custom_attributes; ?>
             data-item_key="{{{data.index}}}">
            <div class="mwb-toggle-title">
                <h3>
                    <span class="title" data-title_format="<?php echo esc_attr( $title ) ?>"><?php echo $title ?></span>

                    <div class="subtitle"
                         data-subtitle_format="<?php echo esc_attr( $subtitle ) ?>"><?php echo $subtitle ?></div>

                </h3>
                <span class="mwb-toggle">
            <span class="mwb-icon mwb-icon-arrow_right"></span>
        </span>
                <?php
                if ( !empty( $onoff_field ) && is_array( $onoff_field ) ):
                    $action = !empty( $onoff_field[ 'ajax_action' ] ) ? 'data-ajax_action="' . $onoff_field[ 'ajax_action' ] . '"' : '';
                    $onoff_field[ 'value' ] = $onoff_field[ 'default' ];
                    $onoff_field[ 'type' ] = 'onoff';
                    $onoff_field[ 'name' ] = $name . "[{{{data.index}}}][" . $onoff_id . "]";
                    $onoff_field[ 'id' ] = $onoff_id;
                    unset( $onoff_field[ 'mwb-type' ] );
                    ?>
                    <span class="mwb-toggle-onoff" <?php echo $action; ?> >
                    <?php
                    echo mwb_plugin_fw_get_field( $onoff_field, true );
                    ?>
                </span>

                <?php endif; ?>
                <?php if ( $sortable ): ?>
                    <span class="mwb-icon mwb-icon-drag ui-sortable-handle"></span>
                <?php endif ?>
            </div>
            <div class="mwb-toggle-content">
                <?php
                if ( $elements && count( $elements ) > 0 ) {
                    foreach ( $elements as $element ):
                        $element[ 'type' ] = isset( $element[ 'mwb-type' ] ) ? $element[ 'mwb-type' ] : $element[ 'type' ];
                        unset( $element[ 'mwb-type' ] );
                        $element[ 'title' ] = $element[ 'name' ];
                        $element[ 'name' ]  = $name . "[{{{data.index}}}][" . $element[ 'id' ] . "]";
                        $element[ 'id' ]    = $element[ 'id' ] . '_{{{data.index}}}';
                        $class_element      = isset( $element[ 'class_row' ] ) ? $element[ 'class_row' ] : '';
                        $is_required = !empty( $element[ 'required' ] );
                        if ( $is_required ) {
                            $class_element .= ' mwb-plugin-fw--required';
                        }
                        ?>
                        <div class="mwb-toggle-content-row <?php echo $class_element . ' ' . $element[ 'type' ] ?>">
                            <label for="<?php echo $element[ 'id' ]; ?>"><?php echo $element[ 'title' ]; ?></label>
                            <div class="mwb-plugin-fw-option-with-description">
                                <?php echo mwb_plugin_fw_get_field( $element, true ); ?>
                                <span class="description"><?php echo !empty( $element[ 'desc' ] ) ? $element[ 'desc' ] : ''; ?></span>
                            </div>
                        </div>
                    <?php endforeach;
                }
                ?>
                <div class="mwb-toggle-content-buttons">
                    <div class="spinner"></div>
                    <?php
                    if ( $save_button && !empty( $save_button[ 'id' ] ) ):
                        $save_button_class = isset( $save_button[ 'class' ] ) ? $save_button[ 'class' ] : '';
                        $save_button_name = isset( $save_button[ 'name' ] ) ? $save_button[ 'name' ] : '';
                        ?>
                        <button id="<?php echo $save_button[ 'id' ]; ?>"
                                class="mwb-save-button <?php echo $save_button_class; ?>">
                            <?php echo $save_button_name; ?>
                        </button>
                    <?php endif; ?>
                    <?php
                    if ( $delete_button && !empty( $delete_button[ 'id' ] ) ):
                        $delete_button_class = isset( $delete_button[ 'class' ] ) ? $delete_button[ 'class' ] : '';
                        $delete_button_name = isset( $delete_button[ 'name' ] ) ? $delete_button[ 'name' ] : '';
                        ?>
                        <button id="<?php echo $delete_button[ 'id' ]; ?>"
                                class="button-secondary mwb-delete-button <?php echo $delete_button_class; ?>">
                            <?php echo $delete_button_name; ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </script>

</div>
