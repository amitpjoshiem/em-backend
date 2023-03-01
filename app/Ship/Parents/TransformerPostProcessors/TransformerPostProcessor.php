<?php

namespace App\Ship\Parents\TransformerPostProcessors;

use App\Ship\Core\Abstracts\Transporters\Transporter;

/**
 * Class TransformerPostProcessor.
 */
abstract class TransformerPostProcessor
{
    protected Transporter $transporter;

    /**
     * @param array $transformedData Data with applyed Transformers
     */
    abstract public function postProcess(array $transformedData): array;

    /**
     * Store parameter for postProcess method.
     */
    public function withTransport(Transporter $parameter): self
    {
        $this->transporter = $parameter;

        return $this;
    }
}
