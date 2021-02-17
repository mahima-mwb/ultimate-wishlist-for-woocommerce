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

<?php

	$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance();

	$user = wp_get_current_user();
	$get_wishlists = $wishlist_manager->retrieve( 'owner', $user->user_email, array( 'properties' => array( 'default' => true ) ) );

	if( 200 == $get_wishlists['status'] ) {
		$wishlists = ! empty( $get_wishlists['message'] ) ? $get_wishlists['message'] : array();
	}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<main class="wfw_main">
	<header class="wfw_main_header">

		<ul class="wfw_navbar">
			<li class="wfw_navlink active">Your Lists</li>
			<li class="wfw_navlink">Your Friends</li>
		</ul>
		<a class="wfw_navbar_button create_new_list">Create a list</a>

		<!-- Create a list modal start -->
		<div class="wfw_comment_wrapper">
			<div class="wfw_comment">
				<div class="wfw_comment_head">
					<span>Add comment, quantity & priority</span>
					<span class="wfw_comment_close">+</span>
				</div>
				<form action="">
					<p><label for="list-name">List Name</label></p>
					<p><input type="text" value="My First List"></p>
					<p><span>Use a proper list name that will depict a good rememberance</span></p>
					<p><a href="#">Learn more</a></p>
					<p class="wfw_comment_buttons">
					<span class="wfw_comment_cancel">Cancel</span>
					<button class="wfw_comment_save">Create list</button>
					</p>
				</form>
			</div>
		</div>
		<!-- Create a modal ends here -->
	</header>

	<section class="wfw_content">

		<ul class="wfw_content-left">
			<li class="wfw_content-left_list">
				<div class="wfw_content-list_des"><a href="#">Shopping List</a><span>Shared</span></div><p>Default list</p>
			</li>
			<li class="wfw_content-left_list">
				<div class="wfw_content-list_des"><a href="#">Shopping List</a><span>Shared</span></div><p>Default list</p>
			</li>
		</ul>

		<div class="wfw_content-right_wrapper">
			<div class="wfw_content-right">
				<div class="wfw_content-right_head">
					<div class="wfw_content-list_des">
						<a href="#">Shopping List</a>
						<span>Shared</span>
					</div>
					<p class="wfw_invite-icon">
						<i class="fas fa-user-circle"></i> 
						<a href="#"><span>+</span> invite</a>
					</p>
				</div>
				<div class="wfw_more_links">
					<a href="#">
						<i class="fab fa-facebook"></i>
					</a>
					<a href="#">
						<i class="fab fa-whatsapp"></i>
					</a>
					<a href="#">
						<i class="fab fa-instagram"></i>
					</a>
					
					<span href="" class="wfw_content_more">
						<i class="fas fa-ellipsis-h"></i> <span>more</span>
						<ul class="wfw_content_more_link">
							<li><a href="#">manage list</a></li>
							<li><a href="#">print list</a></li>
						</ul>
					</span>
				</div>
			</div>
			<ul class="wfw_content-right_item_list">
				<li class="wfw_content-right_item">
					<div class="wfw_content-right_item-img">
						<a href="#">
							<!-- <img src="" alt=""> -->
							<i class="fas fa-file-image"></i>
						</a>
					</div>
					<div class="wfw_content-right_item-desc">
						<p class="item_title">
						<a href="#">
							Samsung galaxy M20 | Triple camera smartphone
						</a> 
						</p>
						<p class="item_rating">
							<span class="item_stars">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star-half-alt"></i>
							</span>
							<a href="#" class="rate_count">~5214
							</a>
						</p>
						<p class="item_price">
							<span class="price_value">
							Rs 8,562
							</span>
							<span class="item_delivery">
							(Free delivery)
							</span>
							<span class="item_detail">
							<a href="#">Details</a>
							</span> 
						</p>
						<p class="item_desc">
							This product has a waranty of 1year and has some important care.
						</p>
						<p class="item_variation">
							Blue
						</p>
					</div>
					<div class="wfw_content-right_item-action">
						<p class="action_date">
						Item added 12 feb 2021
						</p>
						<p>
							<a href="" class="action_button">
							Add to cart
							</a>
						</p> 
						<p class="action_delete">
							Delete
						</p>
						<p class="action_comment">
							Add comment, quantity & proirity
						</p>
						<div class="wfw_comment_wrapper">
						<div class="wfw_comment">
							<div class="wfw_comment_head">
								<span>Add comment, quantity & priority</span>
								<span class="wfw_comment_close">+</span>
							</div>
							<form action="">
								<ul class="wfw_comment_content">
									<li>
										<div class="wfw_content-right_item-img">
											<a href="#">
											<!-- <img src="" alt=""> -->
											<i class="fas fa-file-image"></i>
											</a>
										</div>
									</li>
									<li class="wfw_comment_message">
										<label for="comments" class="wfw_comment_label">Comment
										</label>
										<p><textarea name="comment" id="wfw_comment_message" cols="4" rows="5"></textarea>
										</p>
										<p class="wfw_comment_remaining">Remaining : 250 characters
										</p>
									<div class="wfw_comment_priority">
										<span>
											<label for="comments" class="wfw_comment_label">Priority
											</label>
											<p>
											<select name="priority" id="wfw_comment_priority">
												<option value="Medium">Medium</option>
												<option value="Medium">high</option>
												<option value="Medium">low</option>
											</select>
											</p>
										</span>
											<span>
												<label for="needs">Needs:</label>
												<p>
													<input type="number" value="1">
												</p>
											</span>
											<span>
												<label for="needs">Has:</label>
												<p>
													<input type="number" value="0">
												</p>
											</span>
									</div>
									</li>
								</ul>
								<p class="wfw_comment_buttons">
								<span class="wfw_comment_cancel">Cancel</span>
								<button class="wfw_comment_save">Save</button>
								</p>
							</form>
						</div>
						</div>
						</p> 
					</div>
				</li>
			</ul>
		</div>

	</section>
</main>