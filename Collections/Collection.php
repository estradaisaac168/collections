<?php


class Collection implements IteratorAggregate
{

    public function __construct(private array $items = []) {}

    /**
     * Crea una coleccion a partir  de un array
     */
    public static function make(array $items): self
    {
        return new self($items);
    }


    public function filter(callable $fn): self
    {
        return new self(array_filter($this->items, $fn));
    }


    /**
     * Suma los valores de la coleccion o de una propiedad
     * 
     * @throws \InvalidArgumentException
     */
    public function sum(?string $property = null): float | int
    {
        return array_reduce(
            $this->items,
            function ($carry, $item) use ($property) {

                //Sumar valores directos
                if ($property === null) {

                    $this->assertNumeric($item);

                    return $carry + $item;
                }

                $this->assertObjectWithProperty($item, $property);

                return $carry + $item->{$property};
            },
            0
        );
    }


    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }




    private function assertNumeric(mixed $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(
                'Expected numeric value.'
            );
        }
    }

    private function assertObjectWithProperty(object $item, string $property): void
    {

        if (!is_object($item)) {
            throw new \InvalidArgumentException("sum() Espera un objeto cuando la propiedad esta definida como parametro");
        }

        if (!isset($item->{$property}) || !is_numeric($item->{$property})) {
            throw new InvalidArgumentException(
                "Property '{$property}' must exist and be numeric."
            );
        }
    }
}
