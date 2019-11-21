<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table wppd-table table-dashboard-cf">
                <thead>
                    <tr>
                        <th colspan="3"><h4><?php _e('CF Dashboard', 'wppd'); ?></h4></th>
                    </tr>
                </thead>
                <tbody class="items">
                    <?php foreach($datas as $data): ?>
                    <tr class="item-row">
                        <td class="item-title"><?php echo $data['title']; ?></td>
                        <td class="item-value"><?php echo $data['value']; ?></td>
                        <td class="item-image"><?php echo $data['image']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>