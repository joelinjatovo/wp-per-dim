<?php
namespace WpPerDim\Controllers;

use WpPerDim\Systems\BaseController;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Indicator;
use WpPerDim\Models\App\Result;

/**
 * AjaxController
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
class AjaxController extends BaseController{
    
    function __construct($view){
        parent::__construct($view);
    }
    
    public function selectIndicator(){
        if ( isset( $_POST['indicator_id'] ) ){
            $report_id = \wp_unslash( $_POST['report_id'] );
            $indicator_id = \wp_unslash( $_POST['indicator_id'] );
            
            $report = false;
            if( $report_id ){
                $report = Report::find($report_id);
            }
            
            $indicator = false;
            if( $indicator_id ){
                $indicator = Indicator::find($indicator_id);
            }
            
            if( $report && ( $report->indicator_id == $indicator_id ) ) {
                foreach($report->getResults() as $key => $result){
                    ?>
                    <tr class="row">
                        <td width="10%"><span class="period"><?php echo $period = $result->getPeriod()? $period->title : __('Non renseigné', 'wppd'); ?></span></td>
                        <td width="80%">
                            <input type="hidden" name="report-results[<?php echo $key; ?>][id]" value="<?php echo $result->getPkValue(); ?>" />
                            <input type="hidden" name="report-results[<?php echo $key; ?>][period]" value="<?php echo $result->period_id; ?>" />
                            <input type="text" name="report-results[<?php echo $key; ?>][value]" value="<?php echo $result->value; ?>" />
                        </td>
                    </tr>
                    <?php
                }
            }elseif( $indicator ) {
                foreach($indicator->getPeriods() as $key => $period){
                    ?>
                    <tr class="row">
                        <td width="10%"><span class="period"><?php echo $period->title; ?></span></td>
                        <td width="80%">
                            <input type="hidden" name="report-results[<?php echo $key; ?>][id]" value="" />
                            <input type="hidden" name="report-results[<?php echo $key; ?>][period]" value="<?php echo $period->getPkValue(); ?>" />
                            <input type="text" name="report-results[<?php echo $key; ?>][value]" value="" />
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        wp_die();
    }
}