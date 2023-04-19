<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */

$this->title = 'Update Coursework Nta5: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta5s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coursework-nta5-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
