<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Allowance */

$this->title = 'Update : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Allowances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allowance-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
