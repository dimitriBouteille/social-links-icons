<?php

$sites = [];

foreach ($sitesSvg as $siteUrl) {
    $sites[] = sprintf('<a href="%s" target="_blank">%s</a>', $siteUrl, $siteUrl);
}

$sites = implode($sites, ', ');

?>

<article class="article">
    <h2><?= __('Trouver des icones', SLI_DOMAIN); ?></h2>

    <p><?= sprintf(__('Vous pouvez trouver des icones sur l\'un des sites suivants : %s.', SLI_DOMAIN), trim($sites)); ?><br/>
        <?= __('Si vous utilisez des icones qui ne vous appartiennet pas, n\'oubliez pas citer les auteurs dans les mentions légales.', SLI_DOMAIN); ?></p>
</article>