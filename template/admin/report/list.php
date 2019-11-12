<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap nexway-wrap">
    <h1 class="wp-heading-inline"><?php echo __( 'Liste des données', 'wppd' ); ?></h1>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-datas&action=create' ) ); ?>" class="page-title-action">Ajouter</a>
    <hr class="wp-header-end">
    <div class="about-text"></div>
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <div class="tablenav top" style="display:none;">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">Sélectionnez l’action groupée</label><select name="action" id="bulk-action-selector-top">
                    <option value="-1">Actions groupées</option>
                        <option value="delete">Supprimer</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Appliquer">
                </div>
                <div class="tablenav-pages one-page"><span class="displaying-num">1 élément</span>
                <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Page actuelle</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> sur <span class="total-pages">1</span></span></span>
                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span></span>
                </div>
                <br class="clear">
            </div>
            <div class="tablenav top">
            </div>
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href=""><span>Titre</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="description" class="manage-column column-description sortable desc"><a href=""><span>Description</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="unit" class="manage-column column-unit sortable desc"><a href=""><span>Unité</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="graph" class="manage-column column-graph sortable desc"><a href=""><span>Graphe</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="posts" class="manage-column column-posts num sortable desc"><a href=""><span>Total</span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:tag">
                    <?php foreach($models as $item): ?>
                        <?php $model = \WpPerDim\Models\App\Indicator::fromWp($item); ?>
                        <tr id="tag-<?php echo $model->getPkValue(); ?>" class="level-0">
                            <th scope="row" class="check-column">&nbsp;</th>
                            <td class="name column-name has-row-actions column-primary" data-colname="Titre"><strong>
                                <a class="row-title" href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="Modifier «&nbsp;<?php echo $model->title; ?>&nbsp;»"><?php echo $model->title; ?></a></strong><br>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=edit&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="Modifier «&nbsp;<?php echo $model->title; ?>&nbsp;»">Modifier</a> | </span>
                                    <span class="view"><a href="<?php echo esc_url( admin_url( 'admin.php?page=wppd-indicators&action=show&id=' . esc_attr( $model->getPkValue() ) ) ); ?>" aria-label="Voir «&nbsp;<?php echo $model->title; ?>&nbsp;»">Afficher</a></span>
                                </div>
                            </td>
                            <td class="description column-description" data-colname="Description"><?php echo $model->description; ?></td>
                            <td class="unit column-unit" data-colname="Unité"><?php echo $model->description; ?></td>
                            <td class="graph column-graph" data-colname="Graphe"><?php echo $model->graph; ?></td>
                            <td class="posts column-posts" data-colname="Total"><a href="">1</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Tout sélectionner</label><input id="cb-select-all-2" type="checkbox"></td>
                        <th scope="col" class="manage-column column-name column-primary sortable desc"><a href=""><span>Titre</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-description sortable desc"><a href=""><span>Description</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-unit sortable desc"><a href=""><span>Unité</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-graph sortable desc"><a href=""><span>Graphe</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" class="manage-column column-posts num sortable desc"><a href=""><span>Total</span><span class="sorting-indicator"></span></a></th>
                    </tr>
                </tfoot>
            </table>
            <div class="tablenav bottom" style="display:none;">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-bottom" class="screen-reader-text">Sélectionnez l’action groupée</label><select name="action2" id="bulk-action-selector-bottom">
                    <option value="-1">Actions groupées</option>
                        <option value="delete">Supprimer</option>
                    </select>
                    <input type="submit" id="doaction2" class="button action" value="Appliquer">
                </div>
                <div class="tablenav-pages one-page"><span class="displaying-num">1 élément</span>
                    <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                    <span class="screen-reader-text">Page actuelle</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 sur <span class="total-pages">1</span></span></span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span></span>
                </div>
                <br class="clear">
            </div>
        </form>
    </div>
</div>