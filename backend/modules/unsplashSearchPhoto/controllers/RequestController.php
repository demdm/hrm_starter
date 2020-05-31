<?php

namespace backend\modules\unsplashSearchPhoto\controllers;

use Yii;
use backend\modules\unsplashSearchPhoto\models\search\UnsplashSearchPhotoRequestSearch;
use yii\web\Controller;

/**
 * RequestController implements the CRUD actions for UnsplashSearchPhotoRequest model.
 */
class RequestController extends Controller
{
    /**
     * Lists all UnsplashSearchPhotoRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnsplashSearchPhotoRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
