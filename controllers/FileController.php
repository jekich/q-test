<?php

namespace app\controllers;

use Yii;
use app\models\File;
use app\models\FileSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\JsonResponseFormatter;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii\web\BadRequestHttpException;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionSend($fileName)
    {
        $model = File::find()
            ->andWhere(['name' => $fileName])
            ->one();
        if (!$model) {
            throw new  BadRequestHttpException();
        }

        return Yii::$app->response->sendFile($model->getFilePath(), $model->original_name);
    }

    public function actionUpload($id)
    {
        $model = new UploadForm();

        $result = [
            'status' => 'error',
        ];

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstanceByName('file');
            $model->ownerId = $id;

            if ($model->save()) {
                $result = [
                    'status' => 'success',
                    'data' => [
                        'id' => $model->getFileModel()->id,
                    ]
                ];
            }
        }

        return Json::encode($result);
    }

    /**
     * Displays a single File model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        if ($this->findModel(Yii::$app->request->post('id'))->fileDelete()) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'error'];
        }

        return Json::encode($result);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
