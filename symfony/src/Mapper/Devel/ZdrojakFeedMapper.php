<?php

namespace App\Mapper\Devel;

use App\DTO\ZdrojakFeedDTO;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ZdrojakFeedMapper {

    /**
     * @var XmlEncoder
     */
    protected $encoder;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * ZdrojakFeedMapper constructor.
     * @param EncoderInterface $encoder
     * @param SerializerInterface $serializer
     */
    public function __construct(EncoderInterface $encoder, SerializerInterface $serializer) {
        $this->encoder = $encoder;
        $this->serializer = $serializer;
    }

    /**
     * @param $feedContent
     * @return ZdrojakFeedDTO[]
     */
    public function mapRawFeedToCollection($feedContent)
    {
        $contentFiltered = $this->filterOutHeader($feedContent);

        return $this->serializer->deserialize(json_encode($contentFiltered), 'array<' . ZdrojakFeedDTO::class . '>', 'json');
    }

    /**
     * @param string $feedContent
     * @return array
     */
    protected function filterOutHeader($feedContent)
    {
        $encodedContent = $this->encoder->decode($feedContent, 'xml');
        $channelContent = $encodedContent['channel'];

        return $channelContent['item'];
    }
    
}