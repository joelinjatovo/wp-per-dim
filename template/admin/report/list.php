<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap wppd-wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Liste des données', 'wppd' ); ?></h1>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=create' ) ); ?>" class="page-title-action"><?php echo __( 'Ajouter', 'wppd' ); ?></a>
    <hr class="wp-header-end">
    <div class="about-text"></div>
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <div class="tablenav top">
            </div>
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Indicateur', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="link" class="manage-column column-slug sortable desc"><a href=""><span><?php echo __( 'Lien connexe', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="type" class="manage-column column-slug sortable desc"><a href=""><span><?php echo __( 'Type', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="data" class="manage-column column-slug sortable desc"><a href=""><span><?php echo __( 'Données', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:tag">
                    <?php foreach($models as $item): ?>
                        <?php $model = \WpPerDim\Models\App\Report::fromWp($item); ?>
                        <tr id="tag-<?php echo $model->getPkValue(); ?>" class="level-0">
                            <td class="name column-name has-row-actions column-primary" data-colname="<?php echo __( 'Indicateur', 'wppd' ); ?>"><strong>
                                <a class="row-title" href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>"><?php echo ( $indicator = $model->getIndicator() ) ? $indicator->title : ''; ?></a></strong><br>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Modifier</a> | </span>
                                    <span class="trash"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=delete&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" class="submitdelete" aria-label="<?php echo sprintf( __( 'Supprimer «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Supprimer</a> | </span>
                                    <span class="view"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=show&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Voir «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Afficher</a></span>
                                </div>
                            </td>
                            <td class="link column-link" data-colname="<?php echo __( 'Lien connexe', 'wppd' ); ?>"><?php echo $model->link; ?></td>
                            <td class="type column-type" data-colname="<?php echo __( 'Type', 'wppd' ); ?>"><?php echo $model->type; ?></td>
                            <td class="data column-data" data-colname="<?php echo __( 'Données', 'wppd' ); ?>">
                                <?php foreach($model->getResults() as $result): ?>
                                <span class="result-item"><span class="result-value"><?php echo $result->value; ?></span><span class="result-period"></span></span>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th scope="col" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Indicateur', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-link sortable desc"><a href=""><span><?php echo __( 'Lien connexe', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-type sortable desc"><a href=""><span><?php echo __( 'Type', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-data sortable desc"><a href=""><span><?php echo __( 'Données', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>