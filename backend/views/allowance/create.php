<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Allowance */

$this->title = 'Allowance Details';
$this->params['breadcrumbs'][] = ['label' => 'Allowances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allowance-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
