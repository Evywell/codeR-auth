<?php


namespace App\Normalizers;


use App\Database\Entity\Ticket;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TicketNormalizer implements ContextAwareNormalizerInterface
{

    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Ticket;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $this->normalizer->normalize(
            $object,
            $format,
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'email',
                    'game'
                ]
            ]
        );
    }
}