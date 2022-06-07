<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Interviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="interview-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']) ?>

        <?php if($model->isRecruitable()): ?>
            <?= Html::a(Yii::t('app', 'Recruit'),
                ['employee/create', 'interview_id' => $model->id],
                ['class' => 'btn btn-success']) ?>
        <?php endif; ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a(Yii::t('app', 'Reject'),
            ['reject', 'id' => $model->id],
            ['class' => 'btn btn-danger',]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->statusName;
                },
                'format' => 'raw',
            ],
            'reject_reason:ntext',
            'employee_id',
        ],
    ]) ?>

</div>
