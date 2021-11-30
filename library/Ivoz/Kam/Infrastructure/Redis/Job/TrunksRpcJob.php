<?php

namespace Ivoz\Kam\Infrastructure\Redis\Job;

use Ivoz\Core\Infrastructure\Persistence\Redis\RedisMasterFactory;
use Ivoz\Kam\Domain\Job\RpcJobInterface;
use Ivoz\Kam\Domain\Service\TrunksClientInterface;
use Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunk;
use Psr\Log\LoggerInterface;

class TrunksRpcJob implements RpcJobInterface
{
    public function __construct(
        private RedisMasterFactory $redisMasterFactory,
        private int $redisDb,
        private LoggerInterface $logger,
        private string $rpcEntity = ProxyTrunk::class,
        private int $rpcPort = 8001
    ) {
    }

    public function send(string $method, bool $retryOnError = false): void
    {
        try {
            if (!in_array($method, TrunksClientInterface::TRUNKS_ACTIONS, true)) {
                throw new \RuntimeException('Unexpected method ' . $method);
            }

            $redisClient = $this->redisMasterFactory->create(
                $this->redisDb
            );

            $channel = $retryOnError
                ? self::CHANNEL_RETRY_ON_ERROR
                : self::CHANNEL;

            $data = [
                'rpcEntity' => $this->rpcEntity,
                'rpcPort' => $this->rpcPort,
                'rpcMethod' => $method,
            ];

            $redisClient->rPush(
                $channel,
                \json_encode($data, JSON_THROW_ON_ERROR)
            );

            $redisClient->close();
        } catch (\Exception $e) {
            $this
                ->logger
                ->error(
                    $e->getMessage()
                );

            throw $e;
        }
    }
}
