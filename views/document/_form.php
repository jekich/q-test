<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\UploadFileAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */

UploadFileAsset::register($this);

?>


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#document-form" aria-controls="document-form" role="tab"
                                              data-toggle="tab">Documen form</a></li>
    <li role="presentation"><a href="#document-files" aria-controls="document-files" role="tab"
                               data-toggle="tab">Files</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="document-form">
        <div class="document-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'id')->hiddenInput() ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>



            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="document-files">
        <?php
        $url = \yii\helpers\Url::to(['/file/upload', 'id' => $model->id]);
        $deleteUrl = \yii\helpers\Url::to(['/file/delete']);


        $fileList = [];
        foreach ($model->files as $file) {
            $fileList[] = [
                'id' => $file->id,
                'name' => $file->original_name,
                'thumb' => ($file->is_image) ? \yii\helpers\Url::to(['/file/send', 'fileName' => $file->name]) : false,
                'size' => $file->size
            ];
        }

        $this->registerJs('
             var uploadObj = new uploadFile("' . $url . '", "' . $deleteUrl . '", \'' . \yii\helpers\Json::encode($fileList) . '\' );
        ');

        ?>

        <form id="fileZone" action="<?= \yii\helpers\Url::to(['/file/upload', 'id' => $model->id]) ?>" class="dropzone">
            <div class="fallback">
                <input name="UploadForm[file]" type="file" multiple/>
                <input type="hidden" name="_csrf" value="<?= Yii::$app->getRequest()->getCsrfToken(); ?>"/>
            </div>
        </form>


    </div>
</div>
