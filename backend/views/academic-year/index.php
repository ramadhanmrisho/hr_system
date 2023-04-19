<?php

use common\models\Semester;
use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AcademicYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Academic Years';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if(Yii::$app->session->hasFlash('gSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('gSuccess');?>
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

<div class="academic-year-index">





    <p>
        <?= Html::button('<span class=" fa fa-plus"> Create Academic Year</span> ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['academic-year/create']), 'class' => 'btn btn-success']) ?>

        <?php
        $active_semester=Semester::find()->where(['status'=>'Active'])->one();

        if ($active_semester->name=='II'){
            ?>
            <?= Html::a('<span class="fa fa-calendar-times-o"> Close Academic Year</span>', ['academic-year/change-year'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to close this Academic Year ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php }?>

    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            ['attribute'=>'status','value'=>'status',
                'filter'=>['Active'=>'Active','Inactive'=>'Inactive'],
            ],
            ['attribute'=>'created_by','value'=>function($model){

                $staff_id=\common\models\UserAccount::find()->where(['id'=>$model->created_by])->one()->user_id;

                $staff=\common\models\Staff::find()->where(['id'=>$staff_id])->one();

                return $staff->fname.' '. $staff->lname;
            },'label'=>'Created by'],
            'created_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {update}',
                'contentOptions' => ['style' => 'width: 10%'],
                'visible'=> Yii::$app->user->isGuest ? false : true,
                'header'=>'ACTION',
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        $t = 'index.php?r=academic-year/view&id='.$model->id;
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to($t),  'title' => Yii::t('app', 'View'),'class' => 'btn btn-info  custom_button']);
                    },

                    'update'=>function ($url, $model) {
                        $t = 'index.php?r=academic-year/update&id='.$model->id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'title' => Yii::t('app', 'Update'), 'class' => 'btn btn-success  custom_button']);
                    },


                ],
            ],
        ],
    ]); ?>



    <?php
    Modal::begin(['id'=>'modalView','size'=>'modal-small','header' => '<h3 align="center" style="color: red">View Details</h3>']);

    echo "<div id='modalContentView'></div>";

    Modal::end(); ?>


    <?php
    Modal::begin([
        'header' => '<h4 align="center" style="color: red">Academic Year</h4>',
        'id'     => 'modal',
        'size'   => 'modal-small',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

    ?>
</div>


<?php
$script=<<< JS


///POP UP FOR VIEW AND UPDATE
$('.custom_button').click(function(){
    $('#modalView').modal('show').find('#modalContentView').load($(this).attr('value'));

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