<?php

namespace Milvus;

class IndexType
{
    const AUTOINDEX = 'AUTOINDEX';
    const INVERTED = 'INVERTED';
    
    const GPU_CAGRAPH = 'GPU_CAGRAPH';
    const GPU_IVF_FLAT = 'GPU_IVF_FLAT';
    const GPU_IVF_PQ = 'GPU_IVF_PQ';
    const GPU_BRUTE_FORCE = 'GPU_BRUTE_FORCE';
}
