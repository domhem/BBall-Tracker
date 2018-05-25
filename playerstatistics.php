<?php
class PlayerStatistic
{
   // Instance attributes
   private $name_id			 = 0;
   private $game_id			 = 0;
   private $playingTime  = array('MINS' =>0,  'SECS'=>0);
   private $pointsScored = 0;
   private $assists      = 0;
   private $rebounds     = 0;

   // Operations

   // name_id() prototypes:
   //   int name_id()               returns the name_id value.
   //
   //   void name_id(int $value)    set object's name_id attribute
   function name_id()
   {
     // int name_id()
     if( func_num_args() == 0 )
     {
       return $this->name_id;
     }

     // void name_id($value)
     else if( func_num_args() == 1 )
     {
       $this->name_id = (int)func_get_arg(0);
     }

     return $this;
   }

   // game_id() prototypes:
   //   int game_id()               returns the game_id value.
   //
   //   void game_id(int $value)    set object's game_id attribute
   function game_id()
   {
     // int name_id()
     if( func_num_args() == 0 )
     {
       return $this->game_id;
     }

     // void name_id($value)
     else if( func_num_args() == 1 )
     {
       $this->game_id = (int)func_get_arg(0);
     }

     return $this;
   }


   // playingTime() prototypes:
   //   string playingTime()                          returns playing time in "minutes:seconds" format.
   //
   //   void playingTime(string $value)               set object's $playingTime attribute
   //                                                 in "minutes:seconds" format.
   //
   //   void playingTime(array $value)                set object's $playingTime attribute
   //                                                 in [minutes, seconds] format
   //
   //   void playingTime(int $minutes, int $seconds)  set object's $playingTime attribute
   function playingTime()
   {
     // string playingTime()
     if( func_num_args() == 0 )
     {
       return $this->playingTime['MINS'].':'.$this->playingTime['SECS'];
     }

     // void playingTime($value)
     else if( func_num_args() == 1 )
     {
       $value = func_get_arg(0);

       if( is_string($value) ) $value = explode(':', $value); // convert string to array
       if( is_array ($value) )
       {
         if ( count($value) >= 2 ) $this->playingTime['SECS'] = (int)$value[1];
         else                      $this->playingTime['SECS'] = 0;
         $this->playingTime['MINS'] = (int)$value[0];
       }
     }

     // void playingTime($first_name, $last_name)
     else if( func_num_args() == 2 )
     {
       $this->playingTime['MINS'] = (int)func_get_arg(0);
       $this->playingTime['SECS'] = (int)func_get_arg(1);
     }

     return $this;
   }

   // pointsScored() prototypes:
   //   int pointsScored()               returns the number of points scored.
   //
   //   void pointsScored(int $value)    set object's $pointsScored attribute
   function pointsScored()
   {
     // int pointsScored()
     if( func_num_args() == 0 )
     {
       return $this->pointsScored;
     }

     // void pointsScored($value)
     else if( func_num_args() == 1 )
     {
       $this->pointsScored = (int)func_get_arg(0);
     }

     return $this;
   }

   // assists() prototypes:
   //   int assists()               returns the number of scoring assists.
   //
   //   void assists(int $value)    set object's $assists attribute
   function assists()
   {
     // int assists()
     if( func_num_args() == 0 )
     {
       return $this->assists;
     }

     // void assists($value)
     else if( func_num_args() == 1 )
     {
       $this->assists = (int)func_get_arg(0);
     }

     return $this;
   }

   // rebounds() prototypes:
   //   int rebounds()               returns the number of rebounds taken.
   //
   //   void rebounds(int $value)    set object's $rebounds attribute
   function rebounds()
   {
     // int rebounds()
     if( func_num_args() == 0 )
     {
       return $this->rebounds;
     }

     // void rebounds($value)
     else if( func_num_args() == 1 )
     {
       $this->rebounds = (int)func_get_arg(0);
     }

     return $this;
   }


   function __construct($name_id=0, $game_id=0, $time="0:0", $points=0, $assists=0, $rebounds=0)
   {
     // delegate setting attributes so validation logic is applied
     $this->name_id($name_id);
     $this->game_id($game_id);
     $this->playingTime($time);
     $this->pointsScored($points);
     $this->assists($assists);
     $this->rebounds($rebounds);
   }

} // end class PlayerStatistic

?>
