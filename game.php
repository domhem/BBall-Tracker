<?php
class Game
{
   // Instance attributes
   private $name_ID1    = 0;
   private $name_ID2    = 0;
   private $date_played = "";


   // Operations

   // name_ID1() prototypes:
   //   name_ID1 teamName()               returns the name_ID1 value.
   //
   //   void name_ID1(int $value)    set object's name_ID1 attribute
   function name_ID1()
   {
     // int name_ID1()
     if( func_num_args() == 0 )
     {
       return $this->name_ID1;
     }

     // void name_ID1($value)
     else if( func_num_args() == 1 )
     {
       $this->name_ID1 = (int)func_get_arg(0);
     }

     return $this;
   }

   // name_ID2() prototypes:
   //   name_ID2 teamName()               returns the name_ID2 value.
   //
   //   void name_ID2(int $value)    set object's name_ID2 attribute
   function name_ID2()
   {
     // int name_ID1()
     if( func_num_args() == 0 )
     {
       return $this->name_ID2;
     }

     // void name_ID1($value)
     else if( func_num_args() == 1 )
     {
       $this->name_ID2 = (int)func_get_arg(0);
     }

     return $this;
   }

   // date_played() prototypes:
   //   string date_played()               returns the date_played string.
   //
   //   void date_played(string $value)    set object's date_played attribute
   function date_played()
   {
     // string date_played()
     if( func_num_args() == 0 )
     {
       return $this->date_played;
     }

     // void date_played($value)
     else if( func_num_args() == 1 )
     {
       $this->date_played = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   function __construct($name_ID1=0, $name_ID2=0, $date_played="")
   {
     // delegate setting attributes so validation logic is applied
     $this->name_ID1($name_ID1);
     $this->name_ID2($name_ID2);
     $this->date_played($date_played);
   }


}

?>
