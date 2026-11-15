<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        return '<h1>Bienvenue sur Deefy !</h1>';
    }
}
