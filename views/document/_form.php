<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DropzoneAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */

DropzoneAsset::register($this);
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>



    <form action="<?= \yii\helpers\Url::to(['/file/upload', 'id' => $model->id]) ?>" class="dropzone">
        <div class="fallback">
            <input name="UploadForm[file]" type="file" multiple />
            <input type="hidden" name="_csrf" value="<?= Yii::$app->getRequest()->getCsrfToken(); ?>"/>
        </div>
    </form>



<!--    --><?php
//
//    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
//    ?>
<!---->
<!--    --><?//= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>
<!---->
<!--    <button>Submit</button>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
</div>
