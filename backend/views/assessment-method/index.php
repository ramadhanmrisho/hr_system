<?php

use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssessmentMethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assessment Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="assessment-method-index">

    <?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
        <p>
            <?= Html::button('<span class=" fa fa-plus">Add Assessment Method</span>', ['id' => 'modalButton', 'value' => Url::to(['assessment-method/create']), 'class' => 'btn btn-success']) ?>
        </p>
    <?php }?>

    <?php

    Modal::begin([
        'header' => '<h4 align="center" style="color: red">Assessment Method Details</h4>',
        'id'     => 'modal',
        'size'   => 'modal-small',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            ['attribute'=>'nta_level','value'=>'nta_level','filter'=>[ '4' => '4', '5' => '5', '6' => '6' ]],
            ['attribute'=>'course_id','value'=>function($model){
                return $model->course->course_name;
            }, 'filter'=>ArrayHelper::map(\common\models\Course::find()->asArray()->all(), 'id', 'course_name'),],
            'created_at',
            'updated_at',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
                'header'=>"Action",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);
                    },
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=assessment-method/view&id='.$model->id;
                            return $url;
                        }

                    } ,
                ],
            ],
        ],
    ]); ?>


</div>
<?php
Modal::begin(['id'=>'modalView','size'=>'modal-small','header' => '<h3 align="center" style="color: red">Assessment Method Details</h3>']);

echo "<div id='modalContentView'></div>";

Modal::end(); ?>


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


<!--<script type="application/javascript">-->
<!--    window.onload = function(){-->
<!--        $(function(){-->
<!--            $('#modalButton').click(function(){-->
<!--                $('#modal').modal('show')-->
<!--                    .find('#modalContent').load($(this).attr('value'));-->
<!--            });-->
<!--        });-->
<!--    }-->
<!---->
<!--</script>-->
