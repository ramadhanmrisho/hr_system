<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AcademicYear */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'name',
            'status',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>

</div>
