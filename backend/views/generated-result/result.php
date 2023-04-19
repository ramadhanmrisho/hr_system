<?php

use common\models\ExamResult;
use common\models\FinalExam;
use common\models\Grade;
use common\models\Module;
use common\models\Student;
use yii\helpers\Html;

//$final_results_count=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();



?>
<style> .badge-success{ background :#43A047; } .badge-danger{ background:#D50000;}
</style>

<a class="btn btn-success" href="#" onclick="printContent(this)">
    <span class="glyphicon glyphicon-print"> </span> Print
</a>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        div.scrollmenu {
            overflow: auto;
            white-space: nowrap;
        }

        div.scrollmenu a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }

        div.scrollmenu a:hover {
            background-color: #777;
        }
    </style>
</head>

<div class="scrollmenu to-print">
    <div class="">
        <div class="">
            <div align="center">
                <img class="img-circle" src="images/logo.png" width="70px" >
            </div>
            <div class="col-md-12" align="center">
                <h5 style="color: purple;font-family: Cambria;text-align: center">
                    KABANGA COLLEGE OF HEALTH AND ALLIED SCIENCES
                </h5>
                <h6 style="color: black;font-family:Cambria;text-align: center">
                    <b>OVERALL RESULTS SUMMARY<br>
                        <b>COURSE : <b style="color: dodgerblue"><?php echo \common\models\Course::find()->where(['id'=>$model->course_id])->one()->course_name;?></b>
                </h6>
                <table class="table table-bordered" style="border:1px solid black; width: 100%;font-size:x-small">
                    <tr>
                        <td style="font-family: Cambria;font-size:x-small"><b>ACADEMIC YEAR: <b style="color: dodgerblue"><?php echo \common\models\AcademicYear::find()->where(['id'=>$model->academic_year_id])->one()->name;?></b></td>
                        <td style="font-family: Cambria;font-size:x-small"><b>NTA LEVEL: <b style="color: dodgerblue"><?php echo  $model->nta_level?></b></td>
                        <td style="font-family: Cambria;font-size:x-small" ><b>INTAKE : <b style="color: dodgerblue">September</b></td>
                        <td style="font-family: Cambria;font-size:x-small"><b>SEMESTER : <b style="color: dodgerblue"><?php echo \common\models\Semester::find()->where(['id'=>$model->semester_id])->one()->name; ?></b></td>
                    </tr>
                </table>

                <table class="table table-bordered" style="border:2px solid black; width: 100%;font-size:x-small">
                    <tr style="font-family: Cambria; text-align: center;font-weight:40%; padding-bottom:0">
                        <td style="border:1px solid black;">SN</td>
                        <td style="border:1px solid black;text-align: center">Full Name</td>
                        <td style="border:1px solid black;text-align: center">Registration Number</td>

                        <?php foreach($student_modules as $module){
                            ?>
                            <td  style="border:1px solid black;padding: 0">
                                <table class="table table-bordered" style="border:2px ; width: 100%; padding: 0">
                                    <tr>
                                        <td colspan="4" style="border:1px ;text-align: center" >
                                            <?php
                                            echo  Module::find()->where(['id'=>$module['module_id']])->one()->module_code;
                                            ?>
                                        </td>
                                    </tr style="border:1px solid black;">
                                    <tr style="padding-left: unset">
                                        <td style="border-bottom:1px solid black;border-right: 1px solid black ;border-top:1px solid black ;width:50px">CA</td>
                                        <td style="border:1px solid black; width:50px">SE</td>
                                        <td style="border:1px solid black; width:50px">Total</td>
                                        <td style="border-bottom:1px solid black;border-top:1px solid black ;width:50px">Grade</td>
                                    </tr>
                                </table>
                            </td>
                            <?php
                        }?>



                        <td style="border:1px solid black;">GPA</td>
                        <td style="border:1px solid black;">GPA CLASS</td>
                        <td style="border:1px solid black;">Remarks</td>
                    </tr>

                    <?php
                    $student_results=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->all();
                    $counter=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();


                    $x=1;
                    foreach ($student_results as $st){

                        $student_subjects=ExamResult::find()->where(['student_id'=>$st['student_id'],'academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->orderby(['created_at' => SORT_DESC])->all();


                        ?>
                        <tr  style="font-family: Cambria;">
                            <td style="border:1px solid black;">
                                <?php

                                echo $x++.'.';
                                ?>
                            </td>
                            <td style="border:1px solid black;"><?php $student=Student::find()->where(['id'=>$st['student_id']])->one();
                                if(!empty($student->mname)){
                                    $m=$student->mname;
                                }
                                else{$m=' ';}
                                echo $student->fname.' '.$m.' '. $student->lname?></td>
                            <td style="border:1px solid black; text-align: center"><?php echo Student::find()->where(['id'=>$st['student_id']])->one()->registration_number?></td>


                            <?php
                            $sum=0;
                            $sum_of_pn=0;
                            $sup=0;
                            foreach($student_subjects as $subject){?>

                                <td  style="border:1px solid black;padding: 0">
                                    <table class="table" style="border:2px ; padding: 0">
                                        <tr style="padding-left: unset">
                                            <td style="border-right:1px solid black;border-bottom:1px solid black; ;width:50px"><?= $subject['coursework']?></td>
                                            <td style="border-right:1px solid black; border-bottom:1px solid black;width: 50px"><?= $subject['final_exam_score']?></td>
                                            <td style="border-right:1px solid black; border-bottom:1px solid black; width: 50px"><?= $subject['total_score']?></td>
                                            <td style="border-bottom:1px solid black ;width:50px"><?= Grade::find()->where(['id'=>$subject['grade_id']])->one()->grade;?></td>
                                        </tr>
                                    </table>
                                </td>
                                <?php
                                // GPA COMPUTATION 10-10-2021
                                $grade_pint=Grade::find()->where(['id'=>$subject['grade_id']])->one()->point;

                                $module_credit= Module::find()->where(['id'=>$subject['module_id']])->one()->module_credit;



                                $sum=$grade_pint*$module_credit;

                                $sum_of_pn+=$sum;
                                $gpa_value=$sum_of_pn/$sum_of_n;
                                $gpa=bcdiv($gpa_value, '1', $precision = 1);


                                if($model->nta_level=='4' || $model->nta_level=='5'){
                                    switch ($gpa){
                                        case(($gpa==$first_class_start ||$gpa>$first_class_start)&& ($gpa==$first_class_end ||$gpa<$first_class_end)):
                                            $gpa_class='FIRST CLASS';
                                            break;
                                        case(($gpa==$second_class_start || $gpa>$second_class_start)&& ($gpa==$second_class_end ||$gpa <$second_class_end)):
                                            $gpa_class='SECOND CLASS';
                                            break;
                                        case(($gpa==$pass_class_start ||$gpa>$pass_class_start)&& ($gpa==$pass_class_end ||$gpa<$pass_class_end)):
                                            $gpa_class='PASS';
                                            break;
                                        default:
                                            $gpa_class='INC';
                                            break;
                                    }
                                }

                                if($model->nta_level=='6'){
                                    switch ($gpa){
                                        case(($gpa==$first_class_start ||$gpa>$first_class_start)&& ($gpa==$first_class_end ||$gpa<$first_class_end)):
                                            $gpa_class='FIRST CLASS';
                                            break;

                                        case(($gpa==$uppersecond_class_start || $gpa>$uppersecond_class_start)&& ($gpa==$uppersecond_class_end ||$gpa <$uppersecond_class_end)):
                                            $gpa_class='UPPER SECOND CLASS';
                                            break;

                                        case(($gpa==$lowersecond_class_start || $gpa>$lowersecond_class_start)&& ($gpa==$lowersecond_class_end ||$gpa <$lowersecond_class_end)):
                                            $gpa_class='LOWER SECOND CLASS';
                                            break;

                                        case(($gpa==$pass_class_start ||$gpa>$pass_class_start)&& ($gpa==$pass_class_end ||$gpa<$pass_class_end)):
                                            $gpa_class='PASS';
                                            break;
                                        default:
                                            $gpa_class='INC';
                                            break;
                                    }
                                }

                                ?>


                                <?php

                                $student_sup_results= FinalExam::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id,'module_id'=>$subject['module_id'],'student_id'=>$st['student_id']])->one();


                                if($student_sup_results->written_exam <50 || ($student_sup_results->practical <50 && $student_sup_results->practical!=0) ){
                                   $sup++;
                                    //$remarks='<span class="badge badge-danger" >SUPPLEMENT</span>';
                                }




//                                if($gpa<2){
//                                    $remarks='<span class="badge badge-danger" >DISCONTINUED</span>';
//                                }
                                if ($sup>0 && $sup<3){
                                    $remarks='<span class="badge badge-danger" >SUPPLEMENT</span>';
                                }
                                elseif($sup>3 && $gpa>2.0){
                                    $remarks='<span class="badge badge-danger" >REPEAT MODULES</span>';
                                }
                                elseif($gpa<2.0){
                                    $remarks='<span class="badge badge-danger" >DISCONTINUED</span>';
                                }
                                elseif ($sup==0){
                                    $remarks='PASS';
                                }
                                else{
                                    $remarks='<span class="badge badge-danger" >REPEAT MODULES</span>';
                                }





                                ?>



                            <?php }



                            ?>

                            <td style="border:1px solid black; font-weight: bold"><?php echo $gpa?></td>
                            <td style="border:1px solid black; font-weight: bold"><?php echo $gpa_class?></td>
                            <td style="border:1px solid black; font-weight: bold"><?php echo $remarks?></td>
                        </tr>
                    <?php }


                    ?>

                </table>

            </div>
        </div>
    </div>



