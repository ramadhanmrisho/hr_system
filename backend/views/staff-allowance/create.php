<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffAllowance */

$this->title = 'Create Staff Allowance';
$this->params['breadcrumbs'][] = ['label' => 'Staff Allowances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-allowance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
