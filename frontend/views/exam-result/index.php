<?php

use common\models\AcademicYear;
use common\models\CourseworkNta4;
use common\models\ExamResult;
use common\models\FinalExam;
use common\models\GpaClass;
use common\models\Module;
use common\models\Payment;
use common\models\Semester;
use common\models\Student;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseworkNta4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */


$title=Yii::$app->request->get('year');

if ($title=='year_1'){
    $student_tittle=' FIRST RESULTS';
    $year='First Year';
    $nta='4';
}
if ($title=='year_2'){
    $student_tittle=' SECOND YEAR RESULTS';
    $year='Second Year';
    $nta='5';
}
if ($title=='year_3'){
    $student_tittle=' THIRD YEAR RESULTS';
    $year='Third Year';
    $nta='6';
}

$year_of_study=\common\models\YearOfStudy::find()->where(['name'=>$year])->one()->id;

$this->params['breadcrumbs'][] = $this->title;
?>
<br>

<style> .badge-success{ background :#43A047; } .badge-danger{ background:#D50000;}
</style>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>


<?php
$active_semester=Semester::find()->where(['status'=>'Active'])->one()->id;
$second_semister=Semester::find()->where(['name'=>'II'])->one()->id;
$model=Student::find()->where(['id'=>Yii::$app->user->identity->user_id])->one();
$paid= Payment::find()->where(['student_id'=>$model->id,'academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$active_semester,'status'=>'Paid'])->exists();
if($paid){
?>

<div  style="font-family: 'Bell MT';color: whitesmoke;">

    <?php \yiister\adminlte\widgets\Callout::begin(["type" => \yiister\adminlte\widgets\Callout::TYPE_INFO]); ?>
    <?php
    //CALCULATING COMMULATIVE GPA
    $student_total_points_status=ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'course_id'=>$model->course_id,'status'=>'Released'])->exists();
    $student_total_points=ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'course_id'=>$model->course_id,'status'=>'Released'])->sum('points');


    $cur_semester=Semester::find()->where(['status'=>'Active'])->one();
    $second_result_available=ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'course_id'=>$model->course_id,'status'=>'Released','semester_id'=>$second_semister])->exists();

    if($cur_semester->name=='I'){
        $student_total_credits= Module::find()->where(['course_id'=>$model->course_id,'semester_id'=>$active_semester])->sum('module_credit');
    }
    elseif($cur_semester->name=='II' && $second_result_available){
        $student_total_credits= Module::find()->where(['course_id'=>$model->course_id])->sum('module_credit');

    }


    $overall_gpa=!empty($student_total_credits)?bcdiv($student_total_points/$student_total_credits, '1', $precision = 1):'';



    //    //SWITCHING GPA
    $gpa_class='';
    $remarks='';

    if($year=='First Year' || $year=='Second Year'){
        $first_class_lower = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'FIRST CLASS'])->one()->starting_point;
        $first_class_upper = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'FIRST CLASS'])->one()->end_point;
        $second_class_lower = GpaClass::find()->where(['nta_level' => $nta,  'gpa_class' => 'SECOND CLASS'])->one()->starting_point;
        $second_class_upper = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'SECOND CLASS'])->one()->end_point;
        $pass_class_lower = GpaClass::find()->where(['nta_level' =>$nta, 'gpa_class' => 'PASS'])->one()->starting_point;
        $pass_class_upper = GpaClass::find()->where([ 'nta_level' => $nta,'gpa_class' =>'PASS'])->one()->end_point;

        //SWITCHING CASE FOR GRADE
        switch ($overall_gpa) {
            case (($overall_gpa== $first_class_lower || $overall_gpa > $first_class_lower) && ($overall_gpa == $first_class_upper || $overall_gpa < $first_class_upper)):
                $gpa_class='FIRST CLASS';
                break;

            case (($overall_gpa== $second_class_lower || $overall_gpa > $second_class_lower) && ($overall_gpa == $second_class_upper || $overall_gpa < $second_class_upper)):
                $gpa_class='SECOND CLASS';
                break;

            case (($overall_gpa== $pass_class_lower || $overall_gpa > $pass_class_lower) && ($overall_gpa == $pass_class_upper || $overall_gpa < $pass_class_upper)):
                $gpa_class='PASS CLASS';
                break;

            default:
                $gpa_class='INC';
                break;

        }
    }

    if( $year=='Third Year'){
        $first_class_lower = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'FIRST CLASS'])->one()->starting_point;
        $first_class_upper = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'FIRST CLASS'])->one()->end_point;
        $upper_second_class_lower = GpaClass::find()->where(['nta_level' => $nta,  'gpa_class' => 'UPPER SECOND CLASS'])->one()->starting_point;
        $upper_second_class_upper = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'UPPER SECOND CLASS'])->one()->end_point;
        $second_class_lower = GpaClass::find()->where(['nta_level' => $nta,  'gpa_class' => 'LOWER SECOND CLASS'])->one()->starting_point;
        $second_class_upper = GpaClass::find()->where([ 'nta_level' => $nta, 'gpa_class' => 'LOWER SECOND CLASS'])->one()->end_point;
        $pass_class_lower = GpaClass::find()->where(['nta_level' =>$nta, 'gpa_class' => 'PASS'])->one()->starting_point;
        $pass_class_upper = GpaClass::find()->where([ 'nta_level' => $nta,'gpa_class' =>'PASS'])->one()->end_point;

        //SWITCHING CASE FOR GRADE
        switch ($overall_gpa) {
            case (($overall_gpa== $first_class_lower || $overall_gpa > $first_class_lower) && ($overall_gpa == $first_class_upper || $overall_gpa < $first_class_upper)):
                $gpa_class='FIRST CLASS';

                break;

            case (($overall_gpa== $upper_second_class_lower || $overall_gpa > $upper_second_class_lower) && ($overall_gpa == $upper_second_class_upper || $overall_gpa < $upper_second_class_upper)):
                $gpa_class='UPPER SECOND CLASS';

                break;

            case (($overall_gpa== $second_class_lower || $overall_gpa > $second_class_lower) && ($overall_gpa == $second_class_upper || $overall_gpa < $second_class_upper)):
                $gpa_class='LOWER SECOND CLASS';
                break;

            case (($overall_gpa== $pass_class_lower || $overall_gpa > $pass_class_lower) && ($overall_gpa == $pass_class_upper || $overall_gpa < $pass_class_upper)):
                $gpa_class='PASS CLASS';
                break;


        }
    }
    ?>

    <?php
    $semester_1=Semester::find()->where(['name'=>'I'])->one()->id;
    $sup_dataProvider = new ActiveDataProvider(['query'=> FinalExam::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_1,'course_id'=>$model->course_id])]);

    $total_sup = 0;

    foreach($sup_dataProvider->models as $m)
    {

        if ($m->written_exam<50 || ($m->practical<50 && $m->practical!=0) ){
            $total_sup++;
        }

    }

    if ($total_sup>3 && $overall_gpa>1.9){
        $remarks='REPEAT MODULE(S)';
    }
    elseif ($overall_gpa<2){
        $remarks='DISCONTINUED';
    }
    elseif($total_sup>0 && $total_sup<4){
        $remarks='SUP';
    }
    else{
        $remarks='PASS';
    }


    ?>


    <h4 style="font-family: 'Bell MT';text-align: center"><?php echo strtoupper( 'NTA '.$nta);?> COURSE RESULTS</h4>
    <h5>RESULTS SUMMARY</h5>
    <h5>GPA: <?= '<b style="color: black">'.$overall_gpa.'</b>';?></h5>
    <h5>GPA CLASS: <?= '<b style="color: black">'.$gpa_class.'</b>';?></h5>
    <h5>REMARKS: <?= '<b style="color: black">'.$remarks.'</b>';?></h5>




    <?php \yiister\adminlte\widgets\Callout::end(); ?>


