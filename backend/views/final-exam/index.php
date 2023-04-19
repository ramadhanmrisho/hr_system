<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FinalExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Final Exams';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<div class="final-exam-index">
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>

    <?php Pjax::begin(); ?>


    <p>
        <?= Html::a('<span class="fa fa-cloud-upload"> Upload Final Exam Results</span>', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('<span class="fa fa-download"> Download CSV Template</span>', 'templates/semester_exam_template.csv', ['class' => 'btn btn-primary']) ?>

    </p>


    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'student_id','value'=>function($model){
                return $model->student->fname.' '.$model->student->lname;}],
            'registration_number',
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                'filter'=>ArrayHelper::map(\common\models\Module::find()->asArray()->all(), 'id', 'module_name'),
            ],
            ['attribute'=>'course_id','value'=>function($model){ return $model->course->course_name;},
                'filter'=>ArrayHelper::map(\common\models\Course::find()->asArray()->all(), 'id', 'course_name'),
            ],
            'nta_level',
            ['attribute'=>'academic_year_id','value'=>function($model){ return $model->academicYear->name;},
                'filter'=>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'id', 'name'),],
            ['attribute'=>'semester_id','value'=>function($model){ return $model->semester->name;},
                'filter'=>ArrayHelper::map(\common\models\Semester::find()->asArray()->all(), 'id', 'name'),],
            'written_exam',
            'practical',
              ['attribute'=>'project_work','value'=>function($model){ return $model->project_work;},
                'visible'=>!empty($model->project_work)],
            'total_score',
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
                            $url = 'index.php?r=final-exam/view&id='.$model->id;
                            return $url;
                        }
                    } ,

                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
