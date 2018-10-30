<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 29/10/2018
 * Time: 10:33
 */

namespace Domain\Entity;

interface Exportable
{
    public function export() : array;
}