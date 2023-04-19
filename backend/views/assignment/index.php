<?php

use common\models\Assignment;
use common\models\Semester;
use fedemotta\datatables\DataTables;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<div class="assignment-index">
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>
    <?php Pjax::begin(); ?>


    <p>
        <?= Html::a('<span class="fa fa-cloud-upload">Upload Results</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    //$active_semester=Semester::find()->where(['status'=>'Active'])->one()->id;
    //$dataProvider = new ActiveDataProvider(['query'=>Assignment::find()->where(['created_by'=>Yii::$app->user->identity->user_id,'semester_id'=>$active_semester])]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'student_id','value'=>function($model){
                return $model->student->registration_number;},'label'=>'Registration Number'],

            ['attribute'=>'student_id','value'=>function($model){
                return $model->student->fname.' '.$model->student->lname;}],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                'filter'=>ArrayHelper::map(\common\models\Module::find()->asArray()->all(), 'id', 'module_name'),
                ],
            ['attribute'=>'assessment_method_id','value'=>function($model){
                 return \common\models\AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;},
                'filter'=>ArrayHelper::map(\common\models\AssessmentMethod::find()->asArray()->all(), 'id', 'name'),
            ],
            'score',
            ['attribute'=>'course_id','value'=>function($model){ return $model->course->course_name;},
                'filter'=>ArrayHelper::map(\common\models\Course::find()->asArray()->all(), 'id', 'course_name'),
            ],
            ['attribute'=>'nta_level','value'=>function($model){ 
                
             return $model->nta_level;
                
            },'label'=>'NTA Level'
                
            ],
            ['attribute'=>'academic_year_id','value'=>function($model){ return $model->academicYear->name;},
                'filter'=>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'id', 'name'),],

            ['attribute'=>'semester_id','value'=>function($model){ return $model->semester->name;},
                'filter'=>ArrayHelper::map(\common\models\Semester::find()->asArray()->all(), 'id', 'name'),],

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
                            $url = 'index.php?r=assignment/view&id='.$model->id;
                            return $url;
                        }
                    } ,

                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
