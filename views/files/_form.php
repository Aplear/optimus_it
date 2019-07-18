<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'options' => [
            'enctype' => 'multipart/form-data',
            'accept' => [
                'application/x-rar-compressed',
                'application/zip',
                'application/octet-stream'
            ],
        ],

    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->fileInput([
        'multiple' => true,
        'accept' => '*',
        'pluginOptions'=>[
            'allowedFileExtensions' => ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'jpg', 'png', 'rar', 'zip']
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
