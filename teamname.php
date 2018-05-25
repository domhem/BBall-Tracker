<?php
class Team
{
   // Instance attributes
   private $teamName       = "";

   // Operations

   // $teamName() prototypes:
   //   string teamName()               returns the teamName string.
   //
   //   void teamName(string $value)    set object's teamName attribute
   function teamName()
   {
     // string teamName()
     if( func_num_args() == 0 )
     {
       return $this->teamName;
     }

     // void teamName($value)
     else if( func_num_args() == 1 )
     {
       $this->teamName = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   function __construct($teamName="")
   {
     // delegate setting attributes so validation logic is applied
     $this->teamName($teamName);
   }

}

?>
