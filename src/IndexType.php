<?php

namespace Milvus;

class IndexType
{
    //for floating point vectors
    const FLAT = "FLAT";
    const IVF_FLAT = "IVF_FLAT";
    const IVF_SQ8 = "IVF_SQ8";
    const IVF_PQ = "IVF_PQ";
    const HNSW = "HNSW";
    const ANNOY = "ANNOY";

    //for binary vectors
    const BIN_FLAT = "BIN_FLAT";
    const BIN_IVF_FLAT = "BIN_IVF_FLAT";
}
