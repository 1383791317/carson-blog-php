<?php

namespace app\transform;

interface Transform
{
    public function transItem($item): array;
}
