<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AbsenteesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Absentent Days';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="absentees-index">



    <p align="right ">
        <?= Html::a('Add Absent days', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'staff_id','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
                return  $user->fname.' '.$user->lname;
            }],
            'days',
            'description:ntext',
            'category',
            'status',
            'created_at',
            'updated_at',
            ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
