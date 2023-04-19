<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta6 */

$this->title = 'Create Coursework Nta6';
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta6s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coursework-nta6-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
