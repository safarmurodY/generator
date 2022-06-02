<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dismiss */

$this->title = Yii::t('app', 'Create Dismiss');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dismisses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dismiss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
