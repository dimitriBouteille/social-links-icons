<div class="sn-tabs-body">
    <?php foreach ($networks as $id => $network): ?>
        <div class="sn-tabs-body-network<?= sli_isNetwork($defaultNetwork, $network) ? ' is-visible': null; ?>" id="sn-section-<?= $network->slug; ?>">

            <?php sli_load_form($network); ?>

        </div>
    <?php endforeach; ?>
</div>