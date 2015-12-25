<?php
/**
 * Created by PhpStorm.
 * User: stevenh
 * Date: 12/24/15
 * Time: 10:05 PM
 */

namespace Era\Domain\Home\AppService;


use Aura\Payload\Payload;
use Aura\Payload_Interface\PayloadStatus;

class Home
{
    private $payload;

    /**
     * Home constructor.
     * @param $payload
     */
    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }


    public function __invoke(array $input)
    {
        return $this->payload
            ->setStatus(PayloadStatus::SUCCESS)
            ->setOutput(['key' => 'Hello World']);
    }
}
