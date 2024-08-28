<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NextOfKin $model */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Next Of Kin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="next-of-kin-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
