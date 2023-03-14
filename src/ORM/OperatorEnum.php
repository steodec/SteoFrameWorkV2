<?php

namespace Steodec\SteoFrameWork\ORM;

enum OperatorEnum: string
{
    case EQUAL = "=";
    case GREATER = ">";
    case GREATEROREQUAL = ">=";
    case LESS = "<";
    case LESSOREQUAL = "<=";
}
