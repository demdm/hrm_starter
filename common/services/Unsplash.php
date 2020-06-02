<?php

namespace common\services;

use common\models\KeyStorageItem;
use Crew\Unsplash\HttpClient;
use Crew\Unsplash\PageResult;
use Crew\Unsplash\Search;

/**
 * Class Unsplash
 * @package common\services
 */
class Unsplash
{
    /**
     * Unsplash constructor.
     */
    public function __construct()
    {
        $accessKey = KeyStorageItem::find()->where(['key' => 'unsplash.access_key'])->one()->value;
        $secretKey = KeyStorageItem::find()->where(['key' => 'unsplash.secret_key'])->one()->value;
        $appName = KeyStorageItem::find()->where(['key' => 'unsplash.app_name'])->one()->value;

        HttpClient::init([
            'applicationId'	=> $accessKey,
            'secret'		=> $secretKey,
            'utmSource'     => $appName,
        ]);
    }

    /**
     * @param string $search
     * @param int $page
     * @param int $perPage
     * @param string|null $collections
     * @param string|null $orientation [multiple, comma-separated]
     *
     * @return PageResult
     */
    public function searchPhotos(
        string $search,
        int $page,
        int $perPage,
        ?string $collections = null,
        ?string $orientation = null
    ) : PageResult
    {
        return Search::photos($search, $page, $perPage, $orientation, $collections);
    }
}
