<div class="sn-tabs-body">
    <?php foreach ($networks as $id => $network): ?>
        <div class="sn-tabs-body-network<?= sli_isNetwork($defaultNetwork, $network) ? ' is-visible': null; ?>" id="sn-section-<?= $network->slug; ?>">

            <form class="sn-form" method="POST" action="<?= admin_url( 'admin-ajax.php' ); ?>" data-js-icon-progress=".icon-progress" data-js-icon-valid=".icon-valid" data-tab="sn-tab-<?= $network->slug; ?>">
                <input type="hidden" name="action" value="<?= $ajaxAction; ?>" >
                <input type="hidden" name="sn-network" value="<?= $network->slug; ?>">


                <div class="sn-tabs-body-field sn-field">
                    <div class="sn-field-col-label">
                        <label class="sn-field-label" for="sn-label-field-<?= $network->slug; ?>">
                            <?= __('Nom du réseau social', SLI_DOMAIN); ?>
                        </label>
                    </div>
                    <div class="sn-tabs-body-input sn-field-col-input">
                        <input type="text" id="sn-label-field-<?= $network->slug; ?>" class="sn-field-input" value="<?= $network->name; ?>" disabled>
                    </div>
                </div>

                <div class="sn-tabs-body-field sn-field">
                    <div class="sn-field-col-label">
                        <label class="sn-field-label" for="sn-title-field-<?= $id; ?>">
                            <?= __('Titre du réseau social', SLI_DOMAIN); ?>
                        </label>
                        <p class="description"><?= __('Attribut title qui peut apparaître sur certain lien', SLI_DOMAIN); ?></p>
                    </div>
                    <div class="sn-tabs-body-input sn-field-col-input">
                        <input type="text" class="sn-field-input" id="sn-title-field-<?= $id; ?>" name="title" value="<?= $network->title; ?>">
                    </div>
                </div>

                <div class="sn-tabs-body-field sn-field">
                    <div class="sn-field-col-label">
                        <label class="sn-field-label" for="sn-color-field-<?= $id; ?>">
                            <?= __('Couleur du réseau social', SLI_DOMAIN); ?>
                        </label>
                    </div>
                    <div class="sn-tabs-body-input sn-field-col-input row-color">
                        <div class="sn-preview-color" style="background: <?= $network->color; ?>" id="sli-color-<?= $network->slug; ?>"></div>
                        <input type="text" data-js-preview="sli-color-<?= $network->slug; ?>" class="sn-field-input" id="sn-color-field-<?= $id; ?>" name="color" value="<?= $network->color; ?>">
                    </div>
                </div>

                <div class="sn-tabs-body-field sn-field">
                    <div class="sn-field-col-label">
                        <label class="sn-field-label" for="sn-url-field-<?= $id; ?>">
                            <?= __('Url vers le réseau social', SLI_DOMAIN); ?>
                        </label>
                    </div>
                    <div class="sn-tabs-body-input sn-field-col-input">
                        <input type="text" class="sn-field-input" id="sn-url-field-<?= $id; ?>" name="url" value="<?= $network->url; ?>">
                    </div>
                </div>

                <div class="sn-tabs-body-field sn-field">
                    <div class="sn-field-col-label">
                        <label class="sn-field-label" for="sn-svg-field-<?= $network->slug; ?>">
                            <?= __('Icon du réseau social', SLI_DOMAIN); ?>
                        </label>
                        <p class="description"><?= __('Seules les icônes au format Svg sont acceptées', SLI_DOMAIN); ?></p>
                    </div>
                    <div class="sn-tabs-body-input sn-field-col-input">
                        <textarea type="text" class="sn-field-input" id="sn-svg-field-<?= $network->slug; ?>" name="svg"><?= $network->svg; ?></textarea>
                        <button class="sn-preview-btn" data-js-svg="sn-svg-field-<?= $id; ?>" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 12c0 1.103-.897 2-2 2s-2-.897-2-2 .897-2 2-2 2 .897 2 2zm10-.449s-4.252 7.449-11.985 7.449c-7.18 0-12.015-7.449-12.015-7.449s4.446-6.551 12.015-6.551c7.694 0 11.985 6.551 11.985 6.551zm-8 .449c0-2.208-1.791-4-4-4-2.208 0-4 1.792-4 4 0 2.209 1.792 4 4 4 2.209 0 4-1.791 4-4z"/></svg>
                        </button>
                    </div>
                </div>

                <footer class="sn-tab-body-footer">
                    <button class="button button-primary" type="submit" ><?= __('Save'); ?></button>
                    <div class="sn-tab-body-footer-status icon-progress">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8.177 7.376l-3.042-5.268 1.731-1 3.044 5.273c-.634.237-1.221.571-1.733.995zm-2.177 4.624c0-.341.035-.674.09-1h-6.09v2h6.09c-.055-.326-.09-.659-.09-1zm1.377-3.824l-5.269-3.042-1 1.732 5.273 3.044c.237-.635.572-1.222.996-1.734zm8.447-.799l3.043-5.271-1.731-.999-3.046 5.275c.635.236 1.222.571 1.734.995zm1.795 2.534l5.276-3.046-1.001-1.731-5.27 3.042c.424.513.758 1.1.995 1.735zm-5.619-3.911c.341 0 .674.035 1 .09v-6.09h-2v6.09c.326-.055.659-.09 1-.09zm2.09 11.618l3.045 5.274 1.731-1-3.042-5.27c-.512.425-1.099.76-1.734.996zm-7.708-3.528l-5.272 3.044 1 1.732 5.268-3.042c-.425-.512-.76-1.099-.996-1.734zm11.528-3.09c.055.326.09.658.09 1s-.035.674-.09 1h6.09v-2h-6.09zm-1.286 4.823l5.27 3.043.999-1.732-5.274-3.045c-.237.635-.571 1.222-.995 1.734zm-8.447.801l-3.041 5.268 1.732 1 3.044-5.272c-.635-.237-1.223-.572-1.735-.996zm3.823 1.376c-.341 0-.674-.035-1-.09v6.09h2v-6.09c-.326.055-.659.09-1 .09z"/></svg>                    </div>
                    <div class="sn-tab-body-footer-status icon-valid">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 21.035l-9-8.638 2.791-2.87 6.156 5.874 12.21-12.436 2.843 2.817z"/></svg>                    </div>
                </footer>

            </form>

        </div>
    <?php endforeach; ?>
</div>