<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Period
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Period extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_periods';
    
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
        'order',
        'group',
    ];
    
    /**
    * delete item
    */
    public function delete(){
        foreach($this->getResults() as $result){
            $result->delete(); 
        }
        parent::delete();
    }
    
    public function getResults(){
        global $wpdb;
        $table_name = $wpdb->prefix.Result::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `period_id` = %d;", [$this->getPkValue()]);
        $results = $wpdb->get_results($sql);
        if(is_array($results)){
            $output = [];
            foreach($results as $result){
                $output[] = Result::fromWp($result);
            }
            return $output;
        }else{
            return [];
        }
    }
    
    public function getValue(){
        $value = 0;
        foreach($this->getResults() as $result){
            $value += $result->value;
        }
        return $value;
    }
    
}