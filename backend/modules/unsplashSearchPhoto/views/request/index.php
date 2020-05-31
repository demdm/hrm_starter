<?php

use common\models\UnsplashSearchPhotoSetting;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\unsplashSearchPhoto\models\search\UnsplashSearchPhotoRequestSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Unsplash Search Photo Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-request-index">
    <div class="card">
        <div class="card-header"></div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'label' => Yii::t('backend', 'Setting Name'),
                        'attribute' => 'setting_id',
                        'value' => 'setting.name',
                        'filter' => UnsplashSearchPhotoSetting::find()
                            ->select(['name', 'id'])
                            ->orderBy('name')
                            ->indexBy('id')
                            ->column()
                        ,
                    ],
                    'page',
                    'count_result',
                    [
                        'format' => 'datetime',
                        'attribute' => 'created_at',
                    ],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
