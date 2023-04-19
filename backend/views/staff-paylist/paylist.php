

<div>

    <div class="col-sm-12" align="center">
        <img src="images/logo.png" width="80px" align="center" class="img-flag">
        <h5 style="color: purple; font-family: Cambria; text-align: center">
            KABANGA COLLEGE OF HEALTH AND ALLIED SCIENCES
        </h5>
        <h6 style="font-family: Cambria; text-align: center">
            P.O BOX 42, KASULU, KIGOMA ,TANZANIA
        </h6>
    </div>
<br>

    <h5 style="font-family: Cambria; text-align: center">STAFF SALARIES FOR <?php echo  strtoupper($month).' '.date_format(new DateTime($model->created_at), 'Y')?> </h5>

</div>
<br>
<?php
?>

<div style="text-align:left">
    <h5 style="font-family: Cambria">

            THE BANK MANAGER,<br>
        NMB KASULU BRANCH,<br>
        P.O	BOX 70, KASULU, KIGOMA, TANZANIA
    </h5>
</div>
<br>
<table class="table table-bordered" style="border:1px solid black ;border-collapse: collapse; width: 100%">
    <tr style="border:1px solid purple;">
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">S/NO. </td>
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">NAME OF EMPLOYEE</td>
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">ACCOUNT NUMBER</td>
        <td colspan="3" style="font-weight: bold;border:1px solid purple;">NET PAY [Tshs]</td>
    </tr>

    <?php
    $n=1;
    $total=0;
    foreach ($all_staff as $staff){
    ?>
    <tr style="border:1px solid purple;">
        <td colspan="3" style="border:1px solid purple;"><?= $n++?></td>
        <td colspan="3" style="border:1px solid purple;"><?= $staff->fname.' '.$staff->lname?></td>
        <td colspan="3" style="border:1px solid purple;"><?= $staff->bank_account_number?></td>
        <td colspan="3" style="border:1px solid purple;"><?php

            //TOTAL DEDUCTION
            $paye=is_null($staff->paye)?0:$staff->paye;
            $helsb=is_null($staff->helsb)?0:$staff->helsb;
            $nssf=is_null($staff->nssf)?0:$staff->nssf;
            $nhif=is_null($staff->nhif)?0:$staff->nhif;
            $TUGHE=is_null($staff->TUGHE)?0:$staff->TUGHE;
            $total_deduction=$paye+$helsb+$nssf+$nhif+$TUGHE;

            //TOTAL EARNINGS
            //CHECKING ALLOWANCE
            $has_allowances=\common\models\StaffAllowance::find()->where(['staff_id'=>$staff->id])->exists();
            if ($has_allowances){
                $staff_allowances=\common\models\StaffAllowance::find()->where(['staff_id'=>$staff->id])->all();
                $total_allowance=0;
                foreach ($staff_allowances as $allowance){
                    $allowance_amount= \common\models\Allowance::find()->where(['id'=>$allowance->allowance_id])->one()->amount;
                    $total_allowance+=$allowance_amount;
                }
                $total_earnings=$total_allowance+$staff->basic_salary;
                $net_pay=$total_earnings-$total_deduction;
                echo Yii::$app->formatter->asDecimal($net_pay,2);
            }

            else{
                $net_pay=$staff->basic_salary-$total_deduction;
                echo Yii::$app->formatter->asDecimal($net_pay,2);
            }

            $total+=$net_pay;
            ?></td>
    </tr>

<?php }?>
    <tr>
        <td colspan="3" style="border:1px solid purple;"></td>
        <td colspan="3" style="border:1px solid purple;">TOTAL [Tshs]</td>
        <td colspan="3" style="border:1px solid purple;"></td>
        <td colspan="3" style="border:1px solid purple;"><?= Yii::$app->formatter->asDecimal($total,2)?></td>

    </tr>
</table>

<div style="flex-direction: row;">

    <table style="width:100%">
        <tr>
            <td><div>
                    ..........................................<br>
                    <?php
                    $principal_id=\common\models\Designation::find()->where(['abbreviation'=>'PR'])->one()->id;
                    $principal=\common\models\Staff::find()->where(['designation_id'=>$principal_id])->one();

                    $mname=!empty($principal->mname)?$principal->mname:' ';

                    echo $principal->fname.' '.$mname.' '.$principal->lname;

                    ?>
                    <p>PRINCIPAL</p>
                </div></td>
            <td class="align-items-right" style="padding-left: 300px"> <div>
                    ...................................<br>
                    <?php
                    $hr_id=\common\models\Designation::find()->where(['abbreviation'=>'HR'])->one()->id;
                    $HR=\common\models\Staff::find()->where(['designation_id'=>$hr_id])->one();

                    $mname=!empty($HR->mname)?$HR->mname:' ';
                    echo $HR->fname.' '.$mname.' '.$HR->lname;
                    ?>
                    <p>Human Resource Officer[HR]</p>
                </div>
            </td>
        </tr>

    </table>





</div>