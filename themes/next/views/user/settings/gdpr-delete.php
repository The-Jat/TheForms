<?php

use app\components\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model Da\User\Form\GdprDeleteForm */

?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= Yii::t('app', 'Delete personal data') ?>
                </h3>
            </div>
            <div class="panel-body">
                <p><?= Yii::t('app', 'You are about to delete all your personal data from this site.') ?></p>
                <p class="text-danger">
                    <?= Yii::t(
                        'app',
                        'Once you have deleted your data, you will not longer be able to sign in with this account.'
                    ) ?>
                </p>
                <hr>
                <?php
                $form = ActiveForm::begin([])
                ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?= Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?= Html::a(Yii::t('app', 'Back to privacy settings'), ['/user/settings/privacy'], ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>

