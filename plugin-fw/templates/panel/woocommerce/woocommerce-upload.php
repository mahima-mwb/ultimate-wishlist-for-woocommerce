<?php
/**
 * This file belongs to the mwb Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Upload Plugin Admin View
 *
 * @package    mwb
 * @author     Emanuela Castorina <emanuela.castorina@mwbemes.it>
 * @since      1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
$hidden_val = get_option($id . "-mwb-attachment-id", 0);

?>

<tr valign="top">
    <th scope="row" class="image_upload">
        <label for="<?php echo $id ?>"><?php echo $name ?></label>
    </th>
    <td class="forminp forminp-color plugin-option">

        <div id="<?php echo $id ?>-container" class="mwb_options rm_option rm_input rm_text rm_upload"
             <?php if (isset($option['deps'])): ?>data-field="<?php echo $id ?>"
             data-dep="<?php echo $this->get_id_field($option['deps']['ids']) ?>"
             data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
            <div class="option">
                <input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>"
                       value="<?php echo $value == '1' ? '' : esc_attr($value) ?>" class="mwb-plugin-fw-upload-img-url"/>
                <input type="hidden" name="<?php echo $id ?>-mwb-attachment-id" id="<?php echo $id ?>-mwb-attachment-id" value="<?php echo $hidden_val; ?>" />
                <input type="button" value="<?php _e('Upload', 'mwb-plugin-fw') ?>" id="<?php echo $id ?>-button"
                       class="mwb-plugin-fw-upload-button button"/>
            </div>
            <div class="clear"></div>
            <span class="description"><?php echo $desc ?></span>

            <div class="mwb-plugin-fw-upload-img-preview" style="margin-top:10px;">
                <?php
                $file = $value;
                if (preg_match('/(jpg|jpeg|png|gif|ico)$/', $file)) {
                    echo "<img src=\"" . mwb_CORE_PLUGIN_URL . "/assets/images/sleep.png\" data-src=\"$file\" />";
                }
                ?>
            </div>
        </div>


    </td>
</tr>

