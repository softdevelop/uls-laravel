<?php 
namespace Rowboat\Es\Facades;
use Illuminate\Support\Facades\Facade;
class ESS extends Facade {
    protected static function getFacadeAccessor() { return 'EsService'; }
}