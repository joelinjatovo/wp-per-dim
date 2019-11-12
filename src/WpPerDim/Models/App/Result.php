<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Result
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Result extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_results';
    
    /**
    * @var $_primaryKey String
    */
    protected static $_primaryKey = 'id';
    
    /**
    * Array of authorized database key name
    * @var $_fields Array
    */
    protected static $_fields = [
        'id',
        'title',
        'value',
        'period_id',
    ];
    
    public function getPeriod(){
        global $wpdb;
        $table_name = $wpdb->prefix.Period::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `period_id` = %d;", [$this->period_id]);
        $result = $wpdb->get_row($sql);
        if( $result ) {
            return Period::fromWp($result);
        }
        return null;
    }
    
}