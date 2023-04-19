<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostponedStudent */

$this->title = 'Create Postponed Student';
$this->params['breadcrumbs'][] = ['label' => 'Postponed Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postponed-student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
