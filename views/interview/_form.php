<?php

use app\models\Employee;
use app\models\Interview;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="interview-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if($model->scenario == $model::SCENARIO_DEFAULT): ?>

        <?= $form->field($model, 'status')->dropDownList(Interview::getStatusList(), ['id' => 'interview-status']) ?>

        <?= $form->field($model, 'reject_reason')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'employee_id')
            ->dropDownList(ArrayHelper::map(Employee::find()->all(), 'id', 'fullName'))?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
