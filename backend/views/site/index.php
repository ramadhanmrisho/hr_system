<?php

/* @var $this yii\web\View */

use common\models\AcademicYear;
use common\models\Course;
use common\models\Student;
use common\models\YearOfStudy;

?>

<?php
if(Yii::$app->session->hasFlash('reqSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('reqSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('reqDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('reqDanger');?>
    </div>
<?php endif;?>




<div class="site-index" style="font-family: Cambria;width:100%">

        <div class="box box-primary" >
            <div class="box-body">

<?php if (\common\models\UserAccount::userHas(['HOD','PR','HR','ADMIN','ACADEMIC'])){?>
                <?php \yiister\adminlte\widgets\Callout::begin(["type" => \yiister\adminlte\widgets\Callout::TYPE_INFO]); ?>
                <h4>STAFFS</h4>
                <p>A summmary of  KCOHAS  Staffs</p>
                <?php \yiister\adminlte\widgets\Callout::end(); ?>

                <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_MAROON,
                                "header" => \common\models\Staff::find()->where(['category'=>'Academic Staff'])->count(),
                                "icon" => "group",
                                "text" => "<b>Academic Staff</b>",
                                'linkRoute'=>['/staff/index','category'=>'academic']
                            ]
                        )
                        ?>

                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_AQUA,
                                "header" =>  \common\models\Staff::find()->where(['category'=>'Non Academic Staff'])->count(),
                                "icon" => "group",
                                "text" => "<b>Non Academic Staff </b>",
                                'linkRoute'=>['/staff/index','category'=>'non_academic']
                            ]
                        )
                        ?>
                    </div>
<?php }?>

    <?php
    $assigned_module=\common\models\AssignedModule::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])->exists();
    $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;


    if ($assigned_module){
    ?>
                <?php \common\models\UserAccount::userHas(['AS'])?>
                     <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_LIGHT_BLUE,
                                "header" =>\common\models\AssignedModule::find()->where(['staff_id'=>Yii::$app->user->identity->user_id,'academic_year_id'=>$current_academic_year])->count(),
                                "icon" => "slideshare",
                                "text" => "<b>Assigned Modules</b>",
                                'linkRoute'=>['assigned-module/index']
                            ]
                        )
                        ?>

                    </div>
                    <?php }?>


                      <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_PURPLE,
                                "header" => 'Profile',
                                "icon" => "user",
                                "text" => "<br>",
                                'linkRoute'=>['staff/view', 'id' =>Yii::$app->user->identity->user_id]
                            ]
                        )
                        ?>

                    </div>
            </div>


            <br>
            <br>

            <?php
             $nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
             $nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
             $nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;

              $cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
              $cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
              $cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;
            $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;
            ?>
<?php
if (\common\models\UserAccount::userHas(['HOD','PR','HR','ADMIN','ACADEMIC'])){
?>
            <div class="box-body">
                <?php \yiister\adminlte\widgets\Callout::begin(["type" => \yiister\adminlte\widgets\Callout::TYPE_SUCCESS]); ?>
                <h4>STUDENTS</h4>
                <p>A summmary of  KCOHAS  Students</p>
                <?php \yiister\adminlte\widgets\Callout::end(); ?>
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <?=
                        yiister\adminlte\widgets\InfoBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_AQUA,
                                "icon" => "user-md",
                                "text" => "NTA 4",
                                "number" => "Clinical Medicine:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$cm1,])->count(),
                                "filled" => true,
                                "progress" => 100,
                                "progressDescription" =>  "<b>Nursing and Midwifery:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$nm1])->count(),
                            ]
                        )
                        ?>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <?=
                        yiister\adminlte\widgets\InfoBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_LIGHT_BLUE,
                                "icon" => "user-md",
                                "text" => "NTA 5",
                                "number" => "Clinical Medicine:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$cm2])->count(),
                                "filled" => true,
                                "progress" => 100,
                                "progressDescription" =>  "<b>Nursing and Midwifery:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$nm2])->count(),
                            ]
                        )
                        ?>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <?=
                        yiister\adminlte\widgets\InfoBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_PURPLE,
                                "icon" => "user-md",
                                "text" => "NTA 6",
                                "number" => "Clinical Medicine:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$cm3])->count(),
                                "filled" => true,
                                "progress" => 100,
                                "progressDescription" =>  "<b>Nursing and Midwifery:". Student::find()->where(['academic_year_id'=>$current_academic_year,'course_id'=>$nm3])->count(),
                            ]
                        )
                        ?>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <?=
                        yiister\adminlte\widgets\InfoBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_MAROON,
                                "icon" => "users",
                                "text" => "Total Students",
                                "number" =>Student::find()->where(['academic_year_id'=>$current_academic_year])->count(),
                                "filled" => true,
                                "progress" => 50,
                            ]
                        )
                        ?>
                    </div>
                </div>

            </div>

            <?php }?>