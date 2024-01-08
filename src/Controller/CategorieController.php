<?php

namespace App\Controller;

use App\Model\CategorieManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class AccessoryController
 *
 */
class CategorieController extends AbstractController
{
    private CategorieManager $model;

    public function __construct()
    {
        $this->model = new CategorieManager();
        $loader = new FilesystemLoader(__DIR__ . '/../View/Categorie');
        $this->twig = new Environment($loader); //ajoute automatiquement dans USE
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO Add your code here to create a new categorie$categorie
            $errors = [];
            $categorie = array_map('trim', $_POST);
            // TODO validations (length, format...)
            if (strlen($categorie['name_categorie']) === 0 || strlen($categorie['name_categorie']) > 255) {
                $errors[] = "Veuillez taper un nom de catégorie";
            }

            if (empty($errors)) {
                $categorieManager = new CategorieManager();
                $categorieManager->insert($categorie);
                header('Location: /categorie/list');
            }
            return $this->twig->render('/addCategorie.html.twig');
        }
        return $this->twig->render('/addCategorie.html.twig');
    }

    public function browse(): string
    {
        $categorie = $this->model->getAll();
        return $this->twig->render('/listCategorie.html.twig', [
            'categories' => $categorie
        ]);
    }
}
