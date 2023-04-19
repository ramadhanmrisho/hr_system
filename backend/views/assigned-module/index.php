<?php

use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssignedModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Module Instructors';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="assigned-module-index">


    <?php if (\common\models\UserAccount::userHas(['HOD'])){?>

    <p>
        <?= Html::a('<span class="fa fa-slideshare"> Assign Module to Instructor</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php }?>
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'staff_id','value'=>function($model){return $model->staff->fname.' '.$model->staff->lname;}],
            ['attribute'=>'module_id','value'=>'module.module_name'],
            ['attribute'=>'module_id','value'=>'module.module_credit','label'=>'Credit'],
            ['attribute'=>'course_id','value'=>'course.course_name'],
            ['attribute'=>'semester_id','value'=>'semester.name'],
            ['attribute'=>'academic_year_id','value'=>'academicYear.name'],
             ['attribute'=>'year_of_study_id','value'=>function($model){

                if($model->yearOfStudy->name=='First Year'){
                    return 'NTA 4';
                }
                if($model->yearOfStudy->name=='Second Year'){
                    return 'NTA 5';
                }
                if($model->yearOfStudy->name=='Third Year'){
                    return 'NTA 6';
                }

            },'label'=>'NTA Level'


            ],

            ['class' => 'yii\grid\ActionColumn',
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
                            $url = 'index.php?r=course/view&id='.$model->id;
                            return $url;
                        }

                    } ,
                ],

            ],
        ],
    ]); ?>

</div>

