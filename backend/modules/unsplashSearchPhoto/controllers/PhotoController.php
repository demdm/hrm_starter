<?php

namespace backend\modules\unsplashSearchPhoto\controllers;

use Yii;
use common\models\UnsplashSearchPhoto;
use backend\modules\unsplashSearchPhoto\models\search\UnsplashSearchPhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PhotoController implements the CRUD actions for UnsplashSearchPhoto model.
 */
class PhotoController extends Controller
{
    /**
     * Lists all UnsplashSearchPhoto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnsplashSearchPhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UnsplashSearchPhoto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the UnsplashSearchPhoto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UnsplashSearchPhoto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UnsplashSearchPhoto::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
