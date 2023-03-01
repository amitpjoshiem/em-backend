<?php

namespace App\Ship\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\ScopeFactory;
use League\Fractal\ScopeFactoryInterface;

class FractalScopeFactory extends ScopeFactory implements ScopeFactoryInterface
{
    /**
     * @param Manager $manager
     * @param ResourceInterface $resource
     * @param string|null $scopeIdentifier
     * @return FractalScope
     */
    public function createScopeFor(Manager $manager, ResourceInterface $resource, $scopeIdentifier = null)
    {
        return new FractalScope($manager, $resource, $scopeIdentifier);
    }
}
