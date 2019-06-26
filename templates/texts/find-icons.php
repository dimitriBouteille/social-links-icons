<?php

$sites = [];

foreach ($sitesSvg as $siteUrl) {
    $sites[] = sprintf('<a href="%s" target="_blank">%s</a>', $siteUrl, $siteUrl);
}

$sites = implode($sites, ', ');

?>

<article class="article">
    <h2><?= __('Find icons', 'social-links-icons'); ?></h2>

    <p><?= sprintf(__('You can find icons on one of the following sites: %s.', 'social-links-icons'), trim($sites)); ?><br/>
        <?= __('If you are using icons that do not belong to you, do not forget to mention the authors in the legal notices.', 'social-links-icons'); ?></p>
</article>