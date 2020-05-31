<?php

namespace common\services;

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
        HttpClient::init([
            'applicationId'	=> env('UNSPLASH_ACCESS_KEY'),
            'secret'		=> env('UNSPLASH_SECRET_KEY'),
            'utmSource'     => env('UNSPLASH_APPLICATION_NAME'),
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
