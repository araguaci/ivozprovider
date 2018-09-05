<?php

namespace Ivoz\Provider\Domain\Service\Carrier;

class IncrementBalance extends AbstractBalanceOperation
{
    /**
     * @param $carrierId
     * @param float $amount
     * @return boolean
     */
    public function execute($carrierId, float $amount)
    {
        $this->logger->info('Carrier#%s\'s balance will be incremented by ' . $amount);
        $carrier = $this->carrierRepository->find($carrierId);
        $response = $this->client->incrementBalance($carrier, $amount);

        return $this->handleResponse(
            $amount,
            $response,
            $carrier
        );
    }
}
