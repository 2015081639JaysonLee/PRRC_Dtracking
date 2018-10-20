<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;



class Docu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    
    
    //Table Name
    protected $table = 'docus';
    //Primary Key
    public $primaryKey = 'docu_id';
    //Timestamps
    public $timestamps = true;

   
   
}


    
       