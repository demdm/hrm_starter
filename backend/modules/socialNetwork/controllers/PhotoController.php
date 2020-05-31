<?php

namespace backend\modules\socialNetwork\controllers;

use Yii;
use common\models\SocialNetworkPhoto;
use backend\modules\socialNetwork\models\search\SocialNetworkPhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PhotoController implements the CRUD actions for SocialNetworkPhoto model.
 */
class PhotoController extends Controller
{
    /**
     * Lists all SocialNetworkPhoto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SocialNetworkPhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SocialNetworkPhoto model.
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
     * Updates an existing SocialNetworkPhoto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Finds the SocialNetworkPhoto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SocialNetworkPhoto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SocialNetworkPhoto::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
