<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $success boolean */
/* @var $message string */
/* @var app\models\Form $formModel */

if ($success) {
    $icon = Html::tag('span', ' ', [
        'class' => 'fas fa-check-circle text-success',
        'style' => 'font-size: 72px; margin-bottom: 15px;'
    ]);
    $message = !empty($formModel->formConfirmation->message) ?
        $formModel->formConfirmation->message : Html::tag('h3', $message, ['class' => 'text-center']);
} else {
    $icon = Html::tag('span', ' ', [
        'class' => 'fas fa-exclamation-triangle text-danger',
        'style' => 'font-size: 72px; margin-bottom: 15px;'
    ]);
    $message = Html::tag('h3', $message);
}
?>
<div class="app-valid text-center" style="margin-top: 120px">
    <?= Html::decode($icon) ?>
    <?= Html::decode($message) ?>
    <button type="button" onclick="window.history.go(-1);" class="btn btn-default" style="margin-top: 30px">
        <i class="fas fa-arrow-alt-left me-2"></i>
        <?= Yii::t('app', 'Back to previous page') ?>
    </button>
</div>
