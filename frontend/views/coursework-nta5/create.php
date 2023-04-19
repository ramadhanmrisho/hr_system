<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */

$this->title = 'Create Coursework Nta5';
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta5s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coursework-nta5-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