</div>
<br>
<div>
    <h6> <b style="color: dodgerblue;font-family: Cambria">STATISTICAL RESULTS SUMMARY</b></h6>

    <table class="table table-bordered" style="border:2px solid black; width: 100%;font-size:x-small">
        <tr style="font-family: Cambria; text-align: center;font-weight:40%; padding-bottom:0">

            <td style="border:1px solid black;text-align: center">GRADE</td>


            <?php foreach($student_modules as $module){
                ?>
                <td style="border:1px solid black;text-align: center" >
                    <?php
                    echo  Module::find()->where(['id'=>$module['module_id']])->one()->module_code;
                    ?>
                </td>
                <?php
            }?>

        </tr>

        <?php
        $all_grades=Grade::find()->where(['nta_level'=>$model->nta_level])->groupBy(['grade'])->orderBy(['point'=>SORT_DESC])->all();

        //$student_results=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['grade_id'])->all();
        $counter=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();



        foreach ($all_grades as $st){

            $student_subjects=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->orderby(['created_at' => SORT_DESC])->all();

            ?>
            <tr  style="font-family: Cambria;">

                <td style="border:1px solid black;"><?php

                    echo $st->grade?>
                </td>
                <?php foreach($student_modules as $module){
                    ?>
                    <td style="border:1px solid black;text-align: center" >
                        <?php
                        $grade_id=Grade::find()->where(['grade'=>$st->grade,'nta_level'=>$model->nta_level])->one()->id;
                        echo ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id,'module_id'=>$module->module_id,'grade_id'=>$grade_id])->orderby(['created_at' => SORT_DESC])->count();
                        ?>
                    </td>
                    <?php
                }?>


            </tr>
        <?php }


        ?>

    </table>


</div>






<script type="application/javascript">
    printContent = (e) => {
        var newWindow = window.open();

        var doc = newWindow.document;
        doc.write("<html><head>");
        doc.write(document.head.innerHTML);
        doc.write("</head><body>");
        doc.write(document.getElementsByClassName("to-print")[0].innerHTML);
        doc.write("</body></html>");
        doc.close();

        newWindow.print();
    }
</script>


