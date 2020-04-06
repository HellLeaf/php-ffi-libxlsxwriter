<?php

namespace FFILibXlsxWriter\Structs;

use FFI;
use FFI\CData;
use FFILibXlsxWriter\FFILibXlsxWriter;

class RichString extends Struct
{
    /**
     * @var RichStringPart[]
     */
    protected array $parts = [];

    /**
     * RichString constructor.
     * @param RichStringPart[] $parts
     */
    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    /**
     * @param RichStringPart $part
     * @return $this
     */
    public function push(RichStringPart $part): self
    {
        $this->free();
        $this->parts[] = $part;

        return $this;
    }

    /**
     * @return void
     */
    private function allocate(): void
    {
        $ffi = FFILibXlsxWriter::ffi();

        $size = count($this->parts);
        $this->struct = $ffi->new(
            FFI::arrayType(
                $ffi->type('struct lxw_rich_string_tuple*'),
                [$size + 1]
            ),
            false,
            false
        );

        foreach ($this->parts as $i => $part) {
            $this->struct[$i] = $part->getPointer();
        }

        $this->struct[$size] = null;
        $this->pointer = FFI::addr($this->struct);
    }

    /**
     * @return CData
     */
    public function getPointer(): CData
    {
        if (null === $this->pointer) {
            $this->allocate();
        }

        return $this->pointer;
    }

    /**
     * @return CData
     */
    public function getStruct(): CData
    {
        if (null === $this->struct) {
            $this->allocate();
        }

        return $this->struct;
    }
}
