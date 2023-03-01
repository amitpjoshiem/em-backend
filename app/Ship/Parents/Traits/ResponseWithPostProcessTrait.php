<?php

namespace App\Ship\Parents\Traits;

use App\Ship\Core\Abstracts\Transformers\Transformer;
use App\Ship\Parents\Exceptions\InvalidTransformerPostProcessorException;
use App\Ship\Parents\TransformerPostProcessors\TransformerPostProcessor;

trait ResponseWithPostProcessTrait
{
    /**
     * @param Transformer|mixed $transformerName           The transformer (e.g., Transformer::class or new Transformer()) to be applied
     * @param array             $transformerPostProcessors Array of TransformerPostProcessor to be applied
     * @param array             $includes                  additional resources to be included
     * @param array             $meta                      additional meta information to be applied
     * @param null              $resourceKey               the resource key to be set for the TOP LEVEL resource
     */
    public function transformWithPostProcess(
        $data,
        $transformerName = null,
        $transformerPostProcessors = [],
        array $includes = [],
        array $meta = [],
        $resourceKey = null
    ): array {
        // call origin transform method for getting data
        $transformedData = $this->transform(
            $data,
            $transformerName,
            $includes,
            $meta,
            $resourceKey
        );

        // process $transformedData using transformerPostProcessors
        foreach ($transformerPostProcessors as $processor) {
            // first, we need to create the transformer
            if ($processor instanceof TransformerPostProcessor) {
                // check, if we have provided a respective TransformerPostProcessor class
                $instance = $processor;
            } else {
                // of if we just passed the classname
                $instance = new $processor();
            }

            // now, finally check, if the class is really a TransformerPostProcessor
            if (!($instance instanceof TransformerPostProcessor)) {
                throw new InvalidTransformerPostProcessorException();
            }

            $transformedData = $instance->postProcess($transformedData);
        }

        return $transformedData;
    }
}
