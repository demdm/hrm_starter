<?php

use common\models\UnsplashSearchPhotoSetting;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\unsplashSearchPhoto\models\search\UnsplashSearchPhotoSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Unsplash Search Photos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-index">
    <div class="card">
        <div class="card-header">
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
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
                        'label' => Yii::t('backend', 'Search Words'),
                        'attribute' => 'setting_id',
                        'value' => 'setting.search',
                        'filter' => UnsplashSearchPhotoSetting::find()
                            ->select(['search', 'id'])
                            ->orderBy('search')
                            ->indexBy('id')
                            ->column()
                        ,
                    ],
                    // 'unsplash_id',
                    // 'raw_url:ntext',
                     'description:ntext',
                    // 'width',
                    // 'height',
                    [
                        'attribute' => 'downloaded_at',
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{view}',
                    ],
                ],
            ]) ?>
    
        </div>
        <div class="card-footer">
            <?= getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
