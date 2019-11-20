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
        
        if($attributes['type'] != 'cf'){
            $attributes['type'] = 'km';
        }

        $indicators = Indicator::getAll();

        $datas = [];
        foreach($indicators as $indicator){
            $indicator = Indicator::fromWp($indicator);

            $oldValue = -1;
            $newValue = -1;
            $type = 'default';
            foreach($indicator->getPeriods() as $period){
                $value = 0;
                foreach($period->getResults() as $result){
                    $report = $result->getReport();
                    if($report && ( $report->type == $attributes['type'] ) ){
                        $report = $result->getReport();
                        $value += $result->value;
                        if($result->value > 1){
                            $type = 'graph';
                        }
                    }
                }

                if($oldValue<0){
                    $oldValue = $value;
                }else if($newValue<0){
                    $newValue = $value;
                }else{
                    $oldValue = $newValue;
                    $newValue = $value;
                }
            }
                
            if($value==0){
                continue;
            }
            
            $src = WPPD_URL.'assets/images/';
            if( $type == 'graph' ) {
                if( ( $oldValue >= 0 ) && ( $newValue >= 0 ) ) {
                    if( $oldValue < $newValue ){
                        // up
                    } else if ( $oldValue > $newValue ) {
                        // down
                    } else {
                        // same
                    }
                }else{
                    // error
                }
            }else{
                if( $newValue == 1 ){
                    
                } else {
                    
                }
            }
            $image = '<img src="%s" class="graph" alt="statistic">';
            $image = sprintf($image, $src);
            
            $datas[$indicator->getPkValue()] = [
                'id'     => $indicator->getPkValue(),
                'title'  => $indicator->title,
                'value'  => $newValue,
                'image'  => $type,
            ];
        }
        ob_start();
        include( WPPD_DIR . '/template/shortcode-' . $attributes['type'] . '.php');
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
        
        $indicators = [];
        $items = Indicator::getAll();
        foreach($items as $item){
            $indicator = Indicator::fromWp($item);
            
            $periods = [];
            foreach($indicator->getPeriods() as $period){
                $value = 0;
                foreach($period->getResults() as $result){
                    $value += $result->value;
                }
                
                $periods[] = [
                    'id'    => $period->getPkValue(),
                    'title' => $period->title,
                    'period' => $period->title,
                    'value' => $value,
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