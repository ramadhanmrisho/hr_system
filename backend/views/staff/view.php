<?php

use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = 'Employee Number :'.$model->employee_number;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
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

<?php $this->beginBlock('staff_details')?>


<br>
<div class="staff-view">

    <p>
        <?php if (\common\models\UserAccount::userHas(['ADMIN','HR']) || Yii::$app->user->identity->user_id==$model->id):?>
            <?= Html::a('Update Staff Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-fill']) ?>

        <?php endif;?>

        <?php if (\common\models\UserAccount::userHas(['ADMIN'])):?>
            <?= Html::button('<span class=" fa fa-lock"> Change Password</span>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['staff/change-nywila','staff_id'=>$model->id]), 'class' => 'btn btn-success']) ?>
        <?php endif;?>
    </p>



    <!-- Edit Photo -->
    <?php Modal::begin([
        'header' => '<h4>Upload Photo</h4>',
        'id' => 'uploadphoto',
        'size' => 'modal-sm'
    ]);
    echo '<div id="modalContent">'; ?>
    <?php $form = ActiveForm::begin(['action' =>['/staff/upload-photo', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data'] ]); ?>
    <?php echo '<div class="modal-body">
                        '.$form->field($model, 'photo')->fileInput(['required' => 'required'])->label('Select image file').' 
                    </div>
                    <div class="modal-footer">
                        '.Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i> Upload', ['class' => 'btn btn-success btn-fill btn-sm']).'  
                    </div>'; ?>
    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php Modal::end();?>
    <!-- Edit photo -->

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke; ">Personal Information </h4>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'fname',
                        'mname',
                        'lname',
                        ['attribute'=>'dob','value'=>function($model){
                            return date("F j, Y",strtotime($model->dob));
                        }],
                        'place_of_birth',
                        'phone_number',
                        'id_number',
                        'marital_status',
                        'email:email',
                        'gender',
                        ['attribute'=>'region_id','value'=>function($model){
                            return $model->region->name;
                        }],
                        ['attribute'=>'district_id','value'=>function($model){
                            return $model->district->name;
                        }],
                        'ward',
                        'village',
                        'division',
                        'home_address',
                        'house_number',
                        'created_at',
                        'updated_at',
                    ],
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?php if($model->photo) { ?>
                    <?=  Html::a(Html::img(Yii::getAlias('@web').'/staff_photo/'.$model->photo, ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>
                <?php }else{ ?>
                    <?=  Html::a(Html::img(Yii::getAlias('@web').'/staff_photo/logo.png', ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>
                <?php } ?>
                <p style="margin-top: 10px; cursor: pointer;"><?= Html::tag('span', '<i class="glyphicon glyphicon-cloud-upload"></i> Upload New Photo',['class' => 'uploadbtn'])?></p>
            </div>

            <div class="col-sm-6">
                <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke; ">Employment Details </h4>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'employee_number',
                        'name_of_high_education_level',
                        ['attribute'=>'designation_id','value'=>$model->designation->name],
                        ['attribute'=>'department_id','value'=>$model->department->name],
                        'salary_scale',
                        ['attribute'=>'basic_salary','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->basic_salary,2);
                        }],
                        ['attribute'=>'helsb','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->helsb,2);
                        }],
                        ['attribute'=>'paye','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->paye,2);
                        }],
                        ['attribute'=>'nssf','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->nssf,2);
                        }],
                        ['attribute'=>'nhif','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->nhif,2);
                        }],
                        ['attribute'=>'TUGHE','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal($model->TUGHE,2);
                        }],
                        'date_employed',
                        'account_name',
                        ['attribute'=>'bank_account_number','value'=>function($model){
                            return $model->bank_account_number;
                        }],
                    ],
                ]) ?>
            </div>
        </div>


    </div>

</div>

<?php $this->endBlock()?>



<?php ob_start()?>

<?php $this->beginBlock('allowance')?>
<?php $dataProvider=new \yii\data\ActiveDataProvider(['query'=>\common\models\StaffAllowance::find()->where(['staff_id'=>$model->id])]);
if (!empty($dataProvider)){
    echo   GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'allowance_id','value'=>function($model){

                $name=\common\models\Allowance::find()->where(['id'=>$model->allowance_id])->one();
                return !empty($name)?\common\models\Allowance::find()->where(['id'=>$model->allowance_id])->one()->name:' ';
            },'label'=>'Allowance Type'],

            ['attribute'=>'allowance_id','value'=>function($model){

                $name=\common\models\Allowance::find()->where(['id'=>$model->allowance_id])->one();
                return !empty($name)?Yii::$app->formatter->asDecimal(\common\models\Allowance::find()->where(['id'=>$model->allowance_id])->one()->amount,2):' ';
            },'label'=>'Amount'],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}','buttons'=>['delete'=>function($url,$model){
                return  \common\models\UserAccount::userHas(['ADMIN','HR'])? Html::a('<span class="glyphicon glyphicon-remove"></span> Remove Allowance',['/staff/remove-allowance','id'=>$model->id,'staff_id'=>$model->staff_id],[
                    'data' => [
                        'confirm' => 'Are you sure you want to remove this Allowance?',
                        'method' => 'post',
                    ],
                ]):'';
            }]]

        ],
    ]);
}

?>

<?php $this->endBlock()?>







<?php
Modal::begin([
    'header' => '<h4 align="center" style="color: red;"><span class="fa fa-lock"> Change Password</span></h4>',
    'id'     => 'modal',
    'size'   => 'modal-small',
]);

echo "<div id='modalContent'></div>";

Modal::end(); ?>

<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'STAFF DETAILS',
            'content' => $this->blocks['staff_details'],
        ],
        [
            'label' => 'ALLOWANCES',
            'content' =>$this->blocks['allowance'],
        ],

    ]
]);
?>








<?php

$script=<<< JS
$(function (){
     $('.uploadbtn').on('click',function(e){
        e.preventDefault();
        $('#uploadphoto').appendTo("body").modal('show').addClass('zoomIn');
    });
    
});


//JS FOR IMPORT FORM
$(function (){

    $('#modalButton1').click(function(){
        $('#modalImport').modal('show')
            .find('#modalContentImport')
            .load($(this).attr('value'));
    });
    
});

$(function (){
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});

JS;
$this->registerJs($script);
?>
