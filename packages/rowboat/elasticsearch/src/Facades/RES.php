<?php 
namespace Rowboat\Es\Facades;
use Illuminate\Support\Facades\Facade;
class RES extends Facade {
    protected static function getFacadeAccessor() { return 'elasticsearch'; }
}