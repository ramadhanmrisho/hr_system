<?php

use common\models\AttachmentsType;
use common\models\EmployeeSpouse;
use common\models\UserAccount;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = 'Staff Profile:'.$model->fname .' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Employees List', 'url' => ['index']];
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
<div class="staff-view" style="font-family: 'Lucida Bright'">

    <p>
<!--        --><?php //if (UserAccount::userHas(['ADMIN','HR']) || Yii::$app->user->identity->user_id==$model->id):?>
        <?php if (UserAccount::userHas(['ADMIN','HR'])):?>
            <?= Html::a('Update Staff Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-fill']) ?>

        <?php endif;?>

        <?php if (UserAccount::userHas(['ADMIN'])):?>
            <?= Html::button('<span class=" fa fa-lock"> Change Password</span>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['staff/change-nywila','staff_id'=>$model->id]), 'class' => 'btn btn-success']) ?>


        <?php endif;?>

        <?php if(UserAccount::find()->where(['user_id'=>$model->id])->one()->status ==10 && UserAccount::userHas(['ADMIN','HR'])) : ?>
        <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Deactivate', ['deactivate', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-fill',
            'data' => [
                'confirm' => 'Are you sure you want to Deactivate this Account?',
                'method' => 'post',
            ],
        ]);
        ?>
        <?php endif;?>

        <?php if(UserAccount::find()->where(['user_id'=>$model->id])->one()->status ==9 && UserAccount::userHas(['ADMIN','HR'])) : ?>
            <?= Html::a('<i class="glyphicon glyphicon-ok"></i> Activate', ['activate', 'id' => $model->id], [
                'class' => 'btn btn-success btn-fill',
                'data' => [
                    'confirm' => 'Are you sure you want to Activate this Account?',
                    'method' => 'post',
                ],
            ]) ?>
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
<?php


