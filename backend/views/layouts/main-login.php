<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
yiister\adminlte\assets\Asset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>"
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <link rel="icon" type="image/png" href="<?= Yii::$app->request->baseUrl ?>/images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <!--    echo Yii::app()->request->baseUrl ."/images/file.jpg";-->

  
     
  
    <body class="login-page" style='background-image: url("images/t1.png")' style="overflow:hidden" >
           <h2 align="center"  style="color:white;font-family:'Cambria';" >Human Resource & Payroll System</h2>

    <?php $this->beginBody()?>
    <?=$content?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>