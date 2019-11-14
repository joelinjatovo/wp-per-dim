<?php
namespace WpPerDim\Controllers;

use WpPerDim\Systems\BaseController;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Indicator;
use WpPerDim\Models\App\Result;
use WpPerDim\Models\App\Period;
use WpPerDim\Models\App\Tracker;

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
            
            $tackers = Tracker::getAll();
            
            if( $report && ( $report->indicator_id == $indicator_id ) ) {
                $key = 0;
                foreach($report->getResultsPerPeriod() as $period_id => $results){
                    $period = Period::find($period_id);
                    ?>
                    <tr class="row">
                        <td width="10%"><span class="period"><?php echo $period ? $period->title : __('Non renseigné', 'wppd'); ?></span></td>
                        <td width="80%">
                            <?php foreach($results as $index => $result): ?>
                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][id]" value="<?php echo $result->getPkValue(); ?>" />
                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][period]" value="<?php echo $result->period_id; ?>" />
                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][tracker]" value="<?php echo $result->tracker_id; ?>" />
                                <input type="text" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][value]" value="<?php echo $result->value; ?>" />
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <?php
                    $key++;
                }
            }elseif( $indicator ) {
                foreach($indicator->getPeriods() as $key => $period){
                    ?>
                    <tr class="row" border="1">
                        <td width="10%"><span class="period"><?php echo $period->title; ?></span></td>
                        <td width="80%">
                            <table>
                                <tbody>
                                    <?php foreach($tackers as $index => $tacker): ?>
                                        <?php $tacker = Tracker::fromWp($tacker); ?>
                                        <tr>
                                            <td><?php echo $tacker->title; ?></td>
                                            <td>
                                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][id]" value="" />
                                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][period]" value="<?php echo $period->getPkValue(); ?>" />
                                                <input type="hidden" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][tracker]" value="<?php echo $tacker->getPkValue(); ?>" />
                                                <input type="number" name="report-results[<?php echo $key; ?>][<?php echo $index; ?>][value]" value="" />
                                            </td>
                                        </tr>
                                    
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        wp_die();
    }
}