?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h4 class="badge bg-aqua-active" style="font-weight: bold;color: whitesmoke; ">Personal Information </h4>
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

                        'home_address:text:Street',
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
                <h4 class="badge bg-aqua-active" style="font-weight: bold;color: whitesmoke; ">Employment Details </h4>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'employee_number',
                        'name_of_high_education_level',
                        ['attribute'=>'designation_id','value'=>$model->designation->name],
                        ['attribute'=>'department_id','value'=>$model->department->name],
                        ['attribute'=>'basic_salary','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal(intval($model->basic_salary),2);
                        }],
                        ['attribute'=>'helsb','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal(intval($model->helsb),2);
                        }],
                        ['attribute'=>'paye','format'=>'html','value'=>function($model){
                            return  Yii::$app->formatter->asDecimal(intval($model->paye),2);
                        }],
                        ['attribute'=>'nssf','format'=>'html','value'=>function($model){
                            return  $model->nssf;
                        }],
                        ['attribute'=>'nssf','format'=>'html','value'=>function($model){

                        $allowances = \common\models\StaffAllowance::find()->where(['staff_id'=>$model->id])->all();

                        $tot = 0;
                        foreach ($allowances as $all){
                            $tot = + \common\models\Allowance::find()->where(['id'=>$all->allowance_id])->sum('amount');
                        }

                        $total = $model->basic_salary + $tot;

                        return Yii::$app->formatter->asDecimal(intval($total),2);

                        },'label'=>'Total Packages'],
                        ['attribute'=>'nhif','format'=>'html','value'=>function($model){
                        return  $model->nhif;
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

<?php $this->beginBlock('allowance')?>
<?php $dataProvider=new \yii\data\ActiveDataProvider(['query'=>\common\models\StaffAllowance::find()->where(['staff_id'=>$model->id])]);

echo  Html::button('<span class=" fa fa-money"> Add Allowance</span>', ['id' => 'modalButton4', 'value' => \yii\helpers\Url::to(['staff-allowance/create', 'staff_id' => $model->id]), 'class' => 'btn btn-success']);


if (isset($dataProvider)){
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
                return  UserAccount::userHas(['ADMIN','HR'])? Html::a('<span class="glyphicon glyphicon-remove" style="color: red">Remove</span> ',['/staff/remove-allowance','id'=>$model->id,'staff_id'=>$model->staff_id],[
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

<?php $this->beginBlock('family_info')?>

<div class="panel panel-default" style="font-family: Lucida Bright">
    <div class="panel-body">
        <div class="col-sm-6">
<?php $dataProvider = new \yii\data\ActiveDataProvider(['query'=>\common\models\Dependants::find()->where(['staff_id'=>$model->id])]);
if (!empty($dataProvider)) {
echo ' <h4 class=""  style=" font-family:Lucida Bright ;color: black;">Employee Dependants</h4>';
   echo  Html::button('<span class=" fa fa-child"> Add Dependents</span>', ['id' => 'modalButton1', 'value' => \yii\helpers\Url::to(['dependants/create', 'staff_id' => $model->id]), 'class' => 'btn btn-success']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'gender',
            'dob',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}','buttons'=>['delete'=>function($url,$model){
                return  UserAccount::userHas(['ADMIN','HR'])? Html::a('<span class="glyphicon glyphicon-remove" style="color: red"> Remove</span> ',['/staff/remove-dependents','id'=>$model->id,'staff_id'=>$model->staff_id],[
                    'data' => [
                        'confirm' => 'Are you sure you want to remove?',
                        'method' => 'post',
                    ],
                ]):'';
            }]]
        ],

    ]);
}
else{
    echo 'No results found...';
}
           ?>
        </div>
        <div class="col-sm-6">
           <h4 class="" style=" font-family:Lucida Bright ;color: black;">Employee Spouse</h4>
            <?php
            echo  Html::button('<span class=" fa fa-user"> Add Spouse Info </span>', ['id' => 'modalButton2', 'value' => \yii\helpers\Url::to(['employee-spouse/create', 'staff_id' => $model->id]), 'class' => 'btn btn-success']);

            $spouse_exists = EmployeeSpouse::find()->where(['staff_id'=>$model->id])->exists();
            if ($spouse_exists):
                $spouseProvider = new \yii\data\ActiveDataProvider([
                    'query' => \common\models\EmployeeSpouse::find()->where(['staff_id' => $model->id]),
                ]);
            ?>
            <?= GridView::widget([
                'dataProvider' => $spouseProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'phone_number',
                    ['class' => 'yii\grid\ActionColumn',
                        'template'=>'{delete}','buttons'=>['delete'=>function($url,$model){
                        return  UserAccount::userHas(['ADMIN','HR'])? Html::a('<span class="glyphicon glyphicon-remove" style="color: red"> Remove</span>',['/staff/remove-spouse','id'=>$model->id,'staff_id'=>$model->staff_id],[
                            'data' => [
                                'confirm' => 'Are you sure you want to remove?',
                                'method' => 'post',
                            ],
                        ]):'';
                    }]]
                ],
            ]) ?>
<?php endif;?>
        </div>

        <div class="col-sm-6">
            <h4 class="" style="font-family: Lucida Bright; color: black;">Next of Kin Details</h4>

            <?php
            echo  Html::button('<span class=" fa fa-user"> Add New </span>', ['id' => 'modalButton3', 'value' => \yii\helpers\Url::to(['next-of-kin/create', 'staff_id' => $model->id]), 'class' => 'btn btn-success']);

            $next_of_kin_exists = \common\models\NextOfKin::find()->where(['staff_id' => $model->id])->exists();
            if ($next_of_kin_exists):
                $dataProvider = new \yii\data\ActiveDataProvider([
                    'query' => \common\models\NextOfKin::find()->where(['staff_id' => $model->id]),
                ]);
                echo \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        'relationship',
                        'phone_number',
                        'physical_address',
                        ['class' => 'yii\grid\ActionColumn',
                            'template'=>'{delete}','buttons'=>['delete'=>function($url,$model){
                            return  UserAccount::userHas(['ADMIN','HR'])? Html::a('<span class="glyphicon glyphicon-remove" style="color: red"> Remove</span>',['/staff/remove-kin','id'=>$model->id,'staff_id'=>$model->staff_id],[
                                'data' => [
                                    'confirm' => 'Are you sure you want to remove?',
                                    'method' => 'post',
                                ],
                            ]):'';
                        }]],
                    ],
                ]);
            endif;
            ?>
    </div>
</div>
<?php $this->endBlock()?>
<?php $this->beginBlock('attachments')?>
<?php
$attachment_exist= \common\models\EmployeeAttachments::find()->where(['staff_id'=>$model->id])->exists();

if (UserAccount::userHas(['ADMIN', 'HR'])):
echo   Html::a(' <span class="fa fa-edit"></span> Add Attachment', ['staff/add-attachment', 'id' => $model->id], ['class' => 'btn btn-success pull-right']).'<br>';
endif;

