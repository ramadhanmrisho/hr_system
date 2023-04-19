<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YearOfStudy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Year Of Studies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="year-of-study-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'name',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>

</div>
