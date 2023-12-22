
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;

$this->title = 'New Attachment';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-form">
    <div class="card card-default">
        <div class="badge btn-primary card-header"><h5><?= "Upload Attachment" ?></h5></div>
        <div class="card-body" style="padding:40px;">
            <center>
                <div class="col-sm-6 text-left" style="float:none;">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'] ]); ?>

                    <p>Select attachment type and choose a file to attach</p>

                    <?= $form->field($model,'attachment_type_id',['template' => '<div class="input-group"><span class="input-group-addon" style="width:200px; padding:6px 1px">Attachment type </span>{input}</div>{error}'])
                        ->dropDownList(\yii\helpers\ArrayHelper::map($attachment_types,'id',function($model){ return $model['name'];}),['prompt'=>'']);?>

                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'attached_file')->fileInput()->label(false)?></div>
                        <div class="col-sm-6 text-right">
                            <?=  Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i> '.Yii::t('app','Click to attach'),['class'=>'btn btn-success'])?>
                            <?= Html::a('<i class="glyphicon glyphicon-ban-circle"></i> '.Yii::t('app', 'Cancel'),['staff/view','id'=>Yii::$app->request->get('id')],['class' => 'btn btn-danger'])?>&emsp;
                        </div>
                    </div>



                    <?php ActiveForm::end(); ?>
                </div>
            </center>
        </div>
    </div>
    <?= Tabs::widget() ?>
</div>
