<?php

use fedemotta\datatables\DataTables;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Course */

$this->title = $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
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
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="course-view">
<?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-pencil">Update Course Details</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
<?php }?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            'duration_in_years',
            'abbreviation',
            ['attribute'=>'department_id','value'=>$model->department->name],
            'created_at:datetime',
            'createdBy.fullName',
            'updated_at:datetime',
        ],
    ]) ?>

</div>


<br>
<h4>MODULES LIST</h4>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-6">
            <?php
            $semester1=\common\models\Semester::find()->where(['name'=>'I'])->one()->id;
            $dataProvider=new \yii\data\ActiveDataProvider(['query'=>\common\models\Module::find()->where(['course_id'=>$model->id,'semester_id'=>$semester1])]);
            ?>
            <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">FIRST SEMESTER </h4>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'module_name',
                    'module_code',
                    'module_credit',
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">SECOND SEMESTER</h4>
            <?php
            $semester1=\common\models\Semester::find()->where(['name'=>'II'])->one()->id;
            $nta=new \yii\data\ActiveDataProvider(['query'=>\common\models\Module::find()->where(['course_id'=>$model->id,'semester_id'=>$semester1])]);
            ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $nta,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'module_name',
                    'module_code',
                    'module_credit',
                ],
            ]); ?>


        </div>

    </div>
</div>



