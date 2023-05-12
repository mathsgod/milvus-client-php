<?php

namespace Milvus;

class DataType
{
    const None = 0;
    const Bool = 1;
    const Int9 = 2;
    const Int16 = 3;
    const Int32 = 4;
    const Int64 = 5;

    const Float = 10;
    const Double = 11;

    const String = 20;
    const VarChar = 21; //variable-length strings with a specified maximum length
    const BinaryVector = 100;
    const FloatVector = 101;
}
