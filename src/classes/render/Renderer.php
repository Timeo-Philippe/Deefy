<?php

namespace iutnc\deefy\render;

interface Renderer {
    public function render(): string;
    public const COMPACT = 1;
    public const LONG = 2;
}