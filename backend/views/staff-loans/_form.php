<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StaffLoans $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="staff-loans-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Staff::find()->all(),'id',function ($model){
        return $model->fname.' '.$model->lname;
    }),             'options'=>['placeholder'=>'--Select Staff--']])->label('Staff Name') ?>

    <?= $form->field($model, 'loan_amount')->textInput(['id'=>'money-value']) ?>

    <?= $form->field($model, 'monthly_return')->textInput(['id'=>'money-value1']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

    <div class="form-group" align="center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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



JS;
$this->registerJs($script);
?>
