<?php

// $saludar = function ($nombre) : string { //Varias lineas de code
//     return "Hola $nombre";
// };

//$saludar = fn($name) :string => "Hola $name"; //una sola linea de code

//echo $saludar("Poncho") . "\n"; //mismo resultado

// function  saludar(string $name) : string {
//     return "Hola $name";
// }

// function execute(callable $fn) : void {
//     echo $fn("Poncho esta es una funcion callback");
// }


// execute('saludar');


// $saludar = fn($name) : string => "Hello $name";

// function execute(callable $fn) : void {
//     echo $fn("Isaa Callable con lambda");
// }

// function execute(callable $fun) : void {
//     echo $fun();
// }

// class User{
//     public function saludar(string $name): string {
//         return "Hola $name";
//     }
// }


// $user = new User();
// $nombre = "Paco";
// // execute([$user, 'saludar']);
// // execute([(new User), 'saludar']);
// execute(fn() => $user->saludar($nombre));


// $users = [
//     ['name' => 'Ana', 'age' => 20],
//     ['name' => 'Julio', 'age' => 24],
// ];

// $adults = array_filter($users, fn($value) => $value['age'] >= 18);
// $names = array_map(fn($item) => $item['name'], $adults);


// print_r($adults);
// print_r($names);



class User
{
    public function __construct(
        public string $name,
        public int $salary,
        public int $age
    ) {}
}


// $user = [
//     new User('Ana', 17),
//     new User('Isaac', 35),
//     new User('Jorge', 25),
//     new User('Beto', 15),
//     new User('Mirna', 39),
// ];



// $adults = array_filter($user, fn(User $user) => $user->age >= 18);

// $names = array_map(fn(User $user) => $user->name, $adults);

// print_r($adults);
// print_r($names);


// echo count($adults);


// class UserCollection implements IteratorAggregate
// {


//     private array $items = [];


//     public function __construct(array $users)
//     {
//         $this->items = $users;
//     }


//     public function filter(callable $function): self
//     {
//         return new self(array_filter($this->items, $function));
//     }


//     // public function map(callable $fn): array
//     // {
//     //     return array_map($fn, $this->items);
//     // }

//     public function map(callable $fn): self
//     {
//         return new self(array_map($fn, $this->items));
//     }


//     public function sort() {
//         sort($this->items);
//     }


//     public function getIterator(): Traversable
//     {
//         return new ArrayIterator($this->items);
//     }
// }




// $names = $users->filter(fn(User $user) => $user->age >= 18)
//     ->map(fn(User $user) => $user->name)->sort();

// // sort($names);

// print_r($names);



require "./Collections/Collection.php";

$users = [
    new User('Ana', 380, 25),
    new User('Isaac', 380, 31),
    new User('Jorge', 380, 23),
    new User('Beto', 380, 55),
    new User('Mirna', 380, 40)
];


// $total = Collection::make([1,2,3])->sum();
$total = Collection::make($users)
    ->filter(fn($k) => $k->age >= 30)
    ->sum('salary');


$avg = Collection::make($users)->avg("age");


$count = Collection::make($users)->count();


print_r($total);
echo "\n";
print_r($avg);
echo "\n";
print_r($count);
