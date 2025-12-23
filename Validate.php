<?php


class Validate
{

    // private array $items = [];


    // public function __construct(array $items)
    // {
    //     $this->items = $items;
    // }

    protected function validateEmpty(): void
    {
        if (empty($items)) {
            throw new InvalidArgumentException("EL objeto no puede estar vacio");
        }
    }



    protected function validateNumeric(mixed $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(
                'Expected numeric value.'
            );
        }
    }

    protected function validateObjectWithProperty(object $item, string $property): void
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
