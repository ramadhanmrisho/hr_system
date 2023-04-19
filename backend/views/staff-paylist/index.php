<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StaffPaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paylists';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-paylist-index">


    <?php if (\common\models\UserAccount::userHas(['HR','ACC','ADMIN'])){?>

        <p>
            <?= Html::a('<span class="fa fa-file-text-o"> Generate Paylist</span>', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php }?>



    <?=\fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'month',

            ['attribute'=>'created_by','value'=>function($model){

                $staff=\common\models\Staff::find()->where(['id'=>$model->created_by])->one();
                return  $staff->fname.' '.$staff->lname;
            }],
            'created_at',


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
                            $url = 'index.php?r=staff-paylists/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],



            ],
        ],
    ]); ?>


</div>
