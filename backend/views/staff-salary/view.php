<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StaffSalary */

$staff=\common\models\Staff::find()->where(['id'=>$model->staff_id])->one();
$this->title = $staff->fname.' '.$staff->lname;
$this->params['breadcrumbs'][] = ['label' => 'Staff Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-salary-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'staff_id','value'=>function($model){

                $staff=\common\models\Staff::find()->where(['id'=>$model->staff_id])->one();
                return  $staff->fname.' '.$staff->lname;
            }],
            'month',
            'created_at:datetime',
            'createdBy.fullName',
        ],
    ]) ?>

    <div >

        <?php
        $completePath = Yii::getAlias('@web/slips/'.$model->salary_slip);
       // $completePath='/slips';
        $filename="Payslip";


          echo $model->pdfViewer($completePath);

?>



    </div>




</div>
