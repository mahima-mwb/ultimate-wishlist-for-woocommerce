<?php
/**
 * This file belongs to the mwb Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var $field
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

extract( $field );

$class   = isset( $class ) ? $class : 'mwb-plugin-fw-select';
$options = mwb_registered_sidebars();
?>
<select id="<?php echo $id ?>"
        name="<?php echo $name ?>"
        class="<?php echo $class ?>"
    <?php echo $custom_attributes ?>
    <?php if ( isset( $data ) ) echo mwb_plugin_fw_html_data_to_string( $data ); ?>>
    <?php foreach ( $options as $key => $item ) : ?>
        <option value="<?php echo esc_attr( $key ) ?>"<?php selected( $key, $value ) ?>><?php echo $item ?></option>
    <?php endforeach; ?>
</select>
