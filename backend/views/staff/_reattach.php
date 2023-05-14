
<?php

use common\models\AttachmentsType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;

$this->title = 'Re-Attach';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="in-country-application-register-book-form">
    <div class="card card-default">
        <b class="card-header"><br><?= ' Re-attach :'.'<b>'.ucwords(AttachmentsType::findOne($model->attachment_type_id)->name)?></b></h5></div>
        <div class="card-body" style="padding:40px;">
            <center>
                <div class="col-sm-6 text-left" style="float:none;">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'] ]); ?>

                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'attached_file')->fileInput()->label(false)?></div>
                        <div class="col-sm-6 text-right">
                            <?=  Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i> '.Yii::t('app','Click to Re-attach'),['class'=>'btn btn-success'])?>
                            <?= Html::a('<i class="glyphicon glyphicon-ban-circle"></i> '.Yii::t('app', 'Cancel'),['staff/view','id'=>$model->staff_id],['class' => 'btn btn-danger'])?>&emsp;

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </center>
        </div>
    </div>
    <?= Tabs::widget() ?>
</div>
