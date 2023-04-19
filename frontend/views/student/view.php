<?php

use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = $model->fname.' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' =>"#"];
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
                                           
 
                    </div>'; ?>
<?php ActiveForm::end(); ?>
<?php echo '</div>'; ?>
<?php Modal::end();?>
<!-- Edit photo -->

<?php ob_start()?>
<div class="student-view">


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
                        'dob',
                        'place_of_birth',
                        'phone_number',
                          ['attribute'=>'identity_type_id','value'=>function($model){
                    return !empty($model->identityType->name)? $model->identityType->name: ' ';
            }],
                        'id_number',
                        'marital_status',
                        'email:email',
                        'gender',
                        'nationality_id',

                    ],
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?php if($model->passport_size) {?>

                    <?=  Html::a(Html::img('/kcohas-mis/backend/web/student_photo/' . $model->passport_size, ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>


                <?php }else{ ?>
                    <?=  Html::a(Html::img(Yii::getAlias('@web').'/student_photo/logo.png', ['class'=>'thing img-thumbnail', 'height'=>'200px', 'width'=>'200px']), ['site/zoom'])?>
                <?php } ?>


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
                    'status',
                    'date_of_admission',
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

