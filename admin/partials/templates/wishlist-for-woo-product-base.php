<?php

    $args = array(
        'post_type'      => 'product',
        'product_status'    => 'public'
    );

    $datastore = array();

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;

        $manager = Wishlist_For_Woo_Crud_Manager::get_instance();
        $response = $manager->retrieve(  'products', get_the_ID() );
        $all_wishlists = 200 == $response[ 'status' ] ? $response[ 'message' ] : false;
  
        if( 200 != $all_wishlists[ 'status' ] ) {
            continue;
        }
       
        echo '<pre>'; print_r( get_the_ID() ); echo '</pre>';
        $dataset = array(
            'id'    =>  get_the_ID(),
            'title'    =>  get_the_title(),
            'image'    =>  woocommerce_get_product_thumbnail( 'related-thumb' ),
        );
        
        array_push( $datastore, $dataset );

    endwhile;
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
                        <td><?php echo esc_html( $value['id'] ) ?></td>
                        <td><?php echo esc_html( $value['title'] ) ?></td>
                        <td><?php echo $value['image']; ?></td>
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