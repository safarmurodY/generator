<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recruit */

$this->title = Yii::t('app', 'Create Recruit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recruits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
