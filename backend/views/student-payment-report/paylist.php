
<?php
use common\models\Course;
use common\models\Semester;
use common\models\Student;
?>

<div>

    <div class="col-sm-12" align="center">
        <img src="images/logo.png" width="80px" align="center" class="img-flag">
        <h5 style="color: purple; font-family: Cambria; text-align: center">
            KABANGA COLLEGE OF HEALTH AND ALLIED SCIENCES
        </h5>
        <h6 style="font-family: Cambria; text-align: center;color: purple">
            P.O BOX 42, KASULU, KIGOMA ,TANZANIA
        </h6>
    </div>
<br>

    <h5 style="font-family: Cambria; text-align: center"> <?= Course::findOne(['id'=>$model->course_id])->course_name .' '?> STUDENTS WHO HAS <?php echo strtoupper($model->status).' FOR SEMESTER'.' '.Semester::findOne(['id'=>$model->semester_id])->name?><br><?php echo  'Date :'.date_format(new DateTime($model->created_at), "F j, Y")?> </h5>





</div>
<br>
<?php
?>


<br>
<table class="table table-bordered" style="border:1px solid black ;border-collapse: collapse; width: 100%">
    <tr style="border:1px solid black;">
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">S/NO. </td>
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">STUDENT NAME</td>

    </tr>

    <?php
    $n=1;
    $total=0;
    foreach ($student as $st){

        if ($model->status=='Paid'){
            $student_details=Student::findOne(['id'=>$st['student_id']]);
        }
        else{
            $student_details=Student::findOne(['id'=>$st['id']]);
        }

    ?>
    <tr style="border:1px solid black;">
        <td colspan="3" style="border:1px solid purple;"><?= $n++?></td>
        <td colspan="3" style="border:1px solid purple;"><?= $student_details->fname.' '.$student_details->lname?></td>

    </tr>

<?php }?>

</table>

<div style="flex-direction: row;">

    <table style="width:100%">


    </table>





</div>