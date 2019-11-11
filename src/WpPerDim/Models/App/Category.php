<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Category
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Category extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'nxw_categories';
    
    /**
    * @var $_primaryKey String
    */
    protected static $_primaryKey = 'nxw_category_id';
    
    /**
    * Array of authorized database key name
    * @var $_fields Array
    */
    protected static $_fields = [
        'nxw_category_id',
        'nxw_category_parent_id',
        'category_id',
        'parent_id',
        'label',
        ];
        
    /**
    * @Override
    *
    * Save or Update item
    */
    public function fillFromXml($arg){
        $this->label = (string) $arg;
        $attrs = $arg->attributes();
        $t_attr = [];
        foreach($attrs as $key => $val){
            switch($key){
                case 'id':
                     $this->category_id = (string) $val;
                break;
                case 'parent':
                     $this->parent_id = (string) $val;
                break;
            }
        }
        return $this;
    }
    
}