<?php

use fedemotta\datatables\DataTables;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="test-index">

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('<span class="fa fa-cloud-upload"> Upload Test</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'student_id','value'=>function($model){
                return $model->student->fname.' '.$model->student->lname;}],
            'registration_number',
            ['attribute'=>'category','value'=>'category',
                'filter'=>['Assignment 1'=>'Assignment 1','Assignment 2'=>'Assignment 2']],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                'filter'=>ArrayHelper::map(\common\models\Module::find()->asArray()->all(), 'id', 'module_name'),
            ],
            ['attribute'=>'course_id','value'=>function($model){ return $model->course->course_name;},
                'filter'=>ArrayHelper::map(\common\models\Course::find()->asArray()->all(), 'id', 'course_name'),
            ],
            ['attribute'=>'year_of_study_id','value'=>function($model){ return $model->yearOfStudy->name;},
                'filter'=>ArrayHelper::map(\common\models\YearOfStudy::find()->asArray()->all(), 'id', 'name'),
            ],
            ['attribute'=>'academic_year_id','value'=>function($model){ return $model->academicYear->name;},
                'filter'=>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'id', 'name'),],
            ['attribute'=>'semester_id','value'=>function($model){ return $model->semester->name;},
                'filter'=>ArrayHelper::map(\common\models\Semester::find()->asArray()->all(), 'id', 'name'),],
            'score',
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' =>'yii\grid\ActionColumn',
                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
                'header'=>"ACTION",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [

                    //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);
                    },

                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=test/view&id='.$model->id;
                            return $url;
                        }
                    } ,

                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
