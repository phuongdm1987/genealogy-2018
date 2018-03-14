<?php
declare(strict_types=1);

namespace Genealogy\Helpers;

/**
 * Trait SendsAlerts
 * @package App\Helpers
 */
trait SendsAlerts
{
    /**
     * @param string|null $id
     * @param array $parameters
     */
    protected function success(string $id = null, array $parameters = [])
    {
        $this->sendAlert('success', $id, $parameters);
    }

    /**
     * @param string|null $id
     * @param array $parameters
     */
    protected function error(string $id = null, array $parameters = [])
    {
        $this->sendAlert('error', $id, $parameters);
    }

    /**
     * @param string $type
     * @param string|null $id
     * @param array $parameters
     */
    private function sendAlert(string $type, string $id = null, array $parameters = [])
    {
        session([$type => trans($id, $parameters)]);
    }
}
