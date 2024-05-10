<?php

namespace App\Factory;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Products>
 *
 * @method        Products|Proxy                     create(array|callable $attributes = [])
 * @method static Products|Proxy                     createOne(array $attributes = [])
 * @method static Products|Proxy                     find(object|array|mixed $criteria)
 * @method static Products|Proxy                     findOrCreate(array $attributes)
 * @method static Products|Proxy                     first(string $sortedField = 'id')
 * @method static Products|Proxy                     last(string $sortedField = 'id')
 * @method static Products|Proxy                     random(array $attributes = [])
 * @method static Products|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ProductsRepository|RepositoryProxy repository()
 * @method static Products[]|Proxy[]                 all()
 * @method static Products[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Products[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Products[]|Proxy[]                 findBy(array $attributes)
 * @method static Products[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Products[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ProductsFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->words(2, true),
            'price' => self::faker()->randomFloat(2, 10, 500),
            'stock' => self::faker()->numberBetween(1, 50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Products $products): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Products::class;
    }
}
