<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\District */

$this->title = ' District Details';
$this->params['breadcrumbs'][] = ['label' => 'Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
