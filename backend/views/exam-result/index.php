<?php

use common\models\AcademicYear;
use common\models\Course;
use common\models\ExamResult;
use common\models\Module;
use common\models\Semester;
use common\models\UserAccount;
use common\models\YearOfStudy;
use kartik\export\ExportMenu;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ExamResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$first_year=4;
$second_year=5;
$third_year=6;

$cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
$cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
$cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;

$nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
$nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
$nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;

$current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;
$semester1=Semester::find()->where(['name'=>'I'])->one()->id;
$semester2=Semester::find()->where(['name'=>'II'])->one()->id;

$title=Yii::$app->request->get('authorization');


if ($title=='clinical_11'){
    $student_tittle='NTA 4 CLINICAL MEDICINE RESULTS IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm1,'status'=>'Wait for Approval'])->exists();

}
if ($title=='clinical_12'){
    $student_tittle='NTA 4 CLINICAL MEDICINE RESULTS  IN SEMESTER II';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm1,'status'=>'Wait for Approval'])->exists();
}

if ($title=='clinical_21'){
    $student_tittle='NTA 5 CLINICAL MEDICINE RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year ,'course_id'=>$cm2,'status'=>'Wait for Approval'])->exists();

}
if ($title=='clinical_22'){
    $student_tittle='NTA 5 CLINICAL MEDICINE RESULTS  IN SEMESTER II';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,
    'course_id'=>$cm2,'status'=>'Wait for Approval'])->exists();

}
if ($title=='clinical_31'){
    $student_tittle='NTA 6 CLINICAL MEDICINE RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,
    'course_id'=>$cm3,'status'=>'Wait for Approval'])->exists();

}
if ($title=='clinical_32'){
    $student_tittle='NTA 6 CLINICAL MEDICINE RESULTS  IN SEMESTER II';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,
    'course_id'=>$cm3,'status'=>'Wait for Approval'])->exists();
}
if ($title=='nursing_11'){
    $student_tittle='NTA 4 NURSING AND MIDWIFERY RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm1,'status'=>'Wait for Approval'])->exists();
  
}
if ($title=='nursing_12'){
    $student_tittle='NTA 4 NURSING AND MIDWIFERY RESULTS  IN SEMESTER II';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm1,'status'=>'Wait for Approval'])->exists();

}
if ($title=='nursing_21'){
    $student_tittle='NTA 5 NURSING AND MIDWIFERY RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm2,'status'=>'Wait for Approval'])->exists();

}
if ($title=='nursing_22'){
    $student_tittle='NTA 5 NURSING AND MIDWIFERY RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm2,'status'=>'Wait for Approval'])->exists();

}
if ($title=='nursing_31'){
    $student_tittle='NTA 6 NURSING AND MIDWIFERY RESULTS  IN SEMESTER I';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm3,'status'=>'Wait for Approval'])->exists();

}
if ($title=='nursing_32'){
    $student_tittle='NTA 6 NURSING AND MIDWIFERY RESULTS  IN SEMESTER II';
    $exam_results_exists= ExamResult::find()->where(['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,
    'course_id'=>$nm3,'status'=>'Wait for Approval'])->exists();

}




$this->title ='RESULTS';
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
\yiister\adminlte\widgets\Box::begin(["type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,]) ?>


<?php
if (UserAccount::userHas(['HOD','EO','ADMIN']) && $exam_results_exists){
?>
<p>
    <?= Html::a('<span class="fa fa-check-square-o">APPROVE RESULTS</span>', ['/exam-result/approve','authorization'=>$title], [
        'class' => 'btn btn-success pull-right',
        'data' => [
            'confirm' => 'Are you sure you want to Approve  these Results?</br>Please! Be carefully the process is IRREVERSIBLE',
            'method' => 'post',
        ],
    ]) ?>
</p>
<?php }?>


<div class="exam-result-index">

    <?php
    $gridColumns = [
        ['attribute'=>'student_id','value'=>function($model){
            return $model->student->registration_number;},'label'=>'Registration Number',
            ],

        ['attribute'=>'student_id','value'=>function($model){
            return $model->student->fname.' '.$model->student->lname;},'filter'=>ArrayHelper::map(\common\models\Student::find()->asArray()->all(), 'id', 'lname'),],
        ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
            'filter'=>ArrayHelper::map(Module::find()->asArray()->all(), 'id', 'module_name'),
        ],
        'coursework',
        'final_exam_score',
        'total_score',

        ['attribute'=>'grade_id','value'=>function($model){
            return $model->grade->grade;},'label'=>'Grade'],
        'remarks',
        'status'
    ];

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'showConfirmAlert'=>true,
        'filename'=> 'KCOHAS-Examination Results',
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_EXCEL => false,
        ],
    ]);
?>


    <?php

    echo \kartik\grid\GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>true,
            'target'=>\kartik\grid\GridView::TARGET_BLANK,
        ],

        'columns' => $gridColumns,
        'pjax'=>true,
       // 'caption'=>'RESULTS',
        'floatHeader' => false,
        'showPageSummary'=>false,

        'panel'=>[
            'type'=>'primary',
            'heading'=>$student_tittle,
        ]
    ]);

    ?>

</div>



