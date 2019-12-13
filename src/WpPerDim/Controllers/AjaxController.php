<?php
namespace WpPerDim\Controllers;

use WpPerDim\Systems\BaseController;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Organism;
use WpPerDim\Models\App\Result;
use WpPerDim\Models\App\Period;

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
    
    public function selectOrganism(){
        if ( isset( $_POST['organism_id'] ) ){
            $organism_id = \wp_unslash( $_POST['organism_id'] );
            
            $organism = new Organism();
            if( $organism_id ){
                $organism = Organism::find($organism_id);
            }
            
            $indicators = $organism->getIndicators();
            $periods = Period::getAll(0, 'order', 'ASC');
            ?>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                    <tr>
                        <td><?php echo __( 'Indicateurs', 'wppd' ); ?></td>
                        <?php foreach($periods as $period) : ?>
                            <td><?php echo $period->title; ?></td>
                        <?php endforeach; ?>
                        <td><?php echo __( 'Unité de mesure', 'wppd' ); ?></td>
                        <td><?php echo __( 'Type de l\'indicateur', 'wppd' ); ?></td>
                    </tr>
                </thead>
                <?php // Result => Period/Report => Indicator ?>
                <?php foreach($indicators as $key => $indicator) : ?>
                    <tr>
                        <input type="hidden" name="reports[<?php echo $key; ?>][indicator]" value="<?php echo $indicator->id; ?>">

                        <?php $report = Report::getFirstBy('indicator_id', $indicator->id);; ?>
                        <?php if($report) : ?>
                            <input type="hidden" name="reports[<?php echo $key; ?>][id]" value="<?php echo $report->id; ?>">
                        <?php else: ?>
                            <input type="hidden" name="reports[<?php echo $key; ?>][id]" value="0">
                        <?php endif; ?>
                        
                        <td><?php echo $indicator->title; ?></td>
                        <?php foreach($periods as $key2 => $period) : ?>
                            <?php if($report) { $result = Result::findOneByReportAndPeriod($report, $period); } else { $result = false; } ?>
                            <td>
                                <input type="hidden" name="reports[<?php echo $key; ?>][results][<?php echo $key2; ?>][period]" value="<?php echo $period->id; ?>">
                                
                                <?php if($result) : ?>
                                    <input type="hidden" name="reports[<?php echo $key; ?>][results][<?php echo $key2; ?>][id]" value="<?php echo $result->id; ?>">
                                <?php else: ?>
                                    <input type="hidden" name="reports[<?php echo $key; ?>][results][<?php echo $key2; ?>][id]" value="0">
                                <?php endif; ?>
                                
                                <input type="number" name="reports[<?php echo $key; ?>][results][<?php echo $key2; ?>][value]" placeholder="<?php echo sprintf(__( 'Valeur en %s', 'wppd' ), $period->title); ?>" value="<?php echo $result ? $result->value : 0; ?>">
                            </td>
                        <?php endforeach; ?>
                        <td><?php $unit = $indicator->getUnit(); echo $unit ? $unit->title : __('Non renseigné', 'wppd') ?></td>
                        <td><?php echo $indicator->type; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php
        }
        wp_die();
    }
}