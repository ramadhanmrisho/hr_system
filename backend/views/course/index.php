<?php

use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>


<div class="course-index">
<?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
    <p>
        <?= Html::button('<span class=" fa fa-plus">Add Course</span>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['course/create']), 'class' => 'btn btn-success']) ?>
    </p>
    <?php }?>

    <?php

    Modal::begin([
        'header' => '<h4 align="center" style="color: red">Course Details</h4>',
        'id'     => 'modal',
        'size'   => 'modal-small',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

    ?>
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'course_name',
            'duration_in_years',
            ['attribute'=>'abbreviation','value'=>'abbreviation','visible'=>\common\models\UserAccount::userHas(['ADMIN'])],
            ['attribute'=>'department_id','value'=>function($model){
                
                return $model->department->name;
            }],

            ['class' => 'yii\grid\ActionColumn',

                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
                'header'=>"ACTION",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [
                    //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);


                    },

                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=course/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],






            ],
        ],
    ]); ?>

</div>

<?php
Modal::begin(['id'=>'modalView','size'=>'modal-small','header' => '<h3 align="center" style="color: red">Course Details</h3>']);

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