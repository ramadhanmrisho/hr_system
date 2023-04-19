<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SupplementarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student With Supplementary';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
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
<div class="supplementary-index">

    <?php Pjax::begin(); ?>

    <?php
    $teacher_sup=\common\models\Supplementary::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])->exists();

    if ($teacher_sup){
    ?>
    <p>
        <?= Html::a('<span class="fa fa-cloud-upload"> Upload Supplementary  Results</span>', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('<span class="fa fa-download"> Download CSV Template</span>', 'templates/semester_exam_template.csv', ['class' => 'btn btn-primary']) ?>
    </p>
<?php }?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'student_id','value'=>function($model){
                return $model->student->registration_number;},'label'=>'Registration Number','headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'student_id','value'=>function($model){return $model->student->fname.' '.$model->student->lname;},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_code;},
                'headerOptions' => [ 'style' => 'color:#66a3ff'],'label'=>'Module Code'],
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

            'status',
//            ['class' => 'yii\grid\ActionColumn','template'=>'{pass} {fail}',
//                'contentOptions' => ['style' => 'width: 10%'],
//                'visible'=> Yii::$app->user->isGuest ? false : true,
//                'header'=>'ACTION',
//                'headerOptions' => [
//                    'style' => 'color:red'
//                ],
//                'buttons'=>[
//                    'pass' => function ($url, $model) {
//
//                        return $model->status == 'Not Done'
//                            ? Html::a('<span class="fa fa-check-square-o"> Pass</span>', $url, [
//
//                                'title' => Yii::t('app', 'Pass'),
//                                'class' => 'btn btn-success btn-xl',
//
//                            ]) : ' ';
//                    },
//
//                    'fail'=>function ($url, $model) {
//                        $t = 'index.php?r=supplementary/fail&id='.$model->id;
//                        if ($model->status=='Not Done'):
//                            return Html::button('<span class="fa fa-times">Fail</span>', ['value'=>Url::to($t), 'title' => Yii::t('app', 'Fail'), 'class' => 'btn btn-danger  custom_button']);
//                        endif;
//                    }
//
//                ],
//            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
