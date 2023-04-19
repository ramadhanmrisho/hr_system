<?php

use common\models\AssessmentMethod;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Module */

$this->title = $model->module_name;
//$this->params['breadcrumbs'][] = ['label' => 'Modules', 'url' =>"#"];
//$this->params['breadcrumbs'][] = $this->title;
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
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="module-view">

    <?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-pencil">Update Module Details</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
<?php }?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'module_name',
            'module_code',
            'module_credit',
           ['attribute'=>'course_id','value'=>function($model){
            return $model->course->course_name;
           }],
          
            'nta_level',
            'prerequisite',
            ['attribute'=>'semester_id','value'=>function($model){
                return $model->semester->name;
            }],
            ['attribute'=>'department_id','value'=>function($model){
                return $model->department->name;
            }],
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>
<h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Assessment Methods</h4>
<?php
$searchModel = new \common\models\search\AssessmentMethodTrackingSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->where(['module_id'=>$model->id])
?>
<?= fedemotta\datatables\DataTables::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute'=>'assessment_method_id','value'=>function($model){

    if(AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->exists()){
       return AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;
    }
    else {return  'N/A';}


        },'label'=>'Assessment Methods'],
        'category',
        'percent',
        ['class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}','buttons'=>['delete'=>function($url,$model){
            return  \common\models\UserAccount::userHas(['ADMIN','HOD'])? Html::a('<span class="glyphicon glyphicon-remove"></span> Delete',['/module/remove-module','id'=>$model->id,'module_id'=>$model->module_id],[
                'data' => [
                    'confirm' => 'Are you sure you want to delete this Method?',
                    'method' => 'post',
                ],
            ]):'';
        }]]
    ],
]); ?>

