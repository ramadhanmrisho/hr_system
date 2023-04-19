<?php

use common\models\AssessmentMethod;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AssignedModule */

$this->title = $model->module->module_name;
$this->params['breadcrumbs'][] = ['label' => 'Assigned Modules', 'url' => ['index']];

?>
<div class="assigned-module-view">

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
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>
    <?php if (\common\models\UserAccount::userHas(['HOD'])){?>
    <p>
        <?= Html::a('Change Assigned Staff', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php }?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            ['attribute'=>'staff_id','value'=>function($model){return $model->staff->fname.' '.$model->staff->lname;}],
            ['attribute'=>'module_id','value'=>function($model){return $model->module->module_name;}],
            ['attribute'=>'course_id','value'=>function($model){return $model->course->course_name;}],
            ['attribute'=>'semester_id','value'=>function($model){return $model->semester->name;}],
            ['attribute'=>'academic_year_id','value'=>function($model){return $model->academicYear->name;}],
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
            ['attribute'=>'created_by','value'=>function(){
             return 'HOD';
            },'label'=>'Assigned By'],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
<h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Assessment Methods</h4>
<?php
$searchModel = new \common\models\search\AssessmentMethodTrackingSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->where(['module_id'=>$model->module_id])
?>
<?= fedemotta\datatables\DataTables::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute'=>'assessment_method_id','value'=>function($model){
            return  AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;
        },'label'=>'Assessment Methods'],
        'category',
        'percent',
    ],
]); ?>
