<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap nexway-wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Liste des indicateurs', 'wppd' ); ?></h1>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
    <hr class="wp-header-end">

    <div class="about-text"></div>
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Titre', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="description" class="manage-column column-description sortable desc"><a href=""><span><?php echo __( 'Description', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="unit" class="manage-column column-unit sortable desc"><a href=""><span><?php echo __( 'Unité', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="organism" class="manage-column column-organism sortable desc"><a href=""><span><?php echo __( 'Organisme', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="Type" class="manage-column column-graph sortable desc"><a href=""><span><?php echo __( 'Type', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="graph" class="manage-column column-graph sortable desc"><a href=""><span><?php echo __( 'Graphe', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>
                <tbody id="the-list" data-wp-lists="list:tag">
                    <?php foreach($models as $item): ?>
                        <?php $model = \WpPerDim\Models\App\Indicator::fromWp($item); ?>
                        <tr id="tag-<?php echo $model->getPkValue(); ?>" class="level-0">
                            <td class="name column-name has-row-actions column-primary" data-colname="<?php echo __( 'Titre', 'wppd' ); ?>"><strong>
                                <a class="row-title" href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>"><?php echo $model->title; ?></a></strong><br>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Modifier «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Modifier</a> | </span>
                                    <span class="view"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=show&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="<?php echo sprintf( __( 'Voir «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Afficher</a> | </span>
                                    <span class="trash"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=delete&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" class="submitdelete" aria-label="<?php echo sprintf( __( 'Supprimer «&nbsp;%s&nbsp;»', 'wppd' ), $model->title); ?>">Supprimer</a></span>
                                </div>
                            </td>
                            <td class="description column-description" data-colname="<?php echo __( 'Description', 'wppd' ); ?>"><?php echo $model->description; ?></td>
                            <td class="unit column-unit" data-colname="<?php echo __( 'Unité', 'wppd' ); ?>"><?php $unit = $model->getUnit(); echo $unit ? $unit->title : __('Non renseigné', 'wppd') ?></td>
                            <td class="unit column-organism" data-colname="<?php echo __( 'Organisme', 'wppd' ); ?>"><?php $organism = $model->getOrganism(); echo $organism ? $organism->title : __('Non renseigné', 'wppd') ?></td>
                            <td class="graph column-type" data-colname="<?php echo __( 'Type', 'wppd' ); ?>"><?php echo $model->type; ?></td>
                            <td class="graph column-graph" data-colname="<?php echo __( 'Graphe', 'wppd' ); ?>"><?php echo $model->graph; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col" class="manage-column column-name column-primary sortable desc"><a href=""><span><?php echo __( 'Titre', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-description sortable desc"><a href=""><span><?php echo __( 'Description', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-unit sortable desc"><a href=""><span><?php echo __( 'Unité', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-organism sortable desc"><a href=""><span><?php echo __( 'Organisme', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-type sortable desc"><a href=""><span><?php echo __( 'Type', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-graph sortable desc"><a href=""><span><?php echo __( 'Graphe', 'wppd' ); ?></span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>