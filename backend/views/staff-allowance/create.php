<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffAllowance */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Staff Allowances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-allowance-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
