<?php

use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\YearOfStudySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Year Of Studies';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>



<div class="year-of-study-index">



    <p>
        <?= Html::button('<span class=" fa fa-plus"></span>Create Year of Study', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['year-of-study/create']), 'class' => 'btn btn-success']) ?>

    </p>




    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'created_at',
            'updated_at',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {update}',
                'contentOptions' => ['style' => 'width: 10%'],
                 'visible'=> Yii::$app->user->isGuest ? false : true,
                'header'=>'ACTION',
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        $t = 'index.php?r=year-of-study/view&id='.$model->id;
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to($t),  'title' => Yii::t('app', 'View'),'class' => 'btn btn-info  custom_button']);
                    },

                    'update'=>function ($url, $model) {
                        $t = 'index.php?r=year-of-study/update&id='.$model->id;
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to($t), 'title' => Yii::t('app', 'Update'), 'class' => 'btn btn-success  custom_button']);
                    },


                ],
            ],
        ],
    ]); ?>
</div>

<?php
Modal::begin(['id'=>'modalView','size'=>'modal-small','header' => '<h3 align="center" style="color: red">View Details</h3>']);

echo "<div id='modalContentView'></div>";

Modal::end(); ?>


<?php
Modal::begin([
    'header' => '<h4 align="center" style="color: red">Year of Study</h4>',
    'id'     => 'modal',
    'size'   => 'modal-small',
]);

echo "<div id='modalContent'></div>";

Modal::end();

?>






<?php
$script=<<< JS
$(function (){
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});

///POP UP FOR VIEW AND UPDATE
$('.custom_button').click(function(){
    $('#modalView').modal('show').find('#modalContentView').load($(this).attr('value'));

});

JS;
$this->registerJs($script);
?>