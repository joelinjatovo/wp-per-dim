<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Unit
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Unit extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_units';
    
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
        'label',
    ];
    
    /**
    * delete item
    */
    public function delete(){
        foreach($this->getIndicators() as $indicator){
            $indicator->delete(); 
        }
        parent::delete();
    }
    
    public function getIndicators(){
        global $wpdb;
        $table_name = $wpdb->prefix.Indicator::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `unit_id` = %d;", [$this->getPkValue()]);
        $results = $wpdb->get_results($sql);
        if(is_array($results)){
            $output = [];
            foreach($results as $result){
                $output[] = Indicator::fromWp($result);
            }
            return $output;
        }else{
            return [];
        }
    }
    
}