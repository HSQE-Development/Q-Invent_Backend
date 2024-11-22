<?php

namespace App\Core\Domain;

enum EnumProductStatus: string
{
    case Activo = "A";
    case Inactivo = "I";
}
