<?php

namespace Milvus;

class MetricType
{
    //for floating point vectors
    const L2 = "L2";
    const IP = "IP";

    //for binary vectors
    const JACCARD = "JACCARD";
    const TANIMOTO = "TANIMOTO";
    const HAMMING = "HAMMING";
    const SUPRESTRUCTURE = "SUPRESTRUCTURE";
    const SUBSTRUCTURE = "SUBSTRUCTURE";
}
