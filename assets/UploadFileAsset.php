<?php

namespace app\assets;
use yii\web\AssetBundle;

class UploadFileAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/uploadFiles.js'
    ];
    public $depends = [
        'app\assets\DropzoneAsset',
    ];
}