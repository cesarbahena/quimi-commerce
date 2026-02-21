<?php

namespace QuimiCommerce;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    public function registerBundles(): iterable
    {
        yield new \Symfony\Bundle\FrameworkBundle\FrameworkBundle();
        yield new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle();
        yield new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
    }
}
