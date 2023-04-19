<?php

use common\models\AcademicYear;
use common\models\Semester;
use fedemotta\datatables\DataTables;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseworkNta6Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Coursework Scores';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="btn-primary" style=" font-weight: bold;font-family: 'Tahoma';color: whitesmoke;">
    <br>
    <h4 align="center">COURSEWORK SCORES</h4>

    <h4 align="right" ><b>Academic Year:<?php   $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->name;
        echo $current_academic_year;?></h4>
</div>
<h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">SEMESTER I </h4>

<?php
$semester_1=Semester::find()->where(['name'=>'I'])->one()->id;
$dataProvider = new ActiveDataProvider(['query'=>\common\models\CourseworkNta6::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_1])])

?>

<div class="table-responsive">

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_code;},
                'label'=>'Module Code','headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                'filter'=>ArrayHelper::map(\common\models\Module::find()->asArray()->all(), 'id', 'module_name'),'headerOptions' => [ 'style' => 'color:#66a3ff']],

            ['attribute'=>'cat_1','value'=>function($model){return $model->cat_1>-1?$model->cat_1:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'cat_2','value'=>function($model){return !empty($model->cat_2)?$model->cat_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
             ['attribute'=>'remarks','value'=>function($model){
             $total_cat1_cat2=$model->cat_1+$model->cat_2;
             $average=round($total_cat1_cat2/2,0);
             return $average;
            },'label'=>'Average CAT1&CAT2','headerOptions' => [ 'style' => 'color:blue']],
             ['attribute'=>'remarks','value'=>function($model){
             $total_cat1_cat2=$model->cat_1+$model->cat_2;
             $average=round($total_cat1_cat2/2,0);
             if($average>50 || $average==50){
                 return 'PASS';
             }
             else{
               return 'SUP';
             }
            },'label'=>'CAT1&CAT2 Remarks','headerOptions' => [ 'style' => 'color:red']],
            ['attribute'=>'assignment_1','value'=>function($model){return $model->assignment_1>-1?$model->assignment_1:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'assignment_2','value'=>function($model){return $model->assignment_2>-1?$model->assignment_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'practical','value'=>function($model){return $model->practical>-1?$model->practical:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'practical_2','value'=>function($model){return $model->practical_2>-1?$model->practical_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'ppb','value'=>function($model){return $model->ppb>-1?$model->ppb:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
            ['attribute'=>'total_score','value'=>function($model){return $model->total_score>-1?$model->total_score:'-';},'headerOptions' => [ 'style' => 'color:red']],

            ['attribute'=>'remarks','value'=>'remarks','label'=>'REMARKS','headerOptions' => [ 'style' => 'color:red']]

        ],
    ]); ?>


    <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">SEMESTER II </h4>

    <?php
    $semester_2=Semester::find()->where(['name'=>'II'])->one()->id;
    $dataProvider = new ActiveDataProvider(['query'=>\common\models\CourseworkNta6::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_2])])

    ?>

    <div class="table-responsive">

        <?= DataTables::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_code;},
                    'label'=>'Module Code','headerOptions' => [ 'style' => 'color:#66a3ff']],

                ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                    'filter'=>ArrayHelper::map(\common\models\Module::find()->asArray()->all(), 'id', 'module_name'),'headerOptions' => [ 'style' => 'color:#66a3ff']],

                ['attribute'=>'cat_1','value'=>function($model){return $model->cat_1>-1?$model->cat_1:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'cat_2','value'=>function($model){return !empty($model->cat_2)?$model->cat_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'remarks','value'=>function($model){
             $total_cat1_cat2=$model->cat_1+$model->cat_2;
             $average=round($total_cat1_cat2/2,0);
             return $average;
            },'label'=>'Average CAT1&CAT2','headerOptions' => [ 'style' => 'color:blue']],
             ['attribute'=>'remarks','value'=>function($model){
             $total_cat1_cat2=$model->cat_1+$model->cat_2;
             $average=round($total_cat1_cat2/2,0);
             if($average>50 || $average==50){
                 return 'PASS';
             }
             else{
               return 'SUP';
             }
            },'label'=>'CAT1&CAT2 Remarks','headerOptions' => [ 'style' => 'color:red']],
                ['attribute'=>'assignment_1','value'=>function($model){return $model->assignment_1>-1?$model->assignment_1:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'assignment_2','value'=>function($model){return $model->assignment_2>-1?$model->assignment_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'practical','value'=>function($model){return $model->practical>-1?$model->practical:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'practical_2','value'=>function($model){return $model->practical_2>-1?$model->practical_2:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'ppb','value'=>function($model){return $model->ppb>-1?$model->ppb:'-';},'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'total_score','value'=>function($model){return $model->total_score>-1?$model->total_score:'-';},'headerOptions' => [ 'style' => 'color:red']],

                ['attribute'=>'remarks','value'=>'remarks','label'=>'REMARKS','headerOptions' => [ 'style' => 'color:red']]


            ],
        ]); ?>








    </div>
