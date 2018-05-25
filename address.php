<?php
class Address
{
   // Instance attributes
   private $name         = array('FIRST'=>"", 'LAST'=>null);
   private $street       = "";
   private $city         = "";
   private $state        = "";
   private $country		   = "";
   private $zipCode      = "";

   // Operations

   // name() prototypes:
   //   string name()                          returns name in "Last, First" format.
   //                                          If no first name assigned, then return in "Last" format.
   //
   //   void name(string $value)               set object's $name attribute in "Last, First"
   //                                          or "Last" format.
   //
   //   void name(array $value)                set object's $name attribute in [first, last] format
   //
   //   void name(string $first, string $last) set object's $name attribute
   function name()
   {
     // string name()
     if( func_num_args() == 0 )
     {
       if( empty($this->name['FIRST']) ) return $this->name['LAST'];
       else                              return $this->name['LAST'].', '.$this->name['FIRST'];
     }

     // void name($value)
     else if( func_num_args() == 1 )
     {
       $value = func_get_arg(0);

       if( is_string($value) )
       {
         $value = explode(',', $value); // convert string to array

         if ( count($value) >= 2 ) $this->name['FIRST'] = htmlspecialchars(trim($value[1]));
         else                      $this->name['FIRST'] = '';

         $this->name['LAST']  = htmlspecialchars(trim($value[0]));
       }

       else if( is_array ($value) )
       {
         if ( count($value) >= 2 ) $this->name['LAST'] = htmlspecialchars(trim($value[1]));
         else                      $this->name['LAST'] = '';

         $this->name['FIRST']  = htmlspecialchars(trim($value[0]));
       }
     }

     // void name($first_name, $last_name)
     else if( func_num_args() == 2 )
     {
         $this->name['FIRST'] = htmlspecialchars(trim(func_get_arg(0)));
         $this->name['LAST']  = htmlspecialchars(trim(func_get_arg(1)));
     }

     return $this;
   }


   // street() prototypes:
   //   string street()               returns the street string.
   //
   //   void string(string $value)    set object's $street attribute
   function street()
   {
     // string street()
     if( func_num_args() == 0 )
     {
       return $this->street;
     }

     // void street($value)
     else if( func_num_args() == 1 )
     {
       $this->street = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   // city() prototypes:
   //   string city()               returns the city string.
   //
   //   void city(string $value)    set object's $city attribute
   function city()
   {
     // string city()
     if( func_num_args() == 0 )
     {
       return $this->city;
     }

     // void city($value)
     else if( func_num_args() == 1 )
     {
       $this->city = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   // state() prototypes:
   //   string state()               returns the state string.
   //
   //   void state(string $value)    set object's $state attribute
   function state()
   {
     // string state()
     if( func_num_args() == 0 )
     {
       return $this->state;
     }

     // void state($value)
     else if( func_num_args() == 1 )
     {
       $this->state = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   // country() prototypes:
   //   string country()               returns the country string.
   //
   //   void country(string $value)    set object's $country attribute
   function country()
   {
     // string state()
     if( func_num_args() == 0 )
     {
       return $this->country;
     }

     // void country($value)
     else if( func_num_args() == 1 )
     {
       $this->country = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   // zipCode() prototypes:
   //   string zipCode()               returns the zipCode string.
   //
   //   void zipCode(string $value)    set object's $zipCode attribute
   function zipCode()
   {
     // string zipCode()
     if( func_num_args() == 0 )
     {
       return $this->zipCode;
     }

     // void zipCode($value)
     else if( func_num_args() == 1 )
     {
       $this->zipCode = htmlspecialchars((string)func_get_arg(0));
     }

     return $this;
   }


   function __construct($name="", $street="", $city="", $state="", $country="", $zipCode="")
   {
     // delegate setting attributes so validation logic is applied
     $this->name($name);
     $this->street($street);
	   $this->city($city);
     $this->state($state);
	   $this->country($country);
     $this->zipCode($zipCode);
   }
}

?>
