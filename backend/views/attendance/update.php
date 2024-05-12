<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */
$staff = \common\models\Staff::findOne($model->staff_id);
$this->title = 'UPDATE ATTENDANCE OF ' . $staff->fname.' '.$staff->lname;
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="attendance-update">



    <?= $this->render('_edit', [
        'model' => $model,
    ]) ?>

</div>
