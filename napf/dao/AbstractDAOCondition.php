<?php
namespace napf\dao;

class AbstractDAOCondition
{
    public $link;
    public $field;
    public $comparator;
    public $value;

    public function __construct($field, $comparator, $value, $link)
    {
        $this->field = $field;
        $this->comparator = $comparator;
        $this->value = $value;
        $this->link = $link;
    }
}