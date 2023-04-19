<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AssessmentMethodTracking */

$this->title = 'Create Assessment Method Tracking';
$this->params['breadcrumbs'][] = ['label' => 'Assessment Method Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assessment-method-tracking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
