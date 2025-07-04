<?php

namespace Milvus;

class IndexType
{
    const AUTOINDEX = 'AUTOINDEX';

    const BITMAP = 'BITMAP';
    const INVERTED = 'INVERTED';
    const STL_SORT = 'STL_SORT';

    const FLAT = 'FLAT';
    const IVF_FLAT = 'IVF_FLAT';
    const IVF_PQ = 'IVF_PQ';
    const IVF_SQ8 = 'IVF_SQ8';
    const IVF_RABITQ  = 'IVF_RABITQ'; //only for Milvus 2.6.0 and later

    const HNSW = 'HNSW';
    const HNSW_SQ = 'HNSW_SQ';
    const HNSW_PQ = 'HNSW_PQ';
    const HNSW_PRQ = 'HNSW_PRQ';
    const DISKANN = 'DISKANN';

    const BIN_IVF_FLAT = 'BIN_IVF_FLAT';
    const BIN_FLAT = 'BIN_FLAT';

    const SPARSE_INVERTED_INDEX = 'SPARSE_INVERTED_INDEX';

    const GPU_CAGRAPH = 'GPU_CAGRAPH';
    const GPU_IVF_FLAT = 'GPU_IVF_FLAT';
    const GPU_IVF_PQ = 'GPU_IVF_PQ';
    const GPU_BRUTE_FORCE = 'GPU_BRUTE_FORCE';
}
