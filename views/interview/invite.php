<?php

use app\forms\InterviewInviteForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $joinForm InterviewInviteForm */
/* @var $form yii\bootstrap4\ActiveForm */

$this->title = 'Join Form';
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="interview-join-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($joinForm, 'date')->textInput() ?>

        <?= $form->field($joinForm, 'first_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($joinForm, 'last_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($joinForm, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Join'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
