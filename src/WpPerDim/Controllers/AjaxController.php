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
        if ( isset( $_POST['report_id'] ) ){
            $report_id   = \wp_unslash( $_POST['report_id'] );
            $organism_id = \wp_unslash( $_POST['organism_id'] );
            
            $report = false;
            if( $report_id ){
                $report = Report::find($report_id);
            }
            
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
                <?php foreach($indicators as $indicator) : ?>
                    <tr>
                        <td><?php echo $indicator->title; ?></td>
                        <?php foreach($periods as $period) : ?>
                            <td>
                                <input type="number" name="results[][value]" placeholder="<?php echo sprintf(__( 'Valeur en %s', 'wppd' ), $period->title); ?>">
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