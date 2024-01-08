<?php

namespace App\Controller;

use App\Model\AuteurManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AuteurController extends AbstractController
{
    private AuteurManager $model;

    public function __construct()
    {
        $this->model = new AuteurManager();
        $loader = new FilesystemLoader(__DIR__ . '/../View/Auteur');
        $this->twig = new Environment($loader); //ajoute automatiquement dans USE
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO Add your code here to create a new auteur
            $errors = [];
            $auteur = array_map('trim', $_POST);
            // TODO validations (length, format...)
            if (strlen($auteur['name']) === 0 || strlen($auteur['name']) > 255) {
                $errors[] = "Veuillez taper un nom d'auteur";
            }

            if (empty($errors)) {
                $auteurManager = new AuteurManager();
                $auteurManager->insert($auteur);
                header('Location: /auteur/list');
            }
            return $this->twig->render('/addAuteur.html.twig');
        }
        return $this->twig->render('/addAuteur.html.twig');
    }

    public function browse(): string
    {
        $auteur = $this->model->getAll();
        return $this->twig->render('/listAuteur.html.twig', [
            'auteurs' => $auteur
        ]);
    }
}
