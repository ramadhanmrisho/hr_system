<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grades';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="grade-index">

    <?php Pjax::begin(); ?>
      <?php if (\common\models\UserAccount::userHas(['ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-plus"> Create Grade</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php }?>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'lower_score','value'=>function($model){
            return $model->lower_score.' - '.$model->upper_score;
            },'label'=>'SCORE RANGE'],
            'grade',

            //'academic_year_id',
            'point',
            'description',
            'nta_level',
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
