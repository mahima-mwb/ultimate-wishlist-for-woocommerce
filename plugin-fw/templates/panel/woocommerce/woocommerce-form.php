<?php
/**
 * @var string $option_key
 */
$panel_content_class = apply_filters( 'mwb_admin_panel_content_class', 'mwb-admin-panel-content-wrap' );
?>

<div id="<?php echo $this->settings[ 'page' ] ?>_<?php echo $option_key ?>" class="mwb-plugin-fw  mwb-admin-panel-container">
    <?php do_action( 'mwb_framework_before_print_wc_panel_content', $option_key ); ?>
    <div class="<?php echo $panel_content_class; ?>">
        <form id="plugin-fw-wc" method="post">
            <?php $this->add_fields() ?>
            <p class="submit" style="float: left;margin: 0 10px 0 0;">
	            <?php wp_nonce_field( 'mwb_panel_wc_options_' . $this->settings[ 'page' ], 'mwb_panel_wc_options_nonce' ); ?>
				<input class="button-primary" type="submit" value="<?php _e( 'Save Changes', 'mwb-plugin-fw' ) ?>"/>
			</p>
        </form>
        <form id="plugin-fw-wc-reset" method="post">
            <?php $warning = __( 'If you continue with this action, you will reset all options in this page.', 'mwb-plugin-fw' ) ?>
            <input type="hidden" name="mwb-action" value="wc-options-reset"/>
            <?php wp_nonce_field( 'mwb_wc_reset_options_' . $this->settings[ 'page' ], 'mwb_wc_reset_options_nonce' ); ?>
            <input type="submit" name="mwb-reset" class="button-secondary" value="<?php _e( 'Reset Defaults', 'mwb-plugin-fw' ) ?>"
                   onclick="return confirm('<?php echo $warning . '\n' . __( 'Are you sure?', 'mwb-plugin-fw' ) ?>');"/>
        </form>
    </div>
    <?php do_action( 'mwb_framework_after_print_wc_panel_content', $option_key ); ?>
</div>