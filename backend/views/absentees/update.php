<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Absentees */

$userID=\common\models\Absentees::findOne(['id'=>Yii::$app->request->get('id')])->staff_id;
$this->title ='Staff Name: '. \common\models\Staff::findOne(['id'=>$userID])->fname;
$this->params['breadcrumbs'][] = ['label' => 'Back', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="absentees-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
