<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @var  \app\models\SignupForm $model */
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to signup:</p>
    <div class="row">
        <div class="col-md-12">

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'enableAjaxValidation' => true,
            ]); ?>
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'username') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'info')->textarea() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname(), []) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>