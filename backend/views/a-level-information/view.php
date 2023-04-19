<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ALevelInformation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'A Level Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alevel-information-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name_of_school',
            'index_number',
            'student_id',
            'Physics',
            'Mathematics',
            'Chemistry',
            'Biology',
            'year_of_complition',
            'division',
            'a_level_certificate',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
