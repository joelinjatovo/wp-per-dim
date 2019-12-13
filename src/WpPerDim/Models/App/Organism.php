<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Organism
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Organism extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_organisms';
    
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
        foreach($this->getUnits() as $unit){
            $unit->delete(); 
        }
        
        foreach($this->getIndicators() as $indicator){
            $indicator->delete(); 
        }
        parent::delete();
    }
    
    public function getUnits(){
        global $wpdb;
        $table_name = $wpdb->prefix.Unit::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `organism_id` = %d;", [$this->getPkValue()]);
        $results = $wpdb->get_results($sql);
        if(is_array($results)){
            $output = [];
            foreach($results as $result){
                $output[] = Unit::fromWp($result);
            }
            return $output;
        }else{
            return [];
        }
    }
    
    public function getIndicators(){
        global $wpdb;
        $table_name = $wpdb->prefix.Indicator::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `organism_id` = %d;", [$this->getPkValue()]);
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