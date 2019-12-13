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
			'organism' => '0',
			'type'     => 'cf', // cf|km
        );
        
        $attributes = shortcode_atts($default, (array) $atts);
        
        global $wpdb;
        
        if($attributes['type'] != 'cf'){
            $attributes['type'] = 'km';
        }

        $organism = (int) $attributes['organism'];
        if($organism){
            $indicators = Indicator::getAllBy('organism_id', $organism, 0, 'title', 'ASC');
        }else{
            $indicators = Indicator::getAll(0, 'title', 'ASC');
        }

        $datas = [];
        if(is_array($indicators)){
            foreach($indicators as $indicator){
                $indicator = Indicator::fromWp($indicator);
                $oldValue = -1;
                $newValue = -1;
                $type = 'default';
                $value = 0;
                
                if($indicator->type == $attributes['type']){
                    $results = [];
                    foreach($indicator->getReports() as $report){
                        $results = $report->getLastResults();
                    }

                    if(isset($results[0])){ $newValue = $results[0]->value; }
                    
                    if(isset($results[1])){ $oldValue = $results[1]->value; }
                    
                    $type = 'graph';
                    if( ( $newValue <= 1 ) && ( $oldValue <= 1 ) ){
                        $type = 'default';
                    }
                    
                    $image = $this->getImage($oldValue, $newValue, $type);
                    
                    $datas[$indicator->getPkValue()] = [
                        'id'     => $indicator->getPkValue(),
                        'title'  => $indicator->title,
                        'value'  => $newValue,
                        'image'  => $image,
                    ];
                }
            }
        }
        
        ob_start();
        include( WPPD_DIR . '/template/shortcode-' . $attributes['type'] . '.php');
        return ob_get_clean();
    }
    
    public function getImage($oldValue, $newValue, $type = 'graph'){
        $src = WPPD_URL.'assets/images/';
        if( $type == 'graph' ) {
            if( ( $oldValue >= 0 ) && ( $newValue >= 0 ) ) {
                if( $oldValue < $newValue ){
                    // up
                    $src .= 'up.png';
                } else if ( $oldValue > $newValue ) {
                    // down
                    $src .= 'down.png';
                } else {
                    // same
                    $src .= 'same.png';
                }
            }else{
                // only one period
                $src .= 'same.png';
            }
        }else{
            if( $newValue == 1 ){
                $src .= 'ok.png';
            } else {
                $src .= 'nok.png';
            }
        }
        
        $image = '<img src="%s" class="graph" alt="statistic">';
        
        return sprintf($image, $src);
    }
    
    public function graph($atts){
        $default = array(
			'limit'    => '12',
			'orderby'  => 'rand',
			'order'    => 'DESC',
			'organism' => '0',
        );
        
        $attributes = shortcode_atts($default, (array) $atts);
        
        $organism = (int) $attributes['organism'];
        if($organism){
            $items = Indicator::getAllBy('organism_id', $organism, 0, 'title', 'ASC');
        }else{
            $items = Indicator::getAll(0, 'title', 'ASC');
        }
        
        $indicators = [];
        if( is_array( $items ) ){
            foreach($items as $item){
                $indicator = Indicator::fromWp($item);
                
                $periods = [];
                foreach($indicator->getReports() as $report){
                    foreach($report->getResults() as $result){
                        $period = $result->getPeriod();

                        $periods[] = [
                            'id'     => $period->getPkValue(),
                            'title'  => $period->title,
                            'period' => $period->title,
                            'value'  => $result->value,
                        ];
                    }
                }

                $indicators[$indicator->getPkValue()] = [
                    'id'      => $indicator->getPkValue(),
                    'title'   => $indicator->title,
                    'graph'   => $indicator->graph,
                    'periods' => $periods,
                ];
            }
        }
        
        ob_start();
        include( WPPD_DIR . '/template/shortcode-graph.php');
        return ob_get_clean();
    }

}