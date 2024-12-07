<?php
//   class calculation{
//     public $num1,$num2,$num3;
//     function Sum(){
//        return $this->num3 =  $this->num1 + $this->num2;
//     }
//     function Sub(){
//        return $this->num3 =  $this->num1 - $this->num2;
//     }
//   }
//   $c1 = new calculation;
//   $c1->num1 = 10;
//   $c1->num2 = 20;
//   echo $c1->Sum();
//   $c2 = new calculation;
//   $c2->num1 = 40;
//   $c2->num2 = 20;
//   echo $c2->Sub();

// class Person {
//     public $name  = "No Name" ;
//      public $age = " 0 ";
//     function showData (){
//         return $this->name . " - " . $this->age;
//     }
// }

// $p1 = new Person;
// $p1->name = "afaq";
// $p1->age = 20;
// echo $p1->showData();
// constructor function

class Person {
    public $name ,$age;
    function __construct($name  = "No Name" ,$age = 0){
        $this->name = $name;
        $this->age = $age;
    }
    function show (){
       return $this->name  . " - " . $this->age;
    }

}
$p1 = new Person("afaq", 20);
$p2 = new Person();
echo $p1->show();
echo $p2->show();
$p3 = new Person("kashmala", 27);
echo $p3->show();
?>