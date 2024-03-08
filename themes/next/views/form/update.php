<?php

use app\themes\next\bundles\FormBuilderBundle;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Form */

FormBuilderBundle::register($this);

// PHP options required by main-built.js
$options = array(
    "homeUrl" => Url::home(true),
    "libUrl" => Url::to('@web/static_files/js/form.builder/lib/'),
    "i18nUrl" => Url::to(['ajax/builder-phrases']),
    "componentsUrl" => Url::to(['ajax/builder-components']),
    "initPoint" => Url::to(['ajax/init-form', 'id' => $model->id]),
    "endPoint" => Url::to(['ajax/update-form', 'id' => $model->id]),
    "reCaptchaSiteKey" => Yii::$app->settings->get("app.reCaptchaSiteKey"),
    "afterSave" => 'showMessage', // Or 'redirect' Or 'open'
    "url" => Url::to(['/form']),
    "_csrf" => Yii::$app->request->getCsrfToken(),
);

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'builder-options');

$this->title = Yii::t('app', 'Update Form');
?>

<div class="form-update">
    <div class="page-body">
        <div class="container-xl">
            <div id="ef-loading" class="ef-loading">
                <div class="ef-loader">
                    <div class="spinner-border text-blue" role="status">
                        <span class="visually-hidden"><?= Yii::t('app', 'Loading') ?>...</span>
                    </div>
                </div>
            </div>
            <div id="ef-form-builder" class="row" style="display: none">
                <!-- Widgets -->
                <div id="ef-widgets" class="col-12 col-md-4">
                    <div class="ef-sidebar-outer">
                        <div class="ef-sidebar-left">
                            <div class="card-tabs">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-justified" id="formtabs" role="tablist">
                                    <li class="nav-item"><a href="#tab-ef-fields" class="nav-link active" data-bs-toggle="tab"><?= Yii::t('app', 'Fields') ?></a></li>
                                    <li class="nav-item"><a href="#tab-ef-settings" class="nav-link" data-bs-toggle="tab"><?= Yii::t('app', 'Settings') ?></a></li>
                                    <li class="nav-item"><a href="#tab-ef-code" class="nav-link" data-bs-toggle="tab"><?= Yii::t('app', 'Code') ?></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-ef-fields" class="card tab-pane active show">
                                    </div>
                                    <div id="tab-ef-settings" class="card tab-pane">
                                    </div>
                                    <div id="tab-ef-code" class="card tab-pane">
                                    </div>
                                </div>
                            </div>
                            <div id="ef-switcher-side-left" class="ef-switcher ef-switcher-side-left">
                                <div id="ef-switcher-inner" class="ef-switcher-inner">
                                    <label id="ef-switcher-preview" class="ef-switcher-preview" title="<?= Yii::t('app', 'Hide Panel') ?>">
                                        <span class="fas fa-chevron-left"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Widgets -->

                <!-- Building Form. -->
                <div id="ef-main" class="col-xs-12 col-md-5">
                    <!-- Alert. -->
                    <div class="alert alert-primary alert-dismissible" style="display: none">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                </svg>
                            </div>                                <div>
                                <h4 class="alert-title"><?= Yii::t('app', 'Did you know?') ?></h4>
                                <div class="text-muted">
                                    <?= Yii::t(
                                        'app',
                                        'Just Click the Fields or Drag & Drop them to start building your form. It\'s fast, easy & fun.'
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                    <!-- / Alert. -->
                    <div id="ef-switcher-main-left" class="ef-switcher ef-switcher-main-left">
                        <div id="ef-switcher-inner" class="ef-switcher-inner">
                            <label id="ef-switcher-preview" class="ef-switcher-preview" title="<?= Yii::t('app', 'Show Panel') ?>">
                                <span class="fas fa-chevron-right"></span>
                            </label>
                        </div>
                    </div>
                    <div id="canvas">
                        <form id="my-form">
                        </form>
                    </div>
                    <div id="ef-switcher-main-right" class="ef-switcher ef-switcher-main-right">
                        <div id="ef-switcher-inner" class="ef-switcher-inner">
                            <label id="ef-switcher-preview" class="ef-switcher-preview" title="<?= Yii::t('app', 'Show Panel') ?>">
                                <span class="fas fa-chevron-left"></span>
                            </label>
                        </div>
                    </div>
                    <div id="messages">
                        <div data-alerts="alerts"
                             data-titles="{'warning': '<em><?= Yii::t('app', 'Warning!') ?></em>'}"
                             data-ids="myid" data-fade="2000"></div>
                    </div>
                    <div id="actions">
                        <input id="formId" type="hidden" value="<?= $model->id ?>">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-default saveForm"
                                    data-endpoint="<?= Url::to(['ajax/update-form', 'id' => $model->id]) ?>"
                                    data-aftersave="showMessage" data-url="">
                                <span class="fas fa-check me-2"></span>
                                <span id="saveText"><?= Yii::t('app', 'Save Form') ?></span>
                            </button>
                            <button type="button" class="btn btn-icon btn-default dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item viewForm" target="_blank" href="<?= Url::to(['app/form', 'id' => $model->hashId], true) ?>">
                                        <?= Yii::t('app', 'View Form') ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item saveForm" href="#"
                                       data-endpoint="<?= Url::to(['ajax/update-form', 'id' => $model->id]) ?>"
                                       data-aftersave="open"
                                       data-url="<?= Url::to(['app/form', 'id' => $model->hashId], true) ?>">
                                        <?= Yii::t('app', 'Save & View Form') ?>
                                    </a>
                                </li>
                                <?php if (Yii::$app->user->can('createTemplates')) : ?>
                                    <li>
                                        <a class="dropdown-item saveForm" href="#"
                                           data-endpoint="<?= Url::to(['ajax/create-template']) ?>"
                                           data-aftersave="redirect"
                                           data-url="<?= Url::to(['/templates']) ?>">
                                            <?= Yii::t('app', 'Save Form as Template') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- / Building Form. -->

                <!-- Styles -->
                <div id="ef-styles" class="col-12 col-md-3">
                    <div class="ef-sidebar-outer">
                        <div class="ef-sidebar-right">
                            <div id="ef-switcher-side-right" class="ef-switcher ef-switcher-side-right">
                                <div id="ef-switcher-inner" class="ef-switcher-inner">
                                    <label id="ef-switcher-preview" class="ef-switcher-preview" title="<?= Yii::t('app', 'Hide Panel') ?>">
                                        <span class="fas fa-chevron-right"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <?= Yii::t('app', 'Design') ?>
                                    <div class="float-end">
                                        <span id="loading-styles"><small><?= Yii::t('app', 'Loading...') ?></small></span>
                                        <div id="dropdown-styles" class="dropdown">
                                            <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                                <span class="fas fa-ellipsis-v"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" id="copy-styles" class="dropdown-item"><span class="dropdown-item-icon"><span class="fal fa-copy mx-2"></span></span> <?= Yii::t('app', 'Copy') ?></a>
                                                <a href="#" id="paste-styles" class="dropdown-item"><span class="dropdown-item-icon"><span class="far fa-paste mx-2"></span></span> <?= Yii::t('app', 'Paste') ?></a>
                                                <a href="#" id="reset-styles" class="dropdown-item"><span class="dropdown-item-icon"><span class="far fa-redo mx-2"></span></span> <?= Yii::t('app', 'Reset') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="styles" class="card-body"></div>
                            </div>
                            <div id="ef-styles-tools" class="mt-2 ef-styles-tools">
                                <a href="#" id="ef-styles-collapse-all"><?= Yii::t('app', 'Collapse All') ?></a>
                                <span class="ef-styles-separator">|</span>
                                <a href="#" id="ef-styles-expand-all"><?= Yii::t('app', 'Expand All') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Styles -->

                <!-- .modal -->
                <div class="modal fade" id="saved" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <?= Yii::t('app', 'Great! Your form is saved.') ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= Yii::t('app', 'Close') ?>"></button>
                            </div>
                            <div class="modal-body">
                                <p><?= Yii::t('app', 'What do you want to do now?') ?></p>
                                <div class="list-group">
                                    <a href="<?= $url = Url::to(['form/update', 'id' => $model->id]); ?>" id="toUpdate"
                                       class="list-group-item list-group-item-action">
                                        <h4 class="list-group-item-heading"><?= Yii::t('app', 'It\'s Ok.') ?></h4>
                                        <p class="list-group-item-text text-muted">
                                            <?= Yii::t('app', 'I still want to edit this form.') ?></p></a>
                                    <a href="<?= $url = Url::to(['form/settings', 'id' => $model->id]); ?>" id="toSettings"
                                       class="list-group-item list-group-item-action">
                                        <h4 class="list-group-item-heading">
                                            <?= Yii::t('app', 'Let’s go to Form Settings.') ?></h4>
                                        <p class="list-group-item-text text-muted">
                                            <?= Yii::t('app', 'I need to setup my email notifications, confirmation options and more.') ?></p></a>
                                    <a href="<?= $url = Url::to(['form/share', 'id' => $model->id]); ?>" id="toPublish"
                                       class="list-group-item list-group-item-action">
                                        <h4 class="list-group-item-heading">
                                            <?= Yii::t('app', 'Share this Form.') ?></h4>
                                        <p class="list-group-item-text text-muted">
                                            <?= Yii::t('app', 'I want to publish and share my form.') ?></p></a>
                                    <a href="<?= $url = Url::to(['form/index']); ?>"
                                       class="list-group-item list-group-item-action">
                                        <h4 class="list-group-item-heading">
                                            <?= Yii::t('app', 'I finished! Take me back to the Form Manager.') ?></h4>
                                        <p class="list-group-item-text text-muted">
                                            <?= Yii::t('app', 'That\'s all.') ?></p></a>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>
    </div>
</div>