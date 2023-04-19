<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PdfViewerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/pdf/viewer.css',
    ];
    public $js = [
        'js/pdf/pdf.js',
        'js/pdf/viewer.js',
    ];
    public $depends = [];
}
