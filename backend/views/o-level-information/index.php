<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OLevelInformationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'O Level Informations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="olevel-information-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create O Level Information', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_of_school',
            'index_number',
            'student_id',
            'Physics',
            //'Mathematics',
            //'Chemistry',
            //'Biology',
            //'English',
            //'year_of_complition',
            //'division',
            //'o_level_certificate',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
