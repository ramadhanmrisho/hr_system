<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OlevelAndAlevelSubject */

$this->title = 'Create Olevel And Alevel Subject';
$this->params['breadcrumbs'][] = ['label' => 'Olevel And Alevel Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="olevel-and-alevel-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
