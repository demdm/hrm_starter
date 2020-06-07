<?php

namespace common\services;

use InstagramScraper\Model\Media;
use InstaLite\InstaLite;
use InstagramScraper\Instagram as InstagramScraper;

/**
 * Class Instagram
 * @package common\services
 */
class Instagram
{
    /**
     * @var InstaLite
     */
    private $instaLite;

    /**
     * @var InstagramScraper
     */
    private $instagramScraper;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * Instagram constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param string $photoPath
     * @param string $photoCaption [example: 'text #hash_tag']
     *
     * @return string|null
     *
     * @throws \InstaLite\Exception
     */
    public function publishPhoto(
        string $photoPath,
        string $photoCaption
    ) : ?string
    {
        return $this->getInstaLite()->uploadPhoto($photoPath, $photoCaption);
    }

    /**
     * @param string $mediaId
     * @param string $text
     * @param string|null $repliedToCommentId
     *
     * @return string|null
     * @throws
     */
    public function writeComment(
        string $mediaId,
        string $text,
        ?string $repliedToCommentId = null
    ) : ?string
    {
        return $this->getInstagramScraper()->addComment($mediaId, $text, $repliedToCommentId);
    }

    /**
     * @return Media[]
     * @throws \InstagramScraper\Exception\InstagramAuthException
     * @throws \InstagramScraper\Exception\InstagramException
     * @throws \InstagramScraper\Exception\InstagramNotFoundException
     */
    public function getMyMedias(): array
    {
        return $this->getInstagramScraper()->getMedias($this->username, 1000000);
    }

    /**
     * @return InstaLite
     */
    private function getInstaLite(): InstaLite
    {
        if (null === $this->instaLite) {
            $this->instaLite = new InstaLite($this->username, $this->password);
        }
        return $this->instaLite;
    }

    /**
     * @return InstagramScraper
     * @throws \InstagramScraper\Exception\InstagramAuthException
     * @throws \InstagramScraper\Exception\InstagramException
     */
    private function getInstagramScraper(): InstagramScraper
    {
        if (null === $this->instagramScraper) {
            $this->instagramScraper = InstagramScraper::withCredentials(
                $this->username,
                $this->password,
                new Cache()
            );
            $this->instagramScraper->login();
        }
        return $this->instagramScraper;
    }
}
