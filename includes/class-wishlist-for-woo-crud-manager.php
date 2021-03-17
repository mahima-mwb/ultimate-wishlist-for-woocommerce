<?php

/**
 * The complete management for the Wishlist Objects through out the site.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 */

/**
 * The complete management for the Wishlist Objects.
 *
 * This class defines all code necessary to run CRUD operations.
 * API Docs here : https://docs.google.com/document/d/17K510j0YKeqwQc03a5kjP6e_OI88SSTUTqGygDNhfR8/edit?usp=sharing
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Crud_Manager {

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var Wishlist_For_Woo_Crud_Manager   The single instance of the Wishlist_For_Woo_Crud_Manager
	 */
	protected static $_instance = null;

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var Wishlist_For_Woo_Crud_Manager   The id of the Wishlist Object.
	 */
	public $id = null;

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var Wishlist_For_Woo_Crud_Manager   The table name of the Wishlist db.
	 */
	private $table_name = null;

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var Wishlist_For_Woo_Crud_Manager   The array type entries of the Wishlist Object.
	 */
	private $array_entries =  array( 'products', 'collaborators', 'properties'  );

	/**
	 * Main Wishlist_For_Woo_Crud_Manager Instance.
	 *
	 * Ensures only one instance of Wishlist_For_Woo_Crud_Manager is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Wishlist_For_Woo_Crud_Manager - Main instance.
	 */
	public static function get_instance( $id=null ) {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self( $id );
		}

		return self::$_instance;
	}

 	/**
	 * The constructor of the object.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Wishlist_For_Woo_Crud_Manager - Retrieved instance.
	 */
	public function __construct( $id=null ) {

        // Assign id property.
        $this->id = $id;
        global $wpdb;
        $this->table_name = $wpdb->prefix.  'wishlist_datastore';
	}

 	/**
	 * Create new wishlist.
	 *
	 * @since 1.0.0
	 * @return array $result the result of insertion query.
	 */
    public function create( $atts=array() ) {

        $args = self::parse_query_args( $atts );

        if( empty( $args ) ) {
            return array(
                'status'    => 404, 
                'message'    => esc_html__( 'Invalid Arguments', 'wishlist-for-woo' ), 
            );
        }

        global $wpdb;
        $results = $wpdb->insert( $this->table_name, $args );

        if( ! empty( $wpdb->last_error ) ) {

            $result = array(
                'status'    => 400, 
                'message'    => $wpdb->last_error, 
            );
        }

        else {

            // Assign id property.
            $this->id = $wpdb->insert_id;
            $result = array(
                'status'    => 200, 
                'id'    => $wpdb->insert_id, 
            );    
        }

        return $result;
    }


 	/**
	 * Delete new wishlist.
	 *
	 * @since 1.0.0
	 * @return array $result the result of deletion query.
	 */
    public function delete() {

        if( empty( $this->id ) || ! is_numeric( $this->id ) ) {

            $result = array(
                'status'    => 404, 
                'message'    => esc_html__( 'Invalid ID', 'wishlist-for-woo' ), 
            );

            return $result;
        }

        global $wpdb;
        $results = $wpdb->delete( $this->table_name, array( 'ID' => $this->id ) );

        if( ! empty( $wpdb->last_error ) ) {

            $result = array(
                'status'    => 400, 
                'message'    => $wpdb->last_error, 
            );
        }

        else {

            $result = array(
                'status'    => 200, 
                'message'    => $results,
            );    
        }

        return $result;
    }


 	/**
	 * Create new wishlist.
	 *
	 * @since 1.0.0
	 * @return array $result the result of insertion query.
	 */
    public function update( $atts=array() ) {

        if( empty( $this->id ) || ! is_numeric( $this->id ) ) {

            $result = array(
                'status'    => 404, 
                'message'    => esc_html__( 'Invalid ID', 'wishlist-for-woo' ), 
            );

            return $result;
        }

        $is_row_exists = $this->retrieve();
        
        if ( 200 != $is_row_exists['status'] ) {
            
            return $is_row_exists;
        }

        // Never update create date.
        unset( $atts[ 'createdate' ] );

        // Add last modified date.
        $atts[ 'modifieddate' ] = date( "Y-m-d h:i:s" );

        $args = self::parse_query_args( $atts );

        global $wpdb;

        $response = $wpdb->update( 
            $this->table_name, 
            $args, 
            array( 'ID' => $this->id )
        );
        

        // (int|false) The number of rows updated, or false on error.
        if( ! empty( $wpdb->last_error ) || empty( $response ) ) {

            $result = array(
                'status'    => 400, 
                'message'    => $wpdb->last_error, 
            );
        }

        else {

            $result = array(
                'status'    => 200, 
                'message'    => $response, 
            );    
        }

        return $result;
    }

    /**
	 * Parse data in required format.
	 *
     * @param $key string    
     * @param $value string 
     * @param $args array 
	 * @since 1.0.0
	 * @return array $result the parsed data from query.
	 */
    public function retrieve( $key='', $value='', $additional = array() ) {

        global $wpdb;

        // If required wishlist must have this parameters as properties.
        if ( ! empty( $key ) && ! empty( $value ) ) {

            $operator = in_array( $key, $this->array_entries ) ? 'REGEXP' : '=';
            $get_query = "SELECT id FROM `$this->table_name` WHERE `$key` $operator '$value'";

            if( ! empty( $additional ) && is_array( $additional ) ) {

                foreach ( $additional as $key => $value ) {
                    $operator = in_array( $key, $this->array_entries ) ? 'REGEXP' : '=';

                    $value = 'properties' == $key ? json_encode( $value ) : $value;
                    $value = str_replace( array( '{', '}' ), '', $value );
                    $get_query .= " AND `$key` $operator '$value' ";
                }
            }
        }

        else {

            if( empty( $this->id ) ) {
                return array(
                    'status'    => 404, 
                    'message'    => esc_html__( 'Id Not Found', 'wishlist-for-woo' ), 
                );
            }

            // Get all current users wishlists.
            $get_query = "SELECT * FROM `$this->table_name` WHERE `id` = '$this->id'"; 
        }

        if( ! empty( $get_query ) ) {
            $response = $wpdb->get_results( $get_query, ARRAY_A );

            if( ! empty( $wpdb->last_error ) || empty( $response ) ) {
                $result = array(
                    'status'    => 400, 
                    'message'    => ! empty( $wpdb->last_error ) ? $wpdb->last_error : esc_html__( 'Row Not Found', 'wishlist-for-woo' ), 
                );
            }
    
            else {
                $result = array(
                    'status'    => 200, 
                    'message'    => $response, 
                );
            }

            return $result;
        }

        return false;
    }

    /**
	 * Parse data in required format.
	 *
     * @param $args array 
	 * @since 1.0.0
	 * @return array $result the parsed data form for query.
	 */
    private function parse_query_args( $args=array() ) {

        if ( ! empty( $args ) && is_array( $args ) ) {
            
            $result = array();
            foreach ( $args as $key => $arg ) {
                $result[ $key ] = ! empty( $arg ) && is_array( $arg ) ? json_encode( array_unique( $arg ) ) : $arg;
            }

            return $result;
        }

        return false;
    }

    /**
	 * Get Selected data from Sql Query Obj.
	 *
     * @param $args     array SQL result
     * @param $fetch    string  The key to fetch.
	 * @since 1.0.0
	 * @return array $result the parsed data form for query.
	 */
    public function get_prop( $fetch = '' ) {

        // Get Wishlist object first.
        $query_result = $this->retrieve();
        if( 200 !== $query_result[ 'status' ] ) {
            return $query_result;
        }
        else {
            $obj = ! empty( $query_result[ 'message' ] ) ? $query_result[ 'message' ] : array();
        }

        if ( ! empty( $obj ) && is_array( $obj ) ) {
            
            foreach ( $obj as $key => $wishlist ) {

                if( empty( $fetch ) ) {
                    return $wishlist;
                }
                else {

                    $value = $wishlist[ $fetch ] ? $wishlist[ $fetch ] : false;
                    $result = array();
                    if( ! empty( $value ) ) {
                        $result = in_array( $fetch, $this->array_entries ) ? json_decode( $value ) : $value;
                    }
                    return $result;
                }
            }
        }
        return false;
    }

    /**
	 * Get all the wishlist for user.
	 *
	 * @since 1.0.0
	 * @return array $result the parsed data form for query.
	 */
    public function get_all() {

        if( ! is_admin() ) {
            return false;
        }

        // Get all current users wishlists.
        global $wpdb;
        $get_query = "SELECT * FROM `$this->table_name`"; 
        $response = $wpdb->get_results( $get_query, ARRAY_A );

        if( ! empty( $wpdb->last_error ) ) {

            $result = array(
                'status'    => 400, 
                'message'    => $wpdb->last_error, 
            );
        }

        else {

            $result = array(
                'status'    => 200, 
                'response'    => apply_filters( 'mwb_wfw_all_wishlists', $response ), 
            ); 
        }

        return $result;
    }

// End of Class.
}