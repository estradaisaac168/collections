<?php

require "./Validate.php";

class Collection extends Validate implements IteratorAggregate
{

    public function __construct(private array $items = [])
    {
        // parent::__construct($items);
    }

    /**
     * Crea una coleccion a partir  de un array
     */
    public static function make(array $items): self
    {
        return new self($items);
    }


    /**
     * Devuelve todos los elementos como array
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }


    /**
     * Trasforma cada elemento y retorna una nueva coleccion
     *
     * @param callable $fn
     * @return self
     */
    public function map(callable $fn): self
    {
        return new self(array_map($fn, $this->items));
    }


    /**
     * Filtra los elementos segun una condicion
     *
     * @param callable $fn
     * @return self
     */
    public function filter(callable $fn): self
    {
        return new self(array_filter($this->items, $fn));
    }


    /**
     * Reduce la coleccion a un solo valor
     *
     * @param callable $fn
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $fn, mixed $initial = null): mixed
    {
        return array_reduce($this->items, $fn, $initial);
    }



    /**
     * Ordena los elementos usando una funcion de comparacion
     * (No modifica la coleccion original)
     *
     * @param callable $fn
     * @return self
     */
    public function sort(callable $fn): self
    {
        $items = $this->items;

        usort($items, $fn);

        return new self($items);
    }



    /**
     * Retorna un primer elemento o null
     *
     * @return mixed
     */
    public function first(): mixed
    {

        return $this->items[array_key_first($this->items)] ?? null;
    }



    /**
     * Obtiene el ultimo elemento o null
     *
     * @return mixed
     */
    public function last(): mixed
    {
        return $this->items[array_key_last($this->items) ?? null];
    }


    /**
     * Obtiene solo los valores (Reindexa)
     *
     * @return self
     */
    public function values(): self
    {
        return new self(array_values($this->items));
    }


    /**
     * Obtiene solo las keys
     *
     * @return self
     */
    public function keys(): self
    {
        return new self(array_keys($this->items));
    }



    /**
     * Retorna la cantidad de elementos
     *
     * @return integer
     */
    public function count(): int
    {
        return count($this->items);
    }



    /**
     * indica si la coleccion esta vacia
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }




    /**
     * Filtra por una propiedad del objeto
     *
     * @param string $property
     * @param mixed $value
     * @return self
     */
    public function where(string $property, mixed $value): self
    {
        return $this->filter(
            fn($item) => isset($item->{$property}) && $item->{$property} === $value
        );
    }



    /**
     * Extrae una propiedad por cada elemento
     *
     * @param string $property
     * @return self
     */
    public function pluck(string $property): self
    {

        return $this->map(
            fn($item) => $item->{$property} ?? null
        );
    }



    /**
     * Agrupa los elementos por una clave o funcion
     *
     * @param callable|string $key
     * @return self
     */
    public function groupBy(callable|string $key): self
    {

        $groups = [];

        foreach ($this->items as $item) {

            $groupKey = is_callable($key) ? $key($item) : ($item->{$key} ?? null);

            $groups[$groupKey][] = $item;
        }


        return new self($groups);
    }




    /**
     * Verifica si la coleccion contiene un valor
     *
     * @param mixed $value
     * @return boolean
     */
    public function contains(mixed $value): bool
    {
        return in_array($value, $this->items, true);
    }



    /**
     * Calcula el promedio de los valores
     *
     * @param string|null $property
     * @return float|integer|null
     */
    public function avg(?string $property = null): float|int|null
    {

        if ($this->isEmpty()) {
            return null;
        }

        return $this->sum($property) / $this->count();
    }



    /**
     * Obtiene el valor mínimo de la colección.
     *
     * @param string|null $property
     * @return mixed
     */
    public function min(?string $property = null): mixed
    {
        if ($this->isEmpty()) {
            return null;
        }

        $values = $property
            ? array_map(fn($i) => $i->{$property} ?? null, $this->items)
            : $this->items;

        return min($values);
    }


    /**
     * Obtiene el valor maximo de una coleccion
     *
     * @param string|null $property
     * @return mixed
     */
    public function max(?string $property = null): mixed
    {
        if ($this->isEmpty()) {
            return null;
        }

        $values = $property
            ? array_map(fn($i) => $i->{$property} ?? null, $this->items)
            : $this->items;

        return max($values);
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

                    $this->validateNumeric($item);

                    return $carry + $item;
                }

                $this->validateObjectWithProperty($item, $property);

                return $carry + $item->{$property};
            },
            0
        );
    }




    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
