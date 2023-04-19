<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YearOfStudy */

$this->title = 'Update Year Of Study: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Year Of Studies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="year-of-study-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
