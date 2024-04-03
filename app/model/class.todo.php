<?php
use PhpOrm\DB;

class Todo extends DB
{
    protected $table = 'twig_todo';
    
    protected $attributes = ['id', 'task', 'completed', 'added'];
        
    public static function factory()
    {
        return new self();
    }
}