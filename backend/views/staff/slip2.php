
<div style="font-family: Lucida Bright">


    <div>

        <div class="col-sm-12" >
            <h5 style="color: dodgerblue;font-family: Lucida Bright">
                HR MIS & Payroll System
            </h5>
            <h6 style="">
                P.O BOX 33, Ubungo, Dar es Salaam ,Tanzania
            </h6>
            <!--        <img src="images/pay.jpeg" width="80px" align="left" class="img-circle">-->

        </div>
    </div>
    <br>
    <?php
    ?>

    <table class="table table-bordered" style="border:1px solid black ;font-family:Lucida Bright;border-collapse: collapse; width: 100%">
        <tr style="border:1px solid black;">
            <td colspan="3" style="font-weight: bold;border:1px solid white;">Payslip</td>
            <td  style ="text-align: right"><?php echo $month;?></td>
        </tr>

        <tr  style="border:1px solid black;">
            <td style="border:1px solid black;"  colspan="2" >Employee Name: <?php echo $staff?> <br> <br>Employee Number: <?php echo $staff_number?> <br><br>Employment Date:<?php echo $date_joining?></td>
            <td  style="border:1px solid black;" colspan="2">Department: <?php echo $department?> <br><br>Account Name: <?php echo $account_name ?><br><br> Account Number:<?php echo $account_number ?></td>
        </tr>

        <tr  style="border:1px solid black;">
            <td style="border:1px solid black;"><br>Earnings:</td>
            <td style="border:1px solid black;"><br>Credited(Tsh)</td>
            <td style="border:1px solid black;"><br>Deductions</td>
            <td style="border:1px solid black;"><br>Deducted(Tsh)</td>
        </tr>

        <!--    <tr style="border:1px solid black;">-->
        <!--        <td   style="border:1px solid black;"> Basic Salary <br><br>--><?php //if($hod_allowance_amount==0){echo  '';}else{echo 'HOD Allowance'; }?><!--<br><br>--><?php //if($transport_allowance_amount==0){echo  '';}else{echo 'Transport Allowance'; }?><!-- <br><br>--><?php // if($house_allowance_amount==0){echo  '';}else{echo 'House Allowance'; }?><!--<br>--><?php // if($teaching_allowance_amount==0){echo  '';}else{echo 'Teaching Allowance'; }?><!--<br><br>--><?php // if($cooking_allowance_amount==0){echo  '';}else{echo 'Cook  Allowance'; }?><!--<br><br>--><?php // if($driver_allowance_amount==0){echo  '';}else{echo 'Driver  Allowance'; }?><!--<br><br><b> Total Earnings</td>-->
        <!--        <td style="border:1px solid black;">--><?php //echo ' '. $basic_salary.'  '?><!--<br><br>--><?php //if ( $hod_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($hod_allowance_amount,2);}?><!--<br><br>--><?php //if ( $transport_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($transport_allowance_amount,2);}?><!--<br><br>--><?php //if ( $house_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($house_allowance_amount,2);}?><!--<br>--><?php //if ( $teaching_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($teaching_allowance_amount,2);}?><!--<br><br>--><?php //if ($cooking_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($cooking_allowance_amount,2);}?><!--<br><br>--><?php //if ($driver_allowance_amount==0){echo ' ';}else{ echo Yii::$app->formatter->asDecimal($driver_allowance_amount,2);}?><!--<br><br>--><?php //echo '<b>'.Yii::$app->formatter->asDecimal($total_earnings,2).'  '?><!--</td>-->
        <!---->
        <!--        <td style="border:1px solid black;"> NHIF<br><br> NSSF<br><br> PAYE<br><br>HESLB<br><br><b> Total Deductions</td>-->
        <!--        <td style="border:1px solid black;">--><?php //echo $nhif;?><!--<br><br>--><?php //echo  !empty($nssf)? $nssf:0?><!--<br><br>--><?php //echo  $paye;?><!--<br><br>--><?php //echo $helsb!=0? $helsb:0?><!--<br><br>--><?php //echo '<b>'.Yii::$app->formatter->asDecimal($total_deduction,2)?><!--</td>-->
        <!--    </tr>-->
        <!---->
        <!--    <tr   style="border:1px solid black;">-->
        <!--        <td colspan="4" rowspan="1">-->
        <!--            <b>Net Salary --><?php //echo '<b>'. Yii::$app->formatter->asDecimal($total_earnings- $total_deduction,2)?>
        <!--        </td>-->
        <!--    </tr>-->


    </table>
</div>