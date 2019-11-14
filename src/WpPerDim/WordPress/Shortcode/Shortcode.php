<?php
namespace WpPerDim\WordPress\Shortcode;

use WpPerDim\Interfaces\HooksInterface;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Indicator;
use WpPerDim\Models\App\Result;
use WpPerDim\Models\App\Period;
use WpPerDim\Models\App\Unit;
use WpPerDim\Models\App\Tracker;

/**
 * Shortcode
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Shortcode implements HooksInterface{

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_shortcode( "wppd_dashboard", array($this, 'dashboard') );
        add_shortcode( "wppd_graph", array($this, 'graph') );

    }
    
    public function dashboard($atts){
        $default = array(
			'limit'    => '12',
			'orderby'  => 'rand',
			'order'    => 'DESC',
			'type'     => 'cf', // cf|km
        );
        
        $attributes = shortcode_atts($default, (array) $atts);
        
        global $wpdb;
        
        if($attributes['type'] == 'cf'){
            $t1 = $wpdb->prefix.Indicator::getTable();
            $t2 = $wpdb->prefix.Period::getTable();
            $t3 = $wpdb->prefix.Result::getTable();
            $t4 = $wpdb->prefix.Report::getTable();
            $sql = "SELECT DISTINCT(t1.`id`) as id, t1.`title`, t3.`value` FROM $t1 AS t1 " .
                                  " LEFT JOIN $t2 AS t2 ON t1.`id` = t2.`indicator_id` " .
                                  " LEFT JOIN $t3 AS t3 ON t2.`id` = t3.`period_id` " .
                                  " LEFT JOIN $t4 AS t4 ON t4.`id` = t3.`report_id` " .
                                  " WHERE t4.`type` = 'cf' " .
                                  " ORDER BY t2.`order` DESC;";
            $datas = $wpdb->get_results($sql);

            ob_start();
            include( WPPD_DIR . '/template/shortcode-cf.php');
            return ob_get_clean();
        }
        
        $t1 = $wpdb->prefix.Indicator::getTable();
        $t2 = $wpdb->prefix.Period::getTable();
        $t3 = $wpdb->prefix.Result::getTable();
        $t4 = $wpdb->prefix.Report::getTable();
        $sql = "SELECT t1.`id`, t1.`title`, t3.`value`, t3.`id` as value2 FROM $t1 AS t1 " .
                              " LEFT JOIN $t2 AS t2 ON t1.`id` = t2.`indicator_id` " .
                              " LEFT JOIN $t3 AS t3 ON t2.`id` = t3.`period_id` " .
                              " LEFT JOIN $t4 AS t4 ON t4.`id` = t3.`report_id` " .
                              " WHERE t4.`type` = 'km' " .
                              " ORDER BY t1.`title` ASC;";
        $datas = $wpdb->get_results($sql);

        ob_start();
        include( WPPD_DIR . '/template/shortcode-km.php');
        return ob_get_clean();
    }
    
    public function graph($atts){
        $default = array(
			'limit'    => '12',
			'orderby'  => 'rand',
			'order'    => 'DESC',
			'type'     => 'cf', // cf|km
        );
        
        $attributes = shortcode_atts($default, (array) $atts);
        
        /**
        $datas = [];
        $trackers = Tracker::getAll();
        foreach($trackers as $item){
            $tracker = Tracker::fromWp($item);
            $value = 0;
            foreach($tracker->getResults() as $result){
                $value += $result->value;
            }
            $datas[] = [
                'tracker' => $tracker->title,
                'value'   => $value,
            ];
        }
        */
        
        $indicators = [];
        $items = Indicator::getAll();
        foreach($items as $item){
            $indicator = Indicator::fromWp($item);
            
            $periods = [];
            foreach($indicator->getPeriods() as $period){
                $results = [];
                foreach($period->getResults() as $result){
                    $tracker = $result->getTracker();
                    if( $tracker ) {
                        if( ! isset( $results[ $tracker->getPkValue() ] ) ){
                            $results[ $tracker->getPkValue() ] = [
                                'tracker' => $tracker->title,
                                'value'   => $result->value,
                            ];
                        }else{
                            $value = $results[ $tracker->getPkValue() ]['value'];
                            $results[ $tracker->getPkValue() ] = [
                                'tracker' => $tracker->title,
                                'value'   => $value + $result->value,
                            ];
                        }
                    }
                }
                
                $results_datas = [];
                foreach($results as $result){
                    $results_datas[] = $result;
                }
                
                $periods[] = [
                    'id'    => $period->getPkValue(),
                    'title' => $period->title,
                    'datas' => $results_datas,
                ];
            }
            
            $indicators[$indicator->getPkValue()] = [
                'id'      => $indicator->getPkValue(),
                'title'   => $indicator->title,
                'type'    => $indicator->type,
                'periods' => $periods,
            ];
        }
        
        ob_start();
        include( WPPD_DIR . '/template/shortcode-graph.php');
        return ob_get_clean();
    }

}