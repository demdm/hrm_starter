<?php

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoSetting $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Unsplash Search Photo Setting',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Unsplash Search Photo Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unsplash-search-photo-setting-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
