<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/public/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<main class="wfw_main">
	<header class="wfw_main_header">
		<ul class="wfw_navbar">
			<li class="wfw_navlink <?php echo esc_html( $access == 'edit' ? 'active' : '' ); ?>"><a href="?"><?php esc_html_e( 'Your Lists', 'wishlist-for-woo' ); ?></a></li>
			<li class="wfw_navlink <?php echo esc_html( $access == 'view' ? 'active' : '' ); ?>"><?php esc_html_e( 'Your Friends', 'wishlist-for-woo' ); ?></li>
		</ul>
	</header>

	<section class="wfw_content">

		<ul class="wfw_content-left">
			<?php
			// Wishlist Exists conditions start.
			if ( ! empty( $owner_lists ) && is_array( $owner_lists ) ) : 

				$default = '';
				foreach ( $owner_lists as $key => $obj ) :

					$id      = ! empty( $obj['id'] ) ? $obj['id'] : false;
					$default = ! empty( $default ) ? $default : $id;

					$wishlist_manager->id = $id;

					$wishlist_title  = $wishlist_manager->get_prop( 'title' );
					$wishlist_status = $wishlist_manager->get_prop( 'status' );
					$properties      = $wishlist_manager->get_prop( 'properties' );

					?>

					<li class="wfw_content-left_list">
						<div class="wfw_content-list_des"><a href="?wl-ref=<?php echo esc_html( Wishlist_For_Woo_Helper::encrypter( $id ) ); ?>"><?php echo esc_html( $wishlist_title ); ?></a><span><?php echo ( $access == 'edit' ) ? esc_html( ucwords( $wishlist_status ) ) : ''; ?></span></div><p><?php ( $access == 'edit' ) && $properties->default == true ? esc_html_e( 'Default list', 'wishlist-for-woo' ) : ''; ?></p>
					</li>

					<?php

				endforeach;
			endif;
			// Wishlist Exists conditions ends.
			?>
		</ul>

		<?php
			// Wishlist to show content.
			$wid_to_show          = ! empty( $wid_to_show ) ? $wid_to_show : $default;
			$wishlist_manager->id = $wid_to_show;
			$search               = $wishlist_manager->retrieve();

			// Wishlist Not Found.
			if ( 200 != $search['status'] ) :
			?>

			<div class="error-404 not-found">
				<div class="page-content">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That wishlist can&rsquo;t be found.', 'wishlist-for-woo' ); ?></h1>
					</header><!-- .page-header -->

					<p><?php esc_html_e( 'Nothing was found at this location or you might not have access to this content.', 'wishlist-for-woo' ); ?></p>

				</div><!-- .page-content -->
			</div><!-- .error-404 -->

			<?php else :

				$wishlist_title  = $wishlist_manager->get_prop( 'title' );
				$wishlist_status = $wishlist_manager->get_prop( 'status' );
				$properties      = $wishlist_manager->get_prop( 'properties' );
				$products        = $wishlist_manager->get_prop( 'products' );
				$collaborators   = $wishlist_manager->get_prop( 'collaborators' );
				$is_shared       = ! empty( $collaborators ) ? esc_html__( 'Shared', 'wishlist-for-woo' ) : '';

				?>
				<div class="wfw_content-right_wrapper">
					<div class="wfw_content-right">
						<div class="wfw_content-right_head">
							<div class="wfw_content-list_des">
								<a href="?wl-ref=<?php echo esc_html( Wishlist_For_Woo_Helper::encrypter( $id ) ); ?>"><?php echo esc_html( $wishlist_title ); ?></a>
								<span><?php echo ( $access == 'edit' ) ? esc_html( $is_shared ) : ''; ?></span>
							</div>
							<?php if( $access == 'edit' ) : ?>
							<p class="wfw_invite-icon">
								<i class="fas fa-user-circle"></i> 
								<a title="<?php esc_html_e( 'Invite Collaborator' ); ?>" class="thickbox mwb-wfw-invite" href="#TB_inline?&inlineId=wfw_invite_popup"><span>+</span><?php esc_html_e( 'Invite', 'wishlist-for-woo' ); ?></a>
							</p>
							<div id="wfw_invite_popup"  >
								<div id="wfw_invite_content_wrapper">
									<form id="wfw_email_invite_form" action="" method="post">
										<label for="wfw_invite_email"><?php esc_html_e( 'Email', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></label>
										<input type="email" name="wfw_invite_email" id="wfw_invite_email" value="" >
										<input type="hidden" name="wfw_toshow_id" id="wfw_toshow_id" value="<?php echo esc_html( $wishlist_manager->id ); ?>" >
										<input type="submit" name="wfw_invite_send_button" value="<?php esc_html_e( 'Send', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?>" >
									</form>

								</div>
							</div>
							<?php endif;?>
						</div>
						<div class="wfw_more_links">
						<?php if ( $access == 'edit' ) :

							$page_link = get_permalink( get_option( 'wfw-selected-page', '' ) );

							if ( ! empty( $page_link ) ) {
								$page_link = add_query_arg(
									array(
										'wl-ref' => Wishlist_For_Woo_Helper::encrypter( $id ),
									),
									$page_link
								);

							}

							?>

							<a class="mwb-wfw-share" data-location="facebook" href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo esc_url( $page_link ); ?>&p[title]=<?php echo esc_html( $wishlist_title ); ?>">
								<i class="fab fa-facebook"></i>
							</a>
							<a class="mwb-wfw-share" data-location="whatsapp" href="https://wa.me/?text=<?php echo rawurlencode( $page_link ); ?>">
								<i class="fab fa-whatsapp"></i>
							</a>
							<a class="mwb-wfw-share" data-location="twitter" href="http://twitter.com/share?text=<?php echo esc_html( $wishlist_title ); ?>&url=<?php echo esc_url( $page_link ); ?>">
								<i class="fab fa-twitter"></i>
							</a>
							<a class="mwb-wfw-share" data-location="pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( $page_link ); ?>&description=<?php echo esc_html( $wishlist_title ); ?>">
								<i class="fab fa-pinterest"></i>
							</a>

							<span href="" class="wfw_content_more">
								<i class="fas fa-ellipsis-h"></i> <span><?php esc_html_e( 'More', 'wishlist-for-woo' ); ?></span>
								<ul class="wfw_content_more_link">
									<li><a class="mwb-wfw-default" data-wId="<?php echo esc_html( $wid_to_show ); ?>" href="javascript:void(0);"><?php esc_html_e( 'Set as Default.', 'wishlist-for-woo' ); ?></a></li>
									<li><a class="mwb-wfw-delete" data-wId="<?php echo esc_html( $wid_to_show ); ?>" href="javascript:void(0);"><?php esc_html_e( 'Delete List', 'wishlist-for-woo' ); ?></a></li>
								</ul>
							</span>
						<?php endif; ?>
						</div>
					</div>
					<ul class="wfw_content-right_item_list">
					<?php $products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products; ?>
					<?php if ( ! empty( $products ) && count( $products ) ) : ?>
						<?php foreach ( $products as $key => $id ) : ?>
							<?php
								$_product      = wc_get_product( $id  );
								$image_id      = $_product->get_image_id();
								$image_url     = wp_get_attachment_image_url( $image_id );
								$product_url   = $_product->get_permalink();
								$name          = $_product->get_name();
								$ratings_count = wp_count_comments( $id );
								$rating        = $_product->get_average_rating();
								$count         = $_product->get_rating_count();
								$review_html   = wc_get_rating_html( $rating, $count );
								$price_html    = $_product->get_price_html();
								$description   = $_product->get_short_description() ? $_product->get_short_description() : $_product->get_description();
							?>
							<li class="wfw_content-right_item wfw_list_item_<?php echo esc_html( $id ); ?>">
								<div class="wfw_content-right_item-img">
									<a class="mwb-wfw-product-img" href="<?php echo esc_url( $product_url ); ?>">
										<?php if( ! empty( $image_url ) ) : ?>
											<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_html( $name ); ?>">
										<?php else : ?>
											<i class="fas fa-file-image"></i>
										<?php endif; ?>
									</a>
								</div>
								<div class="wfw_content-right_item-desc">
									<p class="item_title">
										<a class="mwb-wfw-product-name" href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $name ); ?></a>
									</p>
									<p class="item_rating">
										<?php if ( $ratings_count->total_comments ) : ?>
											<a class="mwb-wfw-reviews" href="<?php echo esc_url( $product_url ); ?>#reviews" class="rate_count"><?php echo esc_html( $review_html ); ?>(<?php echo esc_html( $ratings_count->total_comments ); ?>)</a>
										<?php endif; ?>
									</p>
									<p class="item_price">
										<span class="price_value">
										<?php echo $price_html; ?>
										</span>	
										<span class="item_detail">
											<a id="wfw_get_details" href="javascript:void(0)" data-wId="<?php echo esc_html( $wid_to_show ); ?>" data-prod="<?php echo esc_html( $id ); ?>"><?php esc_html_e( 'Details', 'wishlist-for-woo' ); ?></a>
										</span> 
									</p>
									<p class="item_desc">
										<?php echo esc_html( strlen( $description ) > 50 ? substr( $description,0,50 )."..." : $description ); ?>
									</p>
								</div>
								<div class="wfw_content-right_item-action">
									<p>
										<a  id="wfw_add_to_cart" href="javascript:void(0);" data-wId="<?php echo esc_html( $wid_to_show ); ?>" data-prod="<?php echo esc_html( $id ); ?>" class="action_button"><?php esc_html_e( 'Add to cart', 'wishlist-for-woo' ); ?></a>
									</p> 
									<p>
										<a  id="wfw_go_to_checkout<?php echo esc_html( $id ); ?>" href="javascript:void(0);" class="action_button wfw_go_to_checkout"><?php esc_html_e( 'Add to cart', 'wishlist-for-woo' ); ?></a>
									</p> 


									<?php if( $access == 'edit' ) : ?>
									<p class="action_delete" id="wfw_del_prod_frm_wishlist" data-wId="<?php echo esc_html( $wid_to_show ); ?>" data-prod="<?php echo esc_html( $id ); ?>"  >
										<?php esc_html_e( 'Delete', 'wishlist-for-woo' ); ?>
									</p>
									<p><a href="javascript:void(0);" data-wId=<?php echo esc_html( $wid_to_show ); ?> data-prod=<?php echo esc_html( $id ); ?> class="wfw-action-comment"><?php esc_html_e( 'Add comment, quantity & priority', 'wishlist-for-woo' ); ?></a></p>
									<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
						<?php else: ?>
						<span class="data-missing"><?php esc_html_e( 'No Products Added', 'wishlist-for-woo' ); ?></span>
					<?php endif; ?>
					</ul>
				</div>

				<div class="wfw_comment_wrapper">
					<div class="wfw_comment">
						<div class="wfw_comment_head">
							<span><?php esc_html_e( 'Add comment, quantity & priority', 'wishlist-for-woo' ); ?></span>
							<a href="javascript:void(0);" class="wfw_comment_close">+</a>
						</div>
						<form class="add-meta-to-wishlist" action="#" method="post">
							<ul class="wfw_comment_content">
								<li class="wfw_comment_message">
									<label for="comments" class="wfw_comment_label"><?php esc_html_e( 'Comment', 'wishlist-for-woo' ); ?>
									</label>
									<p><textarea name="comment" cols="4" rows="5"></textarea>
									<input type="hidden" class="comment_product" name="product">
									<input type="hidden" class="comment_wid" name="wid">
									</p>
									<p class="wfw_comment_remaining"><?php esc_html_e( 'Remaining : 250 characters', 'wishlist-for-woo' ); ?>
									</p>
									<div class="wfw_comment_priority">
										<span>
											<label for="comments" class="wfw_comment_label"><?php esc_html_e( 'Priority', 'wishlist-for-woo' ); ?>
											</label>
											<p>
											<select name="priority">
												<option value="medium"><?php esc_html_e( 'Medium', 'wishlist-for-woo' ); ?></option>
												<option value="high"><?php esc_html_e( 'High', 'wishlist-for-woo' ); ?></option>
												<option value="low"><?php esc_html_e( 'Low', 'wishlist-for-woo' ); ?></option>
											</select>
											</p>
										</span>
									</div>
								</li>
							</ul>
							<p class="wfw_comment_buttons">
							<button class="wfw_comment_cancel"><?php esc_html_e( 'Cancel', 'wishlist-for-woo' ); ?></button>
							<button class="wfw_comment_save"><?php esc_html_e( 'Save', 'wishlist-for-woo' ); ?></button>
							</p>
						</form>
					</div>
				</div>
				<?php
			endif;
		?>
	</section>
</main>