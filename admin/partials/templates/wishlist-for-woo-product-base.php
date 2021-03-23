<?php
/**
 * The admin-specific functionality of the plugin. Wishlist reporting file used to show product based performance.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    wishlist-for-woo
 * @subpackage Wishlist_For_Woo/admin/partials/templates
 */

    $args = array(
        'post_type'      => 'product',
        'product_status'    => 'public',
        'posts_per_page'    => -1,
    );

    $datastore = array();

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;

        $manager = Wishlist_For_Woo_Crud_Manager::get_instance();
        $response = $manager->retrieve(  'products', get_the_ID() );
        $all_wishlists = 200 == $response[ 'status' ] ? $response[ 'message' ] : false;
       
        if( 200 != $response[ 'status' ] ) {
            continue;
        }
        
        $wishlist = array();
        if( ! empty( $all_wishlists ) && is_array( $all_wishlists ) ) :
            foreach ( $all_wishlists as $key => $list ) :
                $_id = $list['id' ] ? $list['id' ] : false;
                $manager = new Wishlist_For_Woo_Crud_Manager( $_id );
                $result = $manager->get_prop( 'title' );
                array_push( $wishlist, $result );
            endforeach;
        endif;

        $dataset = array(
            'id'                =>  get_the_ID(),
            'title'             =>  get_the_title(),
            'image'             =>  wp_get_attachment_url( $product->get_image_id() ),
            'wishlist_count'    =>  count( $all_wishlists ),
            'wishlists'         =>  implode( ',', $wishlist ),
        );
        
        array_push( $datastore, $dataset );
        
    endwhile;

    // Sort on the basis of count.
    $wishlist_count = array();
    foreach ($datastore as $key => $row){
        $wishlist_count[$key] = $row['wishlist_count'];
    }
    array_multisort( $wishlist_count, SORT_DESC, $datastore );
?>

<div class="mwb-table__wrapper">
    <table border="2px" id="mwb-table" width="100%" class="mwb-table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Product Id', 'wishlist-for-woo' ); ?></th>
                <th><?php esc_html_e( 'Product Title', 'wishlist-for-woo' ); ?></th>
                <th><?php esc_html_e( 'Product Thumbnail', 'wishlist-for-woo' ); ?></th>
                <th><?php esc_html_e( 'Wishlists Count', 'wishlist-for-woo' ); ?></th>
                <th><?php esc_html_e( 'Wishlists', 'wishlist-for-woo' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if( ! empty( $datastore ) && is_array( $datastore ) ) : ?>
                <?php foreach ( $datastore as $key => $value ) : ?>
                    <tr>
                        <td><?php echo esc_html( $value['id'] ); ?></td>
                        <td><?php echo esc_html( $value['title'] ); ?></td>
                        <td><img src="<?php echo esc_url( $value['image'] );  ?>" class="mwb-wfw-prod-img" ></td>
                        <td><?php echo esc_html( $value['wishlist_count'] ); ?></td>
                        <td><?php echo esc_html( $value['wishlists'] ); ?></td>
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