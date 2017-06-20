<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "adminLte/bootstrap/css/bootstrap.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css",
        "adminLte/dist/css/AdminLTE.min.css",
        "adminLte/dist/css/skins/_all-skins.min.css",
        "adminLte/plugins/iCheck/flat/blue.css",
        "adminLte/plugins/morris/morris.css",
        "adminLte/plugins/jvectormap/jquery-jvectormap-1.2.2.css",
        "adminLte/plugins/datepicker/datepicker3.css",
        "adminLte/plugins/daterangepicker/daterangepicker.css",
        "adminLte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css",

    ];
    public $js = [
        "https://code.jquery.com/ui/1.11.4/jquery-ui.min.js",
        "adminLte/bootstrap/js/bootstrap.min.js",
        "adminLte/plugins/sparkline/jquery.sparkline.min.js",
        "adminLte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
        "adminLte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
        "adminLte/plugins/knob/jquery.knob.js",
        "adminLte/plugins/slimScroll/jquery.slimscroll.min.js",
        "adminLte/plugins/fastclick/fastclick.js",
        "adminLte/dist/js/app.min.js",
        'js/common.js'
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
