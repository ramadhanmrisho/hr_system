<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Gpa */

$this->title = 'Create Gpa';
$this->params['breadcrumbs'][] = ['label' => 'Gpas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gpa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
