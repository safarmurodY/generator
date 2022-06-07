<?php

use app\forms\InterviewInviteForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $rejectForm \app\forms\InterviewRejectForm */
/* @var $model \app\models\Interview */
/* @var $form yii\bootstrap4\ActiveForm */

$this->title = Yii::t('app', 'Rejecting Interview: {name}', [
    'name' => $model->fullName,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Interviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Reject');

?>
<div class="interview-reject-form">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($rejectForm, 'reason')->textarea(['rows' => 5]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Reject'), ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
