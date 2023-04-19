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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <!--    echo Yii::app()->request->baseUrl ."/images/file.jpg";-->

    <div>
            <h2 align="center"  style="color:white;font-family: Cambria" > KABANGA COHAS  SIS </h2>
    </div>


    <body class="login-page" style='background-color:lightslategrey ' style="overflow:hidden" >

    <?php $this->beginBody()?>
    <?=$content?>

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>