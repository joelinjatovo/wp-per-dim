<?php
namespace WpPerDim\Models;

use WpPerDim\Systems\Request;

/**
 * Product
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
class BaseModel {
    
    use \WpPerDim\Traits\NxwQuery;
    
    /**
    * @var $_table String
    */
    protected static $_table;
    
    /**
    * @var $_primaryKey String
    */
    protected static $_primaryKey = 'id';
    /**
    * Array of authorized database key name
    * @var $_fields Array
    */
    protected static $_fields = [];
    /**
    * @var $_datas Array
    */
    protected $_datas;
    
    /**
    * @param String $key
    * @param mixed $value
    */
    public function __set($key, $value){
        if(!isset($this->_datas) || !is_array($this->_datas)){
            $this->_datas = [];
        }
        $this->_datas[$key] = $value;
    }
    
    /**
    * @param String $key
    * @return mixed
    */
    public function __get($key){
        if(!isset($this->_datas[$key])){
            return '';
        }
        return $this->_datas[$key];
    }
    
    /**
    * @param String $key
    * @return mixed
    */
    public function __isset($key){
        return isset($this->_datas[$key]);
    }
    
    /**
    * Save or Update item
    */
    public function save(){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        
        $data = [];
        $pk = $this->getPk();
        foreach($this->_datas as $key => $value){
            if($key!=$pk && in_array($key, static::$_fields)){
                $data[$key] = $value.'';
            }
        }
        
        if( isset( $this->$pk ) ){
            // Update row
            $wpdb->update(
                $table_name,
                $data,
                [$pk=>$this->$pk]
            );
        }else{
            // Insert row
            $wpdb->insert(
                $table_name,
                $data
            );
            $this->$pk = $wpdb->insert_id;
        }
        
        return $this;
    }
    
    /**
    * Save or Update item
    */
    public function delete(){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        return $wpdb->delete($table_name,[$this->getPk()=>$this->getPkValue()]);
    }
    
    /**
    * return sql query string
    *
    * @return string
    */
    public function toSql(){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        
        $data = [];
        $pk = $this->getPk();
        foreach($this->_datas as $key => $value){
            if($key!=$pk && in_array($key, static::$_fields)){
                $data[$key] = $value.'';
            }
        }

        $data = $this->process_fields($table_name, $data, null );
        if (false === $data) {
            return false;
        }
        
        if( isset( $this->$pk ) ){
            $where = [$pk=>$this->$pk];
            $where = $this->process_fields($table_name, $where, null);
            if ( false === $where ) {
                return false;
            }
            
            $fields = $conditions = $values = array();
            foreach ( $data as $field => $value ) {
                if ( is_null( $value['value'] ) ) {
                    $fields[] = "`$field` = NULL";
                    continue;
                }

                $fields[] = "`$field` = " . $value['format'];
                $values[] = $value['value'];
            }
            
            foreach ( $where as $field => $value ) {
                if ( is_null( $value['value'] ) ) {
                    $conditions[] = "`$field` IS NULL";
                    continue;
                }

                $conditions[] = "`$field` = " . $value['format'];
                $values[]     = $value['value'];
            }

            $fields     = implode( ', ', $fields );
            $conditions = implode( ' AND ', $conditions );
            
            $sql = "UPDATE `$table_name` SET $fields WHERE $conditions;";
            return $wpdb->prepare($sql, $values);
        }else{
            $formats = $values = array();
            foreach ( $data as $value ) {
                if (is_null($value['value'])) {
                    $formats[] = 'NULL';
                    continue;
                }

                $formats[] = $value['format'];
                $values[]  = $value['value'];
            }

            $fields  = '`'.implode( '`, `', array_keys($data)).'`';
            $formats = implode( ', ', $formats);

            $sql = "INSERT INTO `$table_name` ($fields) VALUES ($formats);";
            return $wpdb->prepare($sql, $values);
        }
        
        return false;
    }
    
    /**
    * return sql query string
    *
    * @return string
    */
    public function getSql(){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        
        $data = [];
        $pk = $this->getPk();
        foreach($this->_datas as $key => $value){
            if(in_array($key, static::$_fields)){
                $data[$key] = (string) $value;
            }
        }

        $data = $this->process_fields($table_name, $data, null );
        if (false === $data) {
            return false;
        }
            
        $fields1 = $fields2 = $values = array();
        foreach ( $data as $field => $value ) {
            
            if( $field == $pk ) {
                $duplicates[] = "`$field` = LAST_INSERT_ID(`$field`)";
            }
            
            if ( empty( $value['value'] ) ) {
                if( $field != $pk ) {
                    $values[]     = "null";
                    $duplicates[] = "`$field` = null";
                } else {
                    $values[] = "null";
                }
                continue;
            }

            $values[]     = $wpdb->prepare($value['format'], $value['value']);
            $duplicates[] = "`$field` = VALUES(`$field`)";
        }

        $fields     = '`'.implode( '`, `', array_keys($data)).'`';
        $values     = implode( ',' , $values);
        $duplicates = implode( ', ', $duplicates );

        $sql = "INSERT INTO `$table_name` ( $fields ) VALUES ( $values ) ON DUPLICATE KEY UPDATE $duplicates;";
        
        return $sql;
    }
        
    public function insert($row_arrays = array(), $on_duplicate = false) {
        global $wpdb;
        
        $wp_table_name = $wpdb->prefix.static::$_table;
        
        return nxw_wpdb_insert_rows($wp_table_name, $row_arrays, $on_duplicate);
    }
    
    /**
    * Fill arg from xml
    */
    public function fillFromXml($arg){
        if(is_array($arg)){
            $arg = (Object) $arg;
        }
        
        foreach(static::$_fields as $field){
            if(isset($arg->$field)){
                $value = $arg->$field;
                $this->$field = $value;
            }
        }
        return $this;
    }
    
    /**
    * @return array
    */
    public function toArray(){
        $output = [];
        foreach(static::$_fields as $field){
            $output[$field] = $this->$field;
        }
        return $output;
    }
    
    /**
    * Get table
    * @return String
    */
    public static function getTable(){
        return static::$_table;
    }
    
    /**
    * Get primary key field
    * @return String
    */
    public static function getPk(){
        return static::$_primaryKey;
    }
    
    /**
    * Get primary key value
    * @return Integer
    */
    public function getPkValue(){
        $pk = static::getPk();
        return (int) $this->$pk;
    }
    
    /**
    *
    */
    public static function newInstance(){
        $class = get_called_class();
        $model = new $class();
        return $model;
    }
    
    /**
    *
    */
    public static function fromWp($arg){
        $class = get_called_class();
        $model = new $class();
        foreach(static::$_fields as $field){
            if(isset($arg->$field)){
                $model->$field = $arg->$field;
            }
        }
        return $model;
    }
    
    /**
    * Find item by key
    */
    public static function exists($key, $value){
        if(empty($key) || empty($value)){
            return false;
        }
        
        global $wpdb;
        
        $pk = static::getPk();
        $table_name = $wpdb->prefix.static::$_table;
        $sql = $wpdb->prepare('SELECT '.$pk.' FROM '.$table_name.' WHERE '.$key.' = %s LIMIT 1;', $value);
        $results = $wpdb->get_results($sql);
        if(is_array($results) && isset($results[0])){
            return $results[0]->$pk;
        }
        return false;
    }
    
    /**
    * Find item by his primary key
    *
    * @return related Model
    */
    public static function find($id){
        global $wpdb;
        
        $pk = static::getPk();
        $table_name = $wpdb->prefix.static::$_table;
        $sql = $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE '.$pk.' =%d LIMIT 1;', $id);
        $results = $wpdb->get_results($sql);
        if(is_array($results) && isset($results[0])){
            return static::fromWp($results[0]);
        }
        
        return false;
    }
    
    /**
    * Find item by his primary key or 404 Error
    *
    * @return related Model
    */
    public static function findOrFail($id){
        $item = static::find($id);
        if($item===false){
            Request::notFound();
        }else{
            return $item;
        }
    }
    
    /**
    * Find item by
    * @param $key database field
    * @param $value field value
    *
    * @return related Model
    */
    public static function getFirstBy($key, $value){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        $sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE '.$key.' = %s LIMIT 1;', $value);
        $results = $wpdb->get_results($sql);
        if(is_array($results) && isset($results[0])){
            return static::fromWp($results[0]);
        }
        
        return false;
    }
    
    /**
    * get all item
    *
    * @return Array
    */
    public static function getAll($limit = 0, $order_by = null, $order = null){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        $sql = 'SELECT * FROM '.$table_name;
        if($order_by & $order){
            $sql .= ' ORDER BY '.$order_by.' '.$order;
        }
        if($limit>0){
            $sql .= ' LIMIT '.$limit;
        }
        $results = $wpdb->get_results($sql);
        if(is_array($results) && isset($results[0])){
            return $results;
        }
        return [];
    }
    
    /**
    * Find items by
    * @param $key database field
    * @param $value field value
    *
    * @return Array
    */
    public static function getAllBy($key, $value, $limit = 0, $order_by = null, $order = null){
        global $wpdb;
        $table_name = $wpdb->prefix.static::$_table;
        if( is_null($value) ){
            $sql = 'SELECT * FROM ' . $table_name . ' WHERE '.$key.' IS NULL '. ($order_by & $order ? ' ORDER BY '.$order_by.' '.$order : '') . ( $limit>0? ' LIMIT '.$limit:'' ).';';
        }else{
            $sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE '.$key.' = %s '. ($order_by & $order ? ' ORDER BY '.$order_by.' '.$order : ''). ( $limit>0? ' LIMIT '.$limit:'' ).';', $value);
        }
        
        $results = $wpdb->get_results($sql);
        if(is_array($results) && isset($results[0])){
            return $results;
        }
        
        return false;
    }
    
}