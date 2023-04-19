<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GeneratedResult */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Generated Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="generated-result-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'course_id',
            'nta_level',
            'academic_year_id',
            'semester_id',
            'created_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
