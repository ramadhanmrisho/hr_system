<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GpaClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'GPA Classes';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="gpa-class-index">


    <?php Pjax::begin(); ?>


  <?php if (\common\models\UserAccount::userHas(['ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-plus">Create GPA Class</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php }?>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'starting_point','value'=>function($model){
                return $model->starting_point.' - '.$model->end_point;
            },'label'=>'COMMULATIVE GPA'],
            'gpa_class',

            ['attribute'=>'nta_level','value'=>function($model){ return $model->nta_level;},
                'filter'=>ArrayHelper::map(\common\models\NtaLevel::find()->asArray()->all(), 'id', 'name'),
            ],

            ['attribute'=>'academic_year_id','value'=>function($model){ return $model->academicYear->name;},
                'filter'=>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'id', 'name'),],
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
