<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">
            <table class="table table-sm table-bordered table-hover wppd-table table-dashboard-cf">
                <thead>
                    <tr>
                        <th colspan="3" scope="col"><h5 class="m-0"><?php _e('CF Dashboard', 'wppd'); ?></h5></th>
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