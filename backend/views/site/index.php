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
                <h4>EMPLOYEE DASHBOARD</h4>
                <p>Employee Statistics</p>
                <?php \yiister\adminlte\widgets\Callout::end(); ?>

                <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_TEAL,
                                "header" => \common\models\Staff::find()->count(),
                                "icon" => "group",
                                "text" => "<b>Total Employee</b>",
                                'linkRoute'=>['/staff/index','category'=>'academic']
                            ]
                        )
                        ?>

                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_FUCHSIA_ACTIVE,
                                "header" =>  \common\models\Staff::find()->where(['category'=>'Non Academic Staff'])->count(),
                                "icon" => "group",
                                "text" => "<b>Employee with Expired Contract</b>",
                                'linkRoute'=>['/staff/index','category'=>'non_academic']
                            ]
                        )
                        ?>
                    </div>
                       <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_LIGHT_BLUE,
                                "header" =>  \common\models\Staff::find()->where(['category'=>'Non Academic Staff'])->count(),
                                "icon" => "group",
                                "text" => "<b>Employee On Leave </b>",
                                'linkRoute'=>['/staff/index','category'=>'non_academic']
                            ]
                        )
                        ?>
                    </div>
<?php }?>
                      <div class="col-lg-3 col-xs-6">
                        <?=
                        \yiister\adminlte\widgets\SmallBox::widget(
                            [
                                "color" => \yiister\adminlte\components\AdminLTE::BG_YELLOW,
                                "header" => '<b style="font-family: Lucida Bright" >My Profile</b>',
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



        </div>


                <div class="row">



                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--                            <script type="text/javascript">-->
<!--                                google.charts.load("current", {packages:["corechart"]});-->
<!--                                google.charts.setOnLoadCallback(drawChart);-->
<!--                                function drawChart() {-->
<!--                                    var data = google.visualization.arrayToDataTable([-->
<!---->
<!--                                        ['Department', 'Number of Staff'],-->
<!--                                        ['Administration',     11],-->
<!--                                        ['Human Resource',      2],-->
<!--                                        ['ICT',  2],-->
<!--                                        ['Procurement', 2],-->
<!--                                        ['Other',    7]-->
<!--                                    ]);-->
<!---->
<!--                                    var options = {-->
<!--                                        title: 'Employee by Departments',-->
<!--                                        is3D: true,-->
<!--                                    };-->
<!---->
<!--                                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));-->
<!--                                    chart.draw(data, options);-->
<!--                                }-->
<!--                            </script>-->
                    <script type="text/javascript">
                        google.charts.load("current", { packages: ["corechart"] });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var jsonData = [
                                ['Department', 'Number of Staff'],
                                <?php
                                // Fetch data directly using Yii2 Active Record
                                $data = \common\models\Staff::find()
                                    ->select(['department.name as Department', 'COUNT(*) as `Number of Staff`'])
                                    ->leftJoin('department', 'staff.department_id = department.id')
                                    ->groupBy('staff.department_id')
                                    ->asArray()
                                    ->all();
                                foreach ($data as $row) {
                                    echo '["' . $row['Department'] . '", ' . (int)$row['Number of Staff'] . '],';
                                }
                                ?>
                            ];

                            var data = google.visualization.arrayToDataTable(jsonData);

                            var options = {
                                title: 'Employee by Departments',
                                is3D: true,
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                            chart.draw(data, options);
                        }
                    </script>

                    <script type="text/javascript">
                        google.charts.load("current", {packages:["corechart"]});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var jsonData = [
                                ['Gender', 'Number'],
                                <?php
                                // Fetch data directly using Yii2 Active Record
                                $data = \common\models\Staff::find()
                                    ->select(['gender', 'COUNT(*) as `Number`'])
                                    ->groupBy('gender')
                                    ->asArray()
                                    ->all();

                                foreach ($data as $row) {
                                    $gender = ($row['gender'] === 'Male') ? 'Male' : 'Female'; // Assuming 'M' for Male and 'F' for Female, update accordingly
                                    echo '["' . $gender . '", ' . (int)$row['Number'] . '],';
                                }
                                ?>
                            ];

                            var data = google.visualization.arrayToDataTable(jsonData);

                            var options = {
                                title: 'Employees by Gender',
                                is3D: true,
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3c'));
                            chart.draw(data, options);
                        }
                    </script>



                </div>
    <div class="box box-info" >
                <div class="box-body">
                    <div class="col-lg-6 col-xs-6">
                        <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
                    </div>
                     <div class="col-lg-6 col-xs-6">
                        <div id="piechart_3c" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>

</div>



