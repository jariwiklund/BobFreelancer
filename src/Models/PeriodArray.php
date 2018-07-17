<?php

namespace BobFreelancer\Models;


class PeriodArray extends AbstractTypedArray
{
    protected function getType(): string
    {
        return Period::class;
    }
}