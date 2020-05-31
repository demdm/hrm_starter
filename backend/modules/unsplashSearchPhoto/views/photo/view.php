<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhoto $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Unsplash Search Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'setting_id',
                    'request_id',
                    'unsplash_id',
                    'raw_url:ntext',
                    'description:ntext',
                    'width',
                    'height',
                    'downloaded_at',
                    'created_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
