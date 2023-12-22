<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UnionContribution */

$this->title = 'Update Union Contribution Details: ';
$this->params['breadcrumbs'][] = ['label' => 'Union Contributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="union-contribution-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
