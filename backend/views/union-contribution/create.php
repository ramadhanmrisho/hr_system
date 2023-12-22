<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UnionContribution */

$this->title = 'Union Contribution Details';
$this->params['breadcrumbs'][] = ['label' => 'Union Contributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="union-contribution-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
