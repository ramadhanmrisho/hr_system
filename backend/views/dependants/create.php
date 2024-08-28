<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dependants */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Dependants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dependants-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
