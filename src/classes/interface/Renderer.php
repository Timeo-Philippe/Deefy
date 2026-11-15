<?php

namespace iutnc\deefy\interface;

interface Renderer
{
    const COMPACT = 1;
    const LONG = 2;
    function render(int $selector): string;
}
