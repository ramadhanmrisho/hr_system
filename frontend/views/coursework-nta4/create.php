<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta4 */

$this->title = 'Create Coursework Nta4';
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coursework-nta4-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
