<?php

namespace Milvus\Index;

class IVF_FLAT
{
    static function Param(int $nlist)
    {
        return [
            "nlist" => $nlist
        ];
    }
}
