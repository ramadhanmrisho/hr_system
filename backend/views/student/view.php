<?php

use common\models\Semester;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = $model->fname.' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => "#"];
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

<p>

        <?php
        $active_semester=Semester::find()->where(['status'=>'Active'])->one()->id;
        $paid=\common\models\Payment::find()->where(['student_id'=>$model->id,'academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'course_id'=>$model->course_id,'semester_id'=>$active_semester,'status'=>'Paid'])->exists();
        ?>

<?php if (\common\models\UserAccount::userHas(['ACC','ADMIN']) && !$paid ){?>

        <?= Html::a('<span class=" fa fa-check-square-o"> PAID</span>', ['payment', 'id' => $model->id], ['class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure this student has completed his/her Payment?',
                'method' => 'post',
            ],
            ]) ?>
<?php }?>
    </p>

    <!-- Edit Photo -->
<?php Modal::begin([
    'header' => '<h4>Upload Photo</h4>',
    'id' => 'uploadphoto',
    'size' => 'modal-sm'
]);
echo '<div id="modalContent">'; ?>
<?php $form = ActiveForm::begin(['action' =>['/student/upload-photo', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data'] ]); ?>
<?php echo '<div class="modal-body">
                        '.$form->field($model, 'passport_size')->fileInput(['required' => 'required'])->label('Select image file').' 
                    </div>
                    <div class="modal-footer">
                        '.Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i> Upload', ['class' => 'btn btn-success btn-fill btn-sm']).' 
                         <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button> 
                    </div>'; ?>
<?php ActiveForm::end(); ?>
<?php echo '</div>'; ?>
<?php Modal::end();?>
    <!-- Edit photo -->

<?php ob_start()?>
<div class="student-view">
    <br>
    <?php if (\common\models\UserAccount::userHas(['ADMIN','AO'])){?>
    <p>
        <?= Html::a('<span class=" fa fa-pencil"> Update Personal Info</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php }?>


    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Personal Information </h4>
                <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fname',
            'mname',
            'lname',
            'dob:date',
            'place_of_birth',
            'phone_number',
            // ['attribute'=>'identity_type_id','value'=>function($model){
            //         return $model->identityType->name;
            // }],
            'id_number',
            'marital_status',
            'email:email',
            'gender',
             ['attribute'=>'nationality_id','value'=>function($model){
                    return $model->nationality->name;
            }]


        ],
    ]) ?>
</div>
            <div class="col-sm-4">
                <?php if($model->passport_size) { ?>
                    <?=  Html::a(Html::img(Yii::getAlias('@web').'/student_photo/'.$model->passport_size, ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>
                <?php }else{ ?>
                    <?=  Html::a(Html::img(Yii::getAlias('@web').'/student_photo/logo.png', ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>
                <?php } ?>

                <?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
                <p style="margin-top: 10px; cursor: pointer;"><?= Html::tag('span', '<i class="glyphicon glyphicon-cloud-upload"></i> Upload New Photo',['class' => 'uploadbtn'])?></p>
                <?php }?>

            </div>


            <div class="col-sm-6">
                <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke; ">Place of Domicile </h4>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['attribute'=>'region_id','value'=>function($model){
                         return $model->region->name;
                        }],
                        ['attribute'=>'district_id','value'=>function($model){
                         return $model->district->name;
                        }],
                        'village',
                        'home_address',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php $student_details=ob_get_clean()?>



<?php ob_start()?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6">
                <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Student's College Information</h4>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'registration_number',
                            ['attribute'=>'course_id','value'=>function($model){return $model->course->course_name;}],
                          'nta_level',
                             'sponsorship',
                            'date_of_admission:date',
                            'college_residence',
                            ['attribute'=>'department_id','value'=>function($model){return $model->department->name;}],
                            'intake_type',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
<?php $college_details=ob_get_clean()?>





<?php ob_start()?>
<?php $olevel=$model->getOLevelInformations()->one()?>
<br>
<?php if (\common\models\UserAccount::userHas(['ADMIN','AO'])){?>
<p>
    <?= Html::a('<span class=" fa fa-pencil"> Update O Level Info</span>', ['o-level-information/update', 'student_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    
      <?php if(\common\models\ALevelInformation::find()->where(['student_id'=>$model->id])->exists()){?>
    <?= Html::a('<span class=" fa fa-pencil"> Update A Level Info</span>', ['a-level-information/update', 'student_id' => $model->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php }?>
    <?php }?>


    <div class="panel panel-default">
    <div class="panel-body">
    <div class="col-md-6">
        <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Student's O Level Information</h4>

<?= DetailView::widget([
    'model' => $olevel,
    'attributes' => [
        'name_of_school',
        'index_number',
        'division',
        'Physics',
        'Chemistry',
        'Biology',
        'Mathematics',
        'English',
        'year_of_complition',
        ['attribute' =>'o_level_certificate','format'=>'raw', 'value' => function ($model) {return Html::a('<span class="glyphicon glyphicon-paperclip"></span>Click to View',Yii::$app->urlManager->baseUrl.'/../web/attachments/'.$model->o_level_certificate,['target'=>'blank']);}],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>
    </div>

        <?php if ($alevel=$model->getALevelInformations()->exists()){
            $alevel=$model->getALevelInformations()->one();
        ?>

        <div class="col-md-6">

            <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;">Student's A Level Information</h4>

            <?= DetailView::widget([
                'model' => $alevel,
                'attributes' => [
                    'name_of_school',
                    'index_number',
                    'division',
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Mathematics',
                    'year_of_complition',
                    ['attribute' =>'a_level_certificate','format'=>'raw', 'value' => function ($model) {return Html::a('<span class="glyphicon glyphicon-paperclip"></span>Click to View',Yii::$app->urlManager->baseUrl.'/../web/attachments/'.$model->a_level_certificate,['target'=>'blank']);}],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>

    </div>
    <?php }?>
    </div>
    </div>
<?php $education_background=ob_get_clean()?>









<?php ob_start()?>
<br>
<?php if (\common\models\UserAccount::userHas(['HOD','ADMIN','AO'])){?>
<p>
    <?= Html::a('<span class=" fa fa-pencil"> Update Parent  Info</span>', ['parent-information/update', 'student_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php }?>
<?php $parent=$model->getParentInformations()->one(); ?>
    <div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-6">
            <h4 class="btn-primary" style="font-weight: bold;font-family: 'Bell MT';color: whitesmoke;"> Student's Parent Information </h4>

            <?= DetailView::widget([
    'model' => $parent,
    'attributes' => [
        'full_name',
        'phone_number',
        'email:email',
        'gender',
        'relationship',
        'occupation',
        'physical_address',
         ['attribute'=>'nationality_id','value'=>function($model){
                    return $model->nationality->name;
            }],

        'created_at:datetime',
        'updated_at:datetime',
        'altenate_phone_number',
    ],
]) ?>
    </div>
    </div>
    </div>
<?php $parent_details=ob_get_clean()?>















<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'STUDENT DETAILS',
            'content' => $student_details
        ],
        [
            'label' => 'COLLEGE INFORMATION',
            'content' => $college_details,
        ],

        [
            'label' => 'EDUCATION BACKGROUND',
            'content' =>$education_background,
        ],

        [
            'label' => 'PARENT/GUARDIAN INFORMATION',
            'content' => $parent_details,
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

JS;
$this->registerJs($script);
?>

