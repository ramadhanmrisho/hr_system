<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserAccount */

$this->title = 'User Account :'.$model->username;
$this->params['breadcrumbs'][] = ['label' => 'User Accounts', 'url' =>'#'];
$this->params['breadcrumbs'][] = $this->title;
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

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<style> .badge-success{ background :#43A047; } .badge-danger{ background:#D50000;}
</style>
<div class="user-account-view">

    <p>
        <?php if(\common\models\UserAccount::findOne($model->id)->status ==10) { ?>
            <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Deactivate', ['deactivate', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-fill',
                'data' => [
                    'confirm' => 'Are you sure you want to Deactivate this Account?',
                    'method' => 'post',
                ],
            ]); ?>
            <?php if (\common\models\UserAccount::userHas(['ADMIN']) || Yii::$app->user->identity->user_id==$model->user_id):?>

                <?= Html::button('<span class=" fa fa-lock"> Change Password</span>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['user-account/change-nywila','id'=>$model->id]), 'class' => 'btn btn-success']) ?>
            <?php endif;?>

        <?php }else { ?>
            <?= Html::a('<i class="glyphicon glyphicon-ok"></i> Activate', ['activate', 'id' => $model->id], [
                'class' => 'btn btn-success btn-fill',
                'data' => [
                    'confirm' => 'Are you sure you want to Activate this Account?',
                    'method' => 'post',
                ],
            ]);
        } ?>



    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'user_id','value'=>function($model){

                if($model->category=='staff'){
                    $staff=\common\models\Staff::find()->where(['id'=>$model->user_id])->one();
                    return  $staff->fname.' '.$staff->lname;
                }
                else{
                    $student=\common\models\Student::find()->where(['id'=>$model->user_id])->one();

                    return  $student->fname.' '.$student->lname;
                }

            },'label'=>'Full Name'],

            'username',

            'email:email',

            ['attribute' => 'status','format'=>'html','value'=>function($model){
                if($model->status==10){
                    return Html::tag('span','Active',['class'=>'badge badge-success']);
                }else{
                    return Html::tag('span','Inactive',['class'=>'badge badge-danger']);
                }
            }],

            'category',
            'designation_abbr',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>



</div>

<?php
Modal::begin([
    'header' => '<h4 align="center" style="color: red;"><span class="fa fa-lock"> Change Password</span></h4>',
    'id'     => 'modal',
    'size'   => 'modal-small',
]);

echo "<div id='modalContent'></div>";

Modal::end(); ?>



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

$(function (){
    $('#modalButton2').click(function(){
        $('#modal1').modal('show')
            .find('#modalContent1')
            .load($(this).attr('value'));
    });
});

JS;
$this->registerJs($script);
?>



