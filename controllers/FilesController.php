<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use app\models\FilesSearch;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
{

    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Files();
        if(Yii::$app->request->isAjax) {
            //prepare response formate
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
                return ActiveForm::validate($model);
            }
            return [
                $this->renderAjax('create', ['model'=>$model])
            ];
        } elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Files model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     */
    public function actionDownload(int $id)
    {
        $file = Files::findOne($id);
        if (!is_null($file)) {
            $zipFile = Yii::getAlias($file->webroot.$file->path);
            if($zipFile !== false){
                Yii::$app->getResponse()->sendFile($zipFile);
                $file->downloaded += 1;
                $file->save();
            }
        }
    }

    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws MethodNotAllowedHttpException
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            if (Yii::$app->user->id == $model->user_id) {
                return $model;
            }
        }

        throw new MethodNotAllowedHttpException('Not allowed action');
    }
}
