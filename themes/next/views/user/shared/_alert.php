<?php

use yii\bootstrap5\Alert;

/**
 * @var $module Da\User\Module
 */

?>

<?php if (false && $module->enableFlashMessages): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                <?php if (in_array($type, ['success', 'danger', 'warning', 'info'], true)): ?>
                    <?= Alert::widget(
                        [
                            'options' => ['class' => 'alert-dismissible alert-' . $type],
                            'body' => $message,
                        ]
                    ) ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>
