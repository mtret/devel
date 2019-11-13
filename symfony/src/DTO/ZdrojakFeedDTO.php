<?php

namespace App\DTO;

use DateTime;
use Exception;
use JMS\Serializer\Annotation as Serializer;

class ZdrojakFeedDTO {

    /**
     * @Serializer\Type("string")
     * @var string
     */
    protected $title;

    /**
     * @Serializer\Type("string")
     * @var string
     */
    protected $link;

    /**
     * @Serializer\SerializedName("pubDate")
     * @Serializer\Type("string")
     * @var string
     */
    protected $pubDate;

    /**
     * @return string
     */
    public function getTitle()
    : string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    : void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLink()
    : string {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    : void {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getPubDate()
    : string {
        return $this->pubDate;
    }

    /**
     * @param string $pubDate
     */
    public function setPubDate(string $pubDate)
    : void {
        $this->pubDate = $pubDate;
    }

    /**
     * @return false|int
     */
    public function isNews()
    {
        return (bool)strpos($this->getLink(), '/zpravicky/');
    }

    /**
     * @return false|int
     */
    public function isArticle()
    {
        return (bool)strpos($this->getLink(), '/clanky/');
    }

    /**
     * @throws Exception
     */
    public function isFromLastWeek()
    : bool {
        $nowMinus168Hours = (new DateTime())->modify('-168 hours');
        $publishedDate = new DateTime($this->getPubDate());

        return $publishedDate > $nowMinus168Hours;
    }

}