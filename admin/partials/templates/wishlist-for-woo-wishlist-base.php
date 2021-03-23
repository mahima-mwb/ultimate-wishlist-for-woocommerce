<?php
/**
 * The admin-specific functionality of the plugin. Wishlist reporting file used to show wishlists based performance.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    wishlist-for-woo
 * @subpackage Wishlist_For_Woo/admin/partials/templates
 */

	$manager = Wishlist_For_Woo_Crud_Manager::get_instance();
	$response = $manager->get_all();
	$all_wishlists = 200 == $response['status'] ? $response['response'] : false;
?>

<div class="mwb-table__wrapper">
	<table border="2px" id="mwb-table" width="100%" class="mwb-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Id', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Title', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Products', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Create Date', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Last Modified', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Owner', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Status', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Collaborators', 'wishlist-for-woo' ); ?></th>
				<th><?php esc_html_e( 'Properties', 'wishlist-for-woo' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $all_wishlists ) && is_array( $all_wishlists ) ) : ?>
				<?php foreach ( $all_wishlists as $key => $value ) : ?>
					<tr>
						<?php
							$value['products'] = ! empty( $value['products'] ) ? json_decode( $value['products'] ) : array();
							$value['collaborators'] = ! empty( $value['collaborators'] ) ? json_decode( $value['collaborators'] ) : array();
							$value['properties'] = ! empty( $value['properties'] ) ? json_decode( $value['properties'] ) : array();
						?>
						 
						<td><?php echo esc_html( $value['id'] ); ?></td>
						<td><?php echo esc_html( $value['title'] ); ?></td>
						<td>
							<?php foreach ( $value['products'] as $key => $_id ) : ?>
							   <p><?php echo esc_html( get_the_title( $_id ) ); ?><p>
							<?php endforeach; ?>
						</td>
						<td><?php echo esc_html( $value['createdate'] ); ?></td>
						<td><?php echo esc_html( $value['modifieddate'] ); ?></td>
						<td>
						<?php
						$user = get_user_by( 'email', $value['owner'] );
						echo esc_html( $user->user_nicename ? $user->user_nicename : $value['owner'] );
						?>
						</td>
						<td><?php echo esc_html( $value['status'] ); ?></td>
						<td>
							<?php foreach ( $value['collaborators'] as $key => $email ) : ?>
								<p>
								<?php
									$user = get_user_by( 'email', $email );
								if ( false == $user ) {
									echo esc_html( $email );
								} else {
									echo esc_html( $user->user_nicename );
								}
								?>
									<p>
							<?php endforeach; ?>
						</td>
						<td>
							<?php foreach ( $value['properties'] as $key => $prop ) : ?>
								<?php if ( 'default' == $key ) : ?>
									<?php if ( true == $prop ) : ?>
										<span class="wfw-default-wishlist"><?php esc_html_e( 'Is Default', 'wishlist-for-woo' ); ?> <span class="wfw-tick">&#10003;</span></span>
										<?php else : ?>
										<span class="wfw-default-wishlist"><?php esc_html_e( 'Is Default', 'wishlist-for-woo' ); ?> <span class="wfw-cross">&#10007;</span></span>
									<?php endif; ?>
									
								<?php elseif ( 'comments' == $key && ! empty( $prop ) ) : ?>
									<?php
										$prop = ! is_array( $prop ) ? json_decode( json_encode( $prop ), true ) : $prop;
									if ( ! empty( $prop ) && is_array( $prop ) ) :
										?>
											<?php foreach ( $prop as $pid => $_comments ) : ?>
												<p class="wfw-comments"><?php echo esc_html( get_the_title( $pid ) ); ?><p>
												<span class="wfw-comments"> <span class="wfw-tick">&#10003;</span> <?php esc_html_e( 'Comment', 'wishlist-for-woo' ); ?> : <?php echo esc_html( $_comments['comment'] ); ?></span>
												<span class="wfw-comments"> <span class="wfw-tick">&#10003;</span> <?php esc_html_e( 'Priority', 'wishlist-for-woo' ); ?> : <?php echo esc_html( $_comments['priority'] ); ?></span>
											<?php endforeach; ?>
										<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td style="text-align:center;" colspan="10"><?php esc_html_e( 'No Wishlists Found.', 'wishlist-for-woo' ); ?></td>
				</tr>
			<?php endif; ?>

		</tbody>
	</table>
</div>
