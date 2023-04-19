<?php

use common\models\Semester;
use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SemesterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semesters';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>

<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>


<div class="semester-index">



    <?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-plus">Create New Semester</span>', ['create'], ['class' => 'btn btn-success']) ?>

        <?php
        $active_semester=Semester::find()->where(['status'=>'Active'])->one();

        if ($active_semester->name=='I'){
        ?>
        <?= Html::a('<span class="fa fa-share"> Change Semester</span>', ['semester/change-semester'], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to change semester I to semester II ?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }?>
        <?php }?>
    </p>

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'status',
            'created_at',
            'updated_at',
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
                            $url = 'index.php?r=staff/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],






            ],
        ],
    ]); ?>
</div>
