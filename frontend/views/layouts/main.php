<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\Url;

yiister\adminlte\assets\Asset::register($this);


$admin=\common\models\Designation::find()->where(['id'=>2])->one();

$date=date('M');

$time = new \DateTime('now');
$today = $time->format('Y-m-d');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->
    <?php $this->head() ?>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-purple sidebar-mini" >
<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Main Header -->
   <header class="main-header" style="font-family: Cambria" >

        <!-- Logo -->
        <a href="/" class="logo" style="font-family: Cambria">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Kabanga</b>COHAS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Kabanga COHAS</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-book"></i>
                            <span class="label label-warning"><?php echo 'CLASS TIME TABLE' ; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"> </li>
                            <ul>
                                <?php
                                $user_id=\common\models\UserAccount::find()->where(['id'=>Yii::$app->user->identity->getId()])->one()->user_id;

                                $student=\common\models\Student::find()->where(['id'=> $user_id])->one()->course_id;
                                
                                $time_table_exist=\common\models\TimeTable::find()->where(['course_id'=>$student])->exists();
                                if($time_table_exist){
                                $time_table=\common\models\TimeTable::find()->where(['course_id'=>$student])->one()->time_table;

                                }
                                else{
                                    $time_table='';
                                }
                                ?>
                                <div><?= Html::a('View Time Table here', 'https://kabangacms.ac.tz/kcohas/backend/web/time_tables/'.$time_table, ['target' => '_blank', ]) ?></div>
                            </ul>
                        </ul>
                    </li>


                    <!-- Message Menu Begin -->

                    <!-- Message  Menu End -->

                    <!-- Notifications Menu -->

                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                       
                        <ul class="dropdown-menu">
                            <li class="header">Shopping Cart</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Todays Credit Sales
                                                <small class="pull-right"><?php echo 100/100?>%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: <?php echo 100/100?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <?php echo Html::a('<b>View all Sales</b>',['/sales-list/index'])?>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->

                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">
                                Hello ,
                                <?php
                                $user_id=\common\models\UserAccount::find()->where(['id'=>Yii::$app->user->identity->getId()])->one()->user_id;
                                $student=\common\models\Student::find()->where(['id'=>$user_id])->one();

                                echo $student->fname.' '.$student->lname;
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <?php
                                $user_id=\common\models\UserAccount::find()->where(['id'=>Yii::$app->user->identity->getId()])->one()->user_id;

                                $student=\common\models\Student::find()->where(['id'=> $user_id])->one();

                              echo  Html::a(Html::img('https://kabangacms.ac.tz/kcohas/backend/web/student_photo/'.$student->passport_size, ['class'=>'img-circle', 'height'=>'100px', 'width'=>'100px']));
                                ?>


                                <p>
                                    <?php
                                    if(!Yii::$app->user->isGuest) {
                                        echo   Yii::$app->user->identity->username;
                                    }
                                    else{
                                        echo '';
                                    }
                                    ?>

                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer" style="background-color:grey">
                                <div class="pull-left">

                                    <?=Html::a('<span style="color: black" class="fa fa-lock"> Change Password</span>',['/user-account/change-password'],['data-method'=>'post','class'=>'btn btn-default btn-block'])?>



                                </div>
                                <div class="pull-right">
                                    <?=Html::a('<span style="color: black" class="fa fa-sign-out">Sign out</span>',['/site/logout'],['data-method'=>'post','class'=>'btn btn-default btn-block'])?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="images/logo.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php

                        if (!Yii::$app->user->isGuest) {
                          echo 'STUDENT';


                        }?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-`12btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <div style="font-family: 'Lucida Bright'">
            <?php
            if(Yii::$app->user->isGuest){
                $menuItems[]=['label'=>'login','Url'=>['/site/login']];
            }
            else{
                $menuItems=[

                    ["label" => "Home", "url" => ["site/index"], "icon" => "home"],

                    ["label"=>"My Profile","url"=>["student/view",'id'=>Yii::$app->user->identity->user_id],"icon"=>"user"],
                    ["label" => "My Course", "url" => ["course/index"], "icon" => "book"],
                    ["label"=>"My Course Works","url"=>'#',"icon"=>"pencil-square-o",
                        "items"=>[
                            ["label"=>"NTA 4","url"=>["coursework-nta4/index"],"icon"=>"pencil-square"],
                            ["label"=>"NTA 5","url"=>["coursework-nta5/index"],"icon"=>"pencil-square"],
                            ["label"=>"NTA 6","url"=>["coursework-nta6/index"],"icon"=>"pencil-square"],
                        ],],
                    ["label"=>"My Course Results","url"=>'#',"icon"=>"pencil-square-o",
                        "items"=>[
                            ["label"=>"NTA 4","url"=>["exam-result/index",'year'=>'year_1'],"icon"=>"fa fa-file-o"],
                            ["label"=>"NTA 5","url"=>["exam-result/index",'year'=>'year_2'],"icon"=>"fa fa-file-o"],
                            ["label"=>"NTA 6","url"=>["exam-result/index",'year'=>'year_3'],"icon"=>"fa fa-file-o"],
                        ],
                    ],
                  //  ["label"=>"Class Time Table","url"=>["course-work/index"],"icon"=>"cart-plus"],

                ];

            }
            ?>
            <?= \yiister\adminlte\widgets\Menu::widget(["items"=>$menuItems])?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">`
        <!-- Content Header (Page header)-->
        <section class="content-header">
            <h1>
                <?= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : $this->title) ?>
            </h1>
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?=
                \yii\widgets\Breadcrumbs::widget(
                    [
                        'encodeLabels' => false,
                        'homeLink' => [
                            'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Home',
                            'url' => ['site/index'],
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ]
                )
                ?>
            <?php endif; ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->

        <!-- Default to the left -->
        <strong>Copyright &copy; <a href="#">Kabanga College of Health and Allied Sciences</a> <?= date("Y") ?>
    </footer>


    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

