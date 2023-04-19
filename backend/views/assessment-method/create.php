<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AssessmentMethod */

$this->title = 'Create Assessment Method';
$this->params['breadcrumbs'][] = ['label' => 'Assessment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assessment-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
