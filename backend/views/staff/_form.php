<?php

use common\models\Allowance;
use common\models\AttachmentsType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */
/* @var $form yii\widgets\ActiveForm */


$hr=\common\models\UserAccount::userHas(['HR']);
$admin=\common\models\UserAccount::userHas(['ADMIN']);
?>

<style>

    form div.required label.control-label:after {

        content:" * ";

        color:red;

    }
    </style>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-form" style="font-family: 'Lucida Bright'">
    <div class="panel panel-default fadeIn" style="padding:20px; ">
        <div class="panel-body" style="font-weight: bold;">

<!--                <h6 style="font-weight: bold;align-content: center"> All Fields with <i style="color: red">*</i> are  mandatory</h6>-->



            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
            <fieldset>
                <legend style="font-weight: bold;color: #0d6aad">Employee Personal Information:</legend>

                <div class="col-md-3">
                <?= $form->field($model, 'fname',['options'=>['class'=>'required']])->textInput(['maxlength' => true],['options'=>['class'=>'required']]) ?>
                <?php if ($hr ||$admin ){?>
                <?= $form->field($model, 'dob',['options'=>['class'=>'required']])->widget(\dosamigos\datepicker\DatePicker::className(),['clientOptions'=>['format'=>'yyyy-mm-dd','autoclose'=>true],'options'=>['autocomplete'=>'off']]) ?>
                <?php }?>
                <?= $form->field($model, 'identity_type_id',['options'=>['class'=>'required']],['template' => '<div class="input-group"><span class="input-group-addon">'.Yii::t('app','Identity Type').'</span>{input}</div>'])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\IdentityType::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select ID Type--']]) ?>
                <?= $form->field($model, 'gender',['options'=>['class'=>'required']])->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>
                <?= $form->field($model, 'region_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::classname(), [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'id', 'name'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select region ...', 'multiple' => false,
                        'onchange' => '
                                            $.post( "index.php?r=staff/listsdistrict&id=' . '"+$(this).val(), function( data ) {
                                              $( "select#staff-district_id" ).html( data );
                                              
                                            });'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'place_of_birth',['options'=>['class'=>'required']])->textInput(['placeholder' =>'Eg: Dar ess Salaam']) ?>
                    <?= $form->field($model, 'id_number',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone_number',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'district_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::classname(), [
                        'data' => [],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select district ...', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-md-3">
                  <?= $form->field($model, 'lname',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
                  <?= $form->field($model, 'marital_status',['options'=>['class'=>'required']])->dropDownList([ 'Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', ], ['prompt' => '']) ?>
                  <?= $form->field($model, 'email',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
                  <?= $form->field($model, 'alternate_phone_number')->textInput() ?>
                  <?= $form->field($model, 'home_address')->textInput(['maxlength' => true])->label('Street') ?>
                </div>
                <div class="col-md-3">
                    <?php if($model->isNewRecord){?>
                    <?= $form->field($model, 'photo',['options'=>['class'=>'required']])->widget(\kartik\file\FileInput::className(),[
                        'options' => ['accept'=>'*', 'required' => true],
                        'pluginOptions' => ['allowedFileExtensions' => ['jpg','png','jepg'], 'showUpload' => false]
                    ]); ?>
                <?php }?>
                </div>
            </fieldset>
            <br>
   <fieldset>
       <?php if ($hr ||$admin){?>
       <legend style="font-weight: bold;color: #0d6aad"> Employment Information:</legend>
       <div class="col-md-3">
           <?= $form->field($model, 'employee_number',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'designation_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Designation::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>
<!--           --><?php //= $form->field($model, 'paye',['options'=>['class'=>'money required']])->textInput(['id'=>'money-value1']) ?>
           <?= $form->field($model, 'account_name',['options'=>['class'=>'required']])->dropDownList([ 'NMB' => 'NMB', 'CRDB' => 'CRDB','NBC'=>'NBC','AMANA BANK'=>'AMANA BANK','AZANIA'=>'AZANIA' ], ['prompt' => '']) ?>
       </div>
       <div class="col-md-3">
           <?= $form->field($model, 'date_employed',['options'=>['class'=>'required']])->widget(\dosamigos\datepicker\DatePicker::className(),['clientOptions'=>['format'=>'yyyy-mm-dd','autoclose'=>true],'options'=>['autocomplete'=>'off']]) ?>
           <?= $form->field($model, 'contract_end_date')->widget(\dosamigos\datepicker\DatePicker::className(),['clientOptions'=>['format'=>'yyyy-mm-dd','autoclose'=>true],'options'=>['autocomplete'=>'off']]) ?>
           <?= $form->field($model, 'bank_account_number',['options'=>['class'=>'required']])->textInput() ?>
       </div>

       <div class="col-md-3">
           <?= $form->field($model, 'name_of_high_education_level',['options'=>['class'=>'required']])->dropDownList([ 'PhD' => 'PhD', 'Master Degree' => 'Master Degree', 'Bachelor Degree' => 'Bachelor Degree','Diploma'=>'Diploma','Certificate'=>'Certificate',' A-Level'=>' A-Level','O-Level'=>'O-Level','STD VII'=>'STD VII','Nil'=>'Nil' ], ['prompt' => '']) ?>

           <?= $form->field($model, 'basic_salary'  ,['options'=>['class'=>'required']])->textInput(['id'=>'money-value']) ?>
           <?= $form->field($model, 'nhif',['options'=>['class'=>'required']])->dropDownList([ 'Yes' => 'Yes', 'No' => 'No' ], ['prompt' => '']) ?>

           <?= $form->field($model, 'category',['options'=>['class'=>'required']])->dropDownList([ 'Permanent' => 'Permanent', 'Fixed Term' => 'Fixed Term','Specific Task'=>'Specific Task' ], ['prompt' => '']) ->label('Contract Category')?>
       </div>
       <div class="col-md-3">
           <?= $form->field($model, 'department_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Department::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select Department--']]) ?>

           <?=  $form->field($model,'allowance_id')->widget(multipleinput\MultipleInput::className(),[
               'max' => 15,
               'columns'=>[
                   ['name'=>'allowance_id',
                       'type'=>Select2::className(),
                       'title'=>'Allowance',
                          'options'=>[
                    'data'=> ArrayHelper::map(\common\models\Allowance::find()->all(),'id',function($model){
                        return $model['name'].' ['.Yii::$app->formatter->asDecimal($model['amount'],0).' Tsh]';
                    }),
                    'options' => [ 'prompt' =>'----Select-----',
                    ],
                ]
                   ],
               ]
           ])->label(false)?>
           <?= $form->field($model, 'nssf',['options'=>['class'=>'required']])->textInput() ?>
           <?= $form->field($model, 'has_ot',['options'=>['class'=>'required']])->dropDownList([ 'Yes' => 'Yes', 'No' => 'No' ], ['prompt' => '']) ?>
       </div>
    <?php if ($model->isNewRecord){?>
           <legend style="font-weight: bold;color: #0d6aad">Employee Family Info:</legend>
           <div class="col-md-3">
               <?= $form->field($model, 'next_of_kin_name',['options'=>['class'=>'required']])->textInput(['maxlength' => true])->label('Next of Kin Name') ?>
           </div>
       <div class=" col-md-3">
           <?= $form->field($model, 'relationship',['options'=>['class'=>'required']])->textInput() ?>
           </div>
           <div class=" col-md-3">
               <?= $form->field($model, 'phone',['options'=>['class'=>'required']])->textInput() ?>
           </div>
           <div class=" col-md-3">
               <?= $form->field($model, 'next_of_kin_address',['options'=>['class'=>'required']])->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-md-3">
               <?= $form->field($model, 'spouse_name')->textInput() ?>
           </div>
           <div class="col-md-3">
               <?= $form->field($model, 'spouse_phone_number')->textInput() ?>
           </div>
           <div class="col-md-12">
               <legend style="font-weight: bold;color: #0d6aad"> Dependants Info:</legend>
               <?=  $form->field($model,'dependant_information')->widget(multipleinput\MultipleInput::className(),[
                   'max' => 3,
                   'columns'=>[
                       ['name'=>'dependant_name',
                           'title'=>'Dependent Name',

                           'options'=>[
                               'options' => [ 'prompt' =>'----Select-----',

                               ],
                           ]
                       ],
                       [
                           'name'     => 'date_of_birth',
                           'title'    => 'Date of birth',
                           'type'     => \dosamigos\datepicker\DatePicker::className(),
                           'options'  => [
                               'clientOptions' => [
                                   'autoclose' => true,
                                   'format'    => 'yyyy-mm-dd'
                               ]
                           ]
                       ],
                       ['name'=>'dependant_gender',
                           'type'=>Select2::className(),
                           'title'=>'Gender',
                           'options'=>[
                               'data'=>['Male'=>'Male','Female'=>'Female'],
                               'options' => [ 'prompt' =>'----Select-----',
                               ],
                           ]
                       ],
                   ]
               ])->label(false)?>
           </div>
           <div class="col-md-12">
               <legend  style="font-weight: bold;font-family: Lucida Bright;color: #0d6aad">Employee Attachments</legend>

               <?=  $form->field($model,'attachments')->widget(multipleinput\MultipleInput::className(),[
                   'max' => 10,
                   'addButtonOptions' => [
                       'class' => 'btn btn-primary cart-btn',
                       'label' => '<span class=" fa fa-plus-circle"></span>'
                   ],
                   'removeButtonOptions' => [
                       'class' => 'btn btn-danger',
                       'label' => '<span class=" fa fa-minus"></span>'
                   ],
                   'columns'=>[
                       ['name'=>'attachments_type_id',
                           'type'=>Select2::className(),
                           'title'=>'Attachment Name',
                           'options'=>[
                               'data'=> ArrayHelper::map(AttachmentsType::find()->where(['status'=>'active'])->all(),'id','name'),'options' => [ 'prompt' =>'----Select Attachment Type-----',
                               ],
                           ]
                       ],

                       [
                           'name'=>'attachment',
                           'title'=>'Attached File',
                           'type'=>'fileInput',
                           'options' => [
                               'accept' => 'application/pdf',
                           ],
                       ],
                   ]
               ])->label(false)?>

           </div>
           <?php }?>

       <?php }?>
   </fieldset>

    <div class="form-group" align="center">
        <?= Html::submitButton(($model->isNewRecord) ? 'Save Details ' : 'Save Changes', ['class' => 'btn btn-success btn-fill','style'=>'min-width:150px;',[
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to save staff details?',
                'method' => 'post',
            ],
        ]]) ?>
    </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<?php

$script=<<< JS
$(function() {
    // Get the input field by its ID
    var input = $('#money-value');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
$(function() {
    // Get the input field by its ID
    var input = $('#money-value1');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
$(function() {
    // Get the input field by its ID
    var input = $('#money-value2');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
$(function() {
    // Get the input field by its ID
    var input = $('#money-value3');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
$(function() {
    // Get the input field by its ID
    var input = $('#money-value4');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
JS;
$this->registerJs($script);
?>