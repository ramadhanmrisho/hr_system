<?php

use common\models\CourseworkNta5;
use common\models\ExamResult;
use common\models\Grade;
use common\models\Module;
use common\models\Student;
use yii\helpers\Html;

//$final_results_count=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();



?>

<a class="btn-sm btn-success" href="#" onclick="printContent(this)">
    <span class="glyphicon glyphicon-print"></span> Print
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

    <div align="center">
        <img class="img-circle" src="images/logo.png" width="70px" >
    </div>
    <div class="col-md-12" align="center">
        <h5 style="color: purple;font-family: Cambria;text-align: center">
            KABANGA COLLEGE OF HEALTH AND ALLIED SCIENCES
        </h5>
        <h6 style="color: black;font-family:Cambria;text-align: center">
            <b>OVERALL COURSEWORKS SUMMARY<br>
                <b>COURSE : <b style="color: dodgerblue"><?php echo \common\models\Course::find()->where(['id'=>$model->course_id])->one()->course_name;?></b>
        </h6>
        <table class="table table-bordered" style="border:1px solid black; width: 100%;font-size:x-small">
            <tr>
                <td style="font-family: Cambria;font-size:x-small"><b>ACADEMIC YEAR: <b style="color: dodgerblue"><?php echo \common\models\AcademicYear::find()->where(['id'=>$model->academic_year_id])->one()->name;?></b></td>
                <td style="font-family: Cambria;font-size:x-small"><b>NTA LEVEL: <b style="color: dodgerblue"><?php echo  '5'?></b></td>
                <td style="font-family: Cambria;font-size:x-small" ><b>INTAKE : <b style="color: dodgerblue">September</b></td>
                <td style="font-family: Cambria;font-size:x-small"><b>SEMESTER : <b style="color: dodgerblue"><?php echo \common\models\Semester::find()->where(['id'=>$model->semester_id])->one()->name; ?></b></td>
            </tr>
        </table>

        <table class="table table-bordered" style="border:2px solid black; width: 100%;font-size:x-small;padding: 0">
            <tr style="font-family: Cambria; text-align: center;font-weight:40%; padding:0">
                <td style="border:1px solid black;">SN</td>
                <td style="border:1px solid black;text-align: center">Full Name</td>
                <td style="border:1px solid black;text-align: center">Registration Number</td>

                <?php foreach($student_modules as $module){
                    ?>
                    <td  style="border:1px solid black; padding: 0">
                        <table class="table table-bordered" style="border:2px ; width: 100%; padding: 0">
                            <tr>
                                <td colspan="8" style="border:1px ;text-align: center" >
                                    <?php
                                    echo  Module::find()->where(['id'=>$module['module_id']])->one()->module_code;
                                    ?>
                                </td>
                            </tr style="border:1px solid black;">
                            <tr style="padding-left: unset">
                                <td style="border-bottom:1px solid black;border-right: 1px solid black ;border-top:1px solid black ;width:50px">CAT 1</td>
                                <td style="border:1px solid black; width:50px">CAT 2</td>
                                <td style="border:1px solid black; width:50px">ASS 1</td>
                                <td style="border:1px solid black; width:50px">ASS 2</td>
                                <td style="border:1px solid black; width:50px">OSCE</td>
                                <td style="border:1px solid black; width:50px">PPB</td>
                                <td style="border:1px solid black; width:50px">Portifolio</td>
                                <td style="border:1px solid black; width:50px">Total</td>
                                <td style="border-bottom:1px solid black;border-top:1px solid black ;width:50px">Remarks</td>
                            </tr>
                        </table>
                    </td>
                    <?php
                }?>


            </tr>

            <?php
            $student_results= CourseworkNta5::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->all();
            $counter=CourseworkNta5::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();


            $x=1;
            foreach ($student_results as $st){

                $student_subjects=CourseworkNta5::find()->where(['student_id'=>$st['student_id'],'academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->orderby(['created_at' => SORT_DESC])->all();

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

                    foreach($student_subjects as $subject){?>

                        <td  style="border:1px solid black;padding: 0">
                            <table class="table" style="border:2px ; padding: 0">
                                <tr style="padding-left:0">
                                    <td style="border-bottom:1px solid black;border-top:1px solid black ;width:50px"><?= $subject['cat_1']?></td>
                                    <td style="border:1px solid black; width: 50px "><?= $subject['cat_2']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['assignment_1']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['assignment_2']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['practical']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['ppb']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['practical_2']?></td>
                                    <td style="border:1px solid black; width: 50px"><?= $subject['total_score']?></td>
                                    <td style="border-bottom:1px solid black;border-top:1px solid black ;width:50px"><?= $subject['remarks']?></td>
                                </tr>
                            </table>
                        </td>


                    <?php }

                    ?>
                </tr>
            <?php }


            ?>

        </table>

    </div>
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


