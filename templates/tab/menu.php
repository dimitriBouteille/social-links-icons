<div class="sn-tab-menu">
    <div class="sn-tab-menu-scroll">
        <?php foreach ($networks as $network): ?>
            <button data-href="<?= sli_adminUrlNetwork($network); ?>" class="sn-tab-menu-btn<?= sli_isNetwork($defaultNetwork, $network) ? ' is-active': null; ?><?= $network->hasUrl() ? ' has-link' : null; ?>" id="sn-tab-<?= $network->slug; ?>" data-js-network="sn-section-<?= $network->slug; ?>">
                <?= $network->name; ?>
                <span class="sn-tab-menu-url">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 21.035l-9-8.638 2.791-2.87 6.156 5.874 12.21-12.436 2.843 2.817z"/></svg>
                </span>
             </button>
        <?php endforeach; ?>
    </div>
</div>