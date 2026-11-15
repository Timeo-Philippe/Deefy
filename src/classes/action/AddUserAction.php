<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class AddUserAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = '<form method="post" action="?action=add-user">
                        <input type="text" name="username" placeholder="Nom d\'utilisateur">
                        <input type="email" name="email" placeholder="Email">
                        <input type="number" name="age" placeholder="Âge">
                        <button type="submit">Connexion</button>
                     </form>';
            return $html;
        } else {
            $_POST['username'] = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            } else {
                return "Adresse email invalide";
            }
            $_POST['age'] = filter_var($_POST['age'], FILTER_VALIDATE_INT);
            if ($_POST['age'] === false || $_POST['age'] < 0) {
                return "Âge invalide";
            }
            return "Nom:" . $_POST['username'] . ", Email:" . $_POST['email'] . ", Âge:" . $_POST['age'];
        }
    }
}
