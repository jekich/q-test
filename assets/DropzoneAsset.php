<?php

namespace app\assets;
use yii\web\AssetBundle;

class DropzoneAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/dropzone/dropzone.css'
    ];
    public $js = [
        'plugins/dropzone/dropzone.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}