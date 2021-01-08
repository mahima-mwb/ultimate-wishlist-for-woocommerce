<?php
/**
 * This file belongs to the mwb Plugin Framework.
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $field
 * [Important Note] the stored value is:
 *  - array                     if WooCommerce version >= 3.0.0
 *  - string (comma-separated)  otherwise
 */


if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

// metabox backward compatibility
if ( isset( $field[ 'label' ] ) )
    $field[ 'title' ] = $field[ 'label' ];

$default_field = array(
    'id'    => '',
    'title' => isset( $field[ 'name' ] ) ? $field[ 'name' ] : '',
    'desc'  => '',
);
$field         = wp_parse_args( $field, $default_field );

$display_field_only = isset( $field[ 'display-field-only' ] ) ? $field[ 'display-field-only' ] : false;
$is_required        = !empty( $field[ 'required' ] );

$extra_row_classes = $is_required ? array( 'mwb-plugin-fw--required' ) : array();
$extra_row_classes = apply_filters( 'mwb_plugin_fw_metabox_extra_row_classes', $extra_row_classes, $field );
$extra_row_classes = is_array( $extra_row_classes ) ? implode( ' ', $extra_row_classes ) : '';


?>
<div id="<?php echo $field[ 'id' ] ?>-container" <?php echo mwb_field_deps_data( $field ); ?> class="mwb-plugin-fw-metabox-field-row <?php echo $extra_row_classes ?>">
    <?php if ( $display_field_only ) :
        mwb_plugin_fw_get_field( $field, true );
    else: ?>
        <label for="<?php echo $field[ 'id' ] ?>"><?php echo $field[ 'title' ] ?></label>
        <?php mwb_plugin_fw_get_field( $field, true ); ?>
        <div class="clear"></div>
        <span class="description"><?php echo $field[ 'desc' ] ?></span>
    <?php endif; ?>
</div>