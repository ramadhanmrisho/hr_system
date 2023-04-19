<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Designation */

$this->title = 'Designation Details';
$this->params['breadcrumbs'][] = ['label' => 'Designations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