if($attachment_exist){
    $attachments=new yii\data\ActiveDataProvider(['query' => \common\models\EmployeeAttachments::find()->where(['staff_id'=>$model->id])]);

    $attachment_model= \common\models\EmployeeAttachments::find()->where(['staff_id'=>$model->id])->one();

    echo GridView::widget([
        'dataProvider' => $attachments,'summary'=>'',
        'tableOptions' => ['class' => 'table table-borderless table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'attached_file','format'=>'raw', 'value' => function($model){ return Html::a('<i class="glyphicon glyphicon-paperclip"></i> '. AttachmentsType::findOne($model->attachment_type_id)->name,Yii::getAlias('@web').'/employee_attachments/'.$model->attached_file,['target'=>'blank']);}],
            ['class' => 'yii\grid\ActionColumn','template'=>'{delete} {reattach}','buttons'=>[

                'reattach'=>function($modell,$key,$index){
                    return  Html::a('<i class="glyphicon glyphicon-edit"></i> '.Yii::t('app','Re-attach'),['reattach-file','id'=>$key['id']],['class' => 'btn btn-primary btn-sm','style'=>'float:right',
                        'data'=>[
                            'method' => 'post',
                            'confirm' => Yii::t('app','Are you sure you want to Re attach this attachment '),
                            //'params' => ['id'=>$key['id']]
                        ]
                    ]);
                },
                'delete'=>function($model,$key,$index){
                    return Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('app','Remove'),['remove-file'],['class' => 'btn btn-danger btn-sm','style'=>'float:right',
                        'data'=>[
                            'method' => 'post',
                            'confirm' => Yii::t('app','Are you sure you want to remove this attachment '),
                            'params' => ['id'=>$key['id']]
                        ]
                    ]);
                }

            ],],
        ]
    ]);
}else{
    echo '<br><div class="alert alert-warning alert-sm">No file is attached</div>';
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
    Modal::begin([
        'header' => '<h4 align="center" style="color: red;"><span class="fa fa-child"> Dependants Info</span></h4>',
        'id'     => 'modal1',
        'size'   => 'modal-small',
    ]);

    echo '<div id="modalContent1"></div>';



    Modal::end(); ?>



    <?php
    Modal::begin([
        'header' => '<h4 align="center" style="color: red;"><span class="fa fa-user"> Spouse Info</span></h4>',
        'id'     => 'modal2',
        'size'   => 'modal-small',
    ]);
    echo '<div id="modalContent2"></div>';
    Modal::end(); ?>

    <?php
    Modal::begin([
        'header' => '<h4 align="center" style="color: red;"><span class="fa fa-user"> Next of Keen Info</span></h4>',
        'id'     => 'modal3',
        'size'   => 'modal-small',
    ]);
    echo '<div id="modalContent3"></div>';
    Modal::end(); ?>


    <?php
    Modal::begin([
        'header' => '<h4 align="center" style="color: red;"><span class="fa fa-money"> Allowance Info</span></h4>',
        'id'     => 'modal4',
        'size'   => 'modal-small',
    ]);
    echo '<div id="modalContent4"></div>';
    Modal::end(); ?>


<?php
echo '<h5 style="font-family: Lucida Bright">'. Tabs::widget([
    'items' => [
        [
            'label' => 'Staff Details',
            'content' => $this->blocks['staff_details'],
        ],
        [
            'label' => 'ALLOWANCES',
            'content' =>$this->blocks['allowance'],
        ],
        [
            'label' => 'EMPLOYEE ATTACHMENTS',
            'content' =>$this->blocks['attachments'],
        ],
        [
            'label' => 'EMPLOYEE FAMILY INFO',
            'content' =>$this->blocks['family_info'],
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
        $('#modal1').modal('show')
            .find('#modalContent1')
            .load($(this).attr('value'));
    });
    
      $('#modalButton2').click(function(){
        $('#modal2').modal('show')
            .find('#modalContent2')
            .load($(this).attr('value'));
    });
      
           $('#modalButton3').click(function(){
        $('#modal3').modal('show')
            .find('#modalContent3')
            .load($(this).attr('value'));
    });
           
                      $('#modalButton4').click(function(){
        $('#modal4').modal('show')
            .find('#modalContent4')
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
