<?php

namespace App\Transformers;


abstract class Transformer
{
    /**
     * Transform a collection of items
     */
    public function transformCollection($items) {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * Transform an item
     */
    public abstract function transform($items, array $options =[]);

}