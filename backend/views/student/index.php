<?php

use common\models\Semester;
use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$title=Yii::$app->request->get('authorization');

if ($title=='clinical_1'){
    $student_tittle='BASIC TECHNICIAN CERTIFICATE IN CLINICAL MEDICINE STUDENTS';
}
if ($title=='clinical_2'){
    $student_tittle='TECHNICIAN CERTIFICATE IN CLINICAL MEDICINE STUDENTS';
}
if ($title=='clinical_3'){
    $student_tittle='DIPLOMA IN CLINICAL MEDICINE STUDENTS';
}
if ($title=='nursing_1'){
    $student_tittle='BASIC TECHNICIAN CERTIFICATE IN NURSING AND MIDWIFERY STUDENTS';
}
if ($title=='nursing_2'){
    $student_tittle='TECHNICIAN CERTIFICATE IN NURSING AND MIDWIFERY STUDENTS';
}
if ($title=='nursing_3'){
    $student_tittle='ORDINARY DIPLOMA IN NURSING AND MIDWIFERY STUDENTS';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <span class="fa fa-check-square-o">  Successfully Moved to next level</span>
        <?= Yii::$app->session->getFlash('gSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>


<h4><?= Html::encode($student_tittle)?></h4>


<div class="student-index">
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>

    <?php if (\common\models\UserAccount::userHas(['HOD','ADMIN'])){?>
    <p>


        <?= Html::a('<span class="fa fa-user-plus">Add New Student', ['create'], ['class' => 'btn btn-success']) ?>


        <?php
        $active_semester=Semester::find()->where(['status'=>'Active'])->one();

        if ($active_semester->name=='II' && ($title=='clinical_1'|| $title=='clinical_2' || $title=='nursing_1'|| $title=='nursing_2')){
        ?>
        <button type="button"  onclick="return confirm('Are you sure you want to move these students to next level?')" id="dco" class="btn btn-danger pull-right"> <span class="fa fa-share-square-o"> Next Level</span></button>
        <?php }?>
    </p>

    <?php }?>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'registration_number',

                ['attribute'=>'student_id','value'=>function($model){
                return $model->fname.' '.$model->lname;},'label'=>'Student Name'],

            'phone_number',
            'intake_type',
            'gender',

            ['class' =>'yii\grid\ActionColumn',

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
                            $url = 'index.php?r=student/view&id='.$model->id;
                            return $url;
                        }
                    } ,

                ],

            ],
             [
                 'class' => 'yii\grid\CheckboxColumn',
                 // you may configure additional properties here

                 'checkboxOptions' => function($model, $key, $index, $column) {


                 }
             ],

        ],
    ]);


    $gridColumns= [
        ['class' => 'yii\grid\SerialColumn'],

        'registration_number',

          ['attribute'=>'student_id','value'=>function($model){
            return $model->fname.' '.$model->lname;},'label'=>'Student Name'],
    ];

    

echo '<div class="btn-info col-sm-3" style="font-family: Cambria"> Download Registered Students';


    echo '</div>'.'<br>';
    echo '<div class="col-sm-3">';

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'showConfirmAlert'=>true,
        'filename'=> 'KCOHAS- Registered Students',
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_EXCEL => false,
        ],
    ]);
echo '</div>';
    ?>
</div>


<?php
//TO BE UN COMMENTED SECOND SEMESTER
$studenturl = Url::toRoute(['/student/promote','authorization'=>$title]);

$script=<<< JS


$(document).ready(function () {  
    
$('#dco').on('click',function(e) {
      e.preventDefault();    
var strValue = "";        
    $('input[name="selection[]"]:checked').each(function() {

    if(strValue!=="")
        {
        strValue = strValue + " , " + this.value;

        }
    else 
      strValue = this.value;     

});       

$.ajax({
    url: '$studenturl',
    type: 'POST',
    data: {data:strValue},         
    success: function(data) {
        window.location.reload();
    }
    
});


});
});



JS;
$this->registerJs($script);
?>