</div>


<h4  style="font-weight: bold;font-family: 'Bell MT';color: black;">SEMESTER I </h4>

<?php
$dataProvider = new ActiveDataProvider(['query'=> ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_1,'course_id'=>$model->course_id,'status'=>'Released'])]);

$total_points = 0;

foreach($dataProvider->models as $m)
{

    $total_points +=$m->points;

}


$total_credits = 0;

foreach($dataProvider->models as $m)
{

    $total_credits +=$m->module->module_credit;

}










?>
<div class="table-responsive">

    <?php echo

    GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter'=>true,
        'footerRowOptions'=>['style'=>'font-weight:bold;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_code;},
                'headerOptions' => [ 'style' => 'color:#66a3ff'],'label'=>'Module Code'],

            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                'filter'=>ArrayHelper::map(Module::find()->asArray()->all(), 'id', 'module_name'),'headerOptions' => [ 'style' => 'color:#66a3ff']],

            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_credit;},'label'=>'Credits',
                'headerOptions' => [ 'style' => 'color:#66a3ff'], 'footer' =>$total_credits],

            'coursework',
            ['attribute'=>'final_exam_id','format'=>'html','value'=>function($model){

                if ($model->finalExam->written_exam<50){
                    return '<span class="badge badge-danger" style="width: 90px">'.$model->finalExam->written_exam.'</span>';
                }
                else{
                    return $model->finalExam->written_exam;
                }


            },'label'=>'Semester Exam Theory'],


            ['attribute'=>'final_exam_id','format'=>'html','value'=>function($model){


                if ($model->finalExam->practical<50 && $model->finalExam->practical!=0 ){
                    return '<span class="badge badge-danger" style="width: 90px">'.$model->finalExam->practical.'</span>';
                }
                else{
                    return $model->finalExam->practical;
                }
            },'label'=>'Semester Exam Practical'],
            'total_score',


            ['attribute'=>'grade_id','value'=>function($model){return $model->grade->grade;},'label'=>'Grade'],



            ['attribute'=>'points','value'=>function($model){
                return $model->points;}, 'footer' =>$total_points],




            ['attribute'=>'remarks','format'=>'html','value'=>function($model){

                $semester_1=Semester::find()->where(['name'=>'I'])->one()->id;

                $dataProvider = new ActiveDataProvider(['query'=> ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_1,'course_id'=>$model->course_id,'status'=>'Released'])]);

                $total_points = 0;

                foreach($dataProvider->models as $m)
                {

                    $total_points +=$m->points;

                }


                $total_credits = 0;

                foreach($dataProvider->models as $m)
                {

                    $total_credits +=$m->module->module_credit;

                }
                $overall_gpa=bcdiv($total_points/$total_credits, '1', $precision = 1);


                $sup_dataProvider = new ActiveDataProvider(['query'=> FinalExam::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_1,'course_id'=>$model->course_id])]);

                $total_sup = 0;

                foreach($sup_dataProvider->models as $m)
                {

                    if ($m->written_exam<50 || ($m->practical<50 && $m->practical!=0) ){
                        $total_sup++;
                    }

                }



                if ($overall_gpa<2.0 && ($model->finalExam->written_exam <50 ||($model->finalExam->practical<50 && $model->finalExam->practical!=0))){
                    return '<span class="badge badge-danger" style="width: 150px"> FAILED</span>';
                }

                if ($total_sup>3 && ($model->finalExam->written_exam <50 ||($model->finalExam->practical<50 && $model->finalExam->practical!=0))){
                    return '<span class="badge badge-danger" style="width: 150px"> REPEAT MODULE</span>';
                }

                elseif($model->finalExam->written_exam <50 ||($model->finalExam->practical<50 && $model->finalExam->practical!=0) ){
                    return '<span class="badge badge-danger" style="width: 90px"> SUP</span>';
                }
                else{
                    return 'PASS';
                }



            },'label'=>'REMARKS','headerOptions' => [ 'style' => 'color:red']],



            ['attribute'=>'points','value'=>function(){
                return '';
            },'label'=>'Semester GPA','headerOptions' => [ 'style' => 'color:red'], 'footer' =>!empty($total_credits)?bcdiv($total_points/$total_credits, '1', $precision = 1):'']


        ],
    ]); ?>


    <br>
    <h4  style="font-weight: bold;font-family: 'Bell MT';color: black;">SEMESTER II </h4>

    <?php
    $semester_2=Semester::find()->where(['name'=>'II'])->one()->id;
    $dataProvider = new ActiveDataProvider(['query'=>ExamResult::find()->where(['student_id'=>Yii::$app->user->identity->user_id,'semester_id'=>$semester_2,'course_id'=>$model->id,'status'=>'Released'])]);
    $total_points = 0;

    foreach($dataProvider->models as $m)
    {

        $total_points +=$m->points;

    }


    $total_credits = 0;

    foreach($dataProvider->models as $m)
    {

        $total_credits +=$m->module->module_credit;

    }
    ?>

    <div class="table-responsive">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'showFooter'=>true,
            'footerRowOptions'=>['style'=>'font-weight:bold;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_code;},
                    'headerOptions' => [ 'style' => 'color:#66a3ff'],'label'=>'Module Code'],

                ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;},
                    'filter'=>ArrayHelper::map(Module::find()->asArray()->all(), 'id', 'module_name'),'headerOptions' => [ 'style' => 'color:#66a3ff']],

                ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_credit;},'label'=>'Credits',
                    'headerOptions' => [ 'style' => 'color:#66a3ff'], 'footer' =>$total_credits],

                ['attribute'=>'coursework','value'=>function($model){ return $model->coursework;},'label'=>'Coursework',
                    'headerOptions' => [ 'style' => 'color:#66a3ff']],

                ['attribute'=>'final_exam_id','value'=>function($model){return $model->finalExam->written_exam;},'label'=>'Semester Exam Theory', 'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'final_exam_id','value'=>function($model){return $model->finalExam->practical;},'label'=>'Semester Exam Practical', 'headerOptions' => [ 'style' => 'color:#66a3ff']],
                'total_score',


                ['attribute'=>'grade_id','value'=>function($model){return $model->grade->grade;},'label'=>'Grade', 'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'points','value'=>function($model){
                    return $model->points;},  'headerOptions' => [ 'style' => 'color:#66a3ff'],'footer' =>$total_points],

                ['attribute'=>'remarks','value'=>'remarks','label'=>'REMARKS', 'headerOptions' => [ 'style' => 'color:#66a3ff']],
                ['attribute'=>'points','value'=>function(){
                    return '';
                },'label'=>'Semester GPA', 'headerOptions' => [ 'style' => 'color:#66a3ff'], 'footer' =>!empty($total_credits)?Yii::$app->formatter->asDecimal($total_points/$total_credits,1):'']


            ],
        ]); ?>

    </div>

    <?php
    }
    else{

        echo " <h4 class='btn-danger' style='font-family: Tahoma;text-align: center'> Please Complete your payment for this Semester First, So as you can access your Results</h4>";

    }

    ?>
