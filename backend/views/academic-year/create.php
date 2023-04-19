<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AcademicYear */

$this->title = 'Create Academic Year';
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
