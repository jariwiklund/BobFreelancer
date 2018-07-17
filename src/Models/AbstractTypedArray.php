<?php

namespace BobFreelancer\Models;


use ArrayAccess;
use InvalidArgumentException;
use Traversable;

abstract class AbstractTypedArray implements ArrayAccess, Traversable
{

    private $array = [];

    public function add(object $object)
    {
        $this->validateType($object);
        $this->array[] = $object;
    }

    private function validateType(object $object)
    {
        $type = $this->getType();
        if( !($object instanceof $type) ){
            throw new InvalidArgumentException('Must be of type '.$type);
        }
    }

    abstract protected function getType(): string;

    public function offsetExists ( $offset ): bool
    {
        return array_key_exists($offset, $this->array);
    }

    public function offsetGet ( $offset )
    {
        return $this->array[$offset];
    }

    public function offsetSet ( $offset, $value )
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset ( $offset )
    {
        unset($this->array[$offset]);
    }

    public function current()
    {
        return $this->array[$this->current_key];
    }

    public function key()
    {
        return key($this->array);
    }

    public function next()
    {
        next($this->array);
    }

    public function rewind()
    {
        reset($this->array);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }
}