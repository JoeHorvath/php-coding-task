<?php

namespace Orm;

use InvalidArgumentException;

trait AssertNumeric {
    public function assertValueIsNumeric($value) {
        if(!is_numeric($value)) {
            throw new InvalidArgumentException('Method argument failed numeric assertion. Input was: '.$value);
        }
    }
}