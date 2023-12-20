<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array | false $user;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        //Je récupère l'utilisateur dans la base de données si il existe
        //Pour cela, j'utilise l'opérateur ternaire
        $userManager = new UserManager();
        /* Si la session existe, alors je vais chercher dans la base de données, sinon je retourne false */
        $this->user = isset($_SESSION['user_id']) ? $userManager->selectOneById($_SESSION['user_id']) : false;
        //Maintenant, tous les templates twig auront accès directement à user,
        //sans devoir le préciser dans chaque controleur.
        $this->twig->addGlobal('user', $this->user);
    }
}
