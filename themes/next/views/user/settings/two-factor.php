<?php

/** @var string $id */
/** @var string $uri */

?>

<div class="alert alert-info" id="tfmessage">
    <p>
        <?= Yii::t(
            'app',
            'Scan the QrCode with Google Authenticator App, then insert its temporary code on the box and submit.'
        ) ?>
    </p>
</div>

<div class="row">
    <div class="col-md-offset-3 col-md-6 text-center">
        <img id="qrCode" src="<?= $uri ?>"/>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-3 col-md-6 text-center">
        <div class="input-group">
            <input type="text" class="form-control" id="tfcode" placeholder="<?= Yii::t('app', 'Two factor authentication code') ?>"/>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-submit-code">
                    <?= Yii::t('app', 'Enable') ?>
                </button>
            </span>
        </div>
    </div>
</div>
