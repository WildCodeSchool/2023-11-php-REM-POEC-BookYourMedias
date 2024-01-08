<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\AuteurManager;
use App\Model\CategorieManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AdminController
{
    private AdminManager $model;

    private Environment $twig;

    /**
     * Display cupcake creation page
     * Route /cupcake/add
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function __construct()
    {
        $this->model = new AdminManager();
        $loader = new FilesystemLoader(__DIR__ . '/../View/Admin');
        $this->twig = new Environment($loader); //ajoute automatiquement dans USE
    }

    public function indexAdmin()
    {
        if (isset($_SESSION['user_role'])) {
            $user = $_SESSION['user_role'];
        } else {
            $user = null;
        }

        if ($user == 1) {
            $medias = $this->model->getAll();
            return $this->twig->render('/centreAdmin.html.twig', [
                'medias' => $medias
            ]);
        } else {
            header('Location: /');
        }
    }

    public function browse(): string
    {
        $medias = $this->model->getAll();
        $lastMedia = $this->model->getLastMediaAdded();
        return $this->twig->render('/listMedia.html.twig', [
            'medias' => $medias, 'lastMedia' => $lastMedia,
        ]);
    }

    public function add()
    {
        $categories = new CategorieManager();
        $categoriesOptions = $categories->selectAll();
        $auteurs = new AuteurManager();
        $auteursOptions = $auteurs->selectAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $media = array_map('trim', $_POST);
            $errors = $this -> validate($media);
            if (strlen($media['published_date']) === 0 || strlen($media['published_date']) > 10) {
                $errors[] = "Date de publication obligatoire";
            }
            if (strlen($media['image_couverture']) === 0) {
                $errors[] = "Image de couverture obligatoire";
            }
            if (strlen($media['lien_extrait']) === 0) {
                $errors[] = "Lien extrait obligatoire";
            }
            if (strlen($media['id_auteur']) === 0) {
                $errors[] = "Auteur obligatoire";
            }
            if (strlen($media['id_categorie']) === 0) {
                $errors[] = "Catégorie obligatoire";
            }
            if (empty($errors)) {
                $mediaManager = new AdminManager();
                $mediaManager->insert($media);
                header('Location: /admin/listMedia');
            }
            return $this->twig->render('/addNewMedia.html.twig', [
                'auteurs' => $auteursOptions,
                'categories' => $categoriesOptions
            ]);
        }

        return $this->twig->render('/addNewMedia.html.twig', [
            'auteurs' => $auteursOptions,
            'categories' => $categoriesOptions
        ]);
    }



    private function validate(array $medias)
    {
        $errors = [];
        if (empty($medias['title'])) {
            $errors[] = 'The title is required';
        }
        if (empty($medias['description'])) {
            $errors[] = 'The description is required';
        }
        if (!empty($medias['title']) && strlen($medias['title']) > 255) {
            $errors[] = 'The title should be less than 255 characters';
        }

        return $errors;
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        header('Location: /admin/listMedia');
    }

    public function isBack(int $id)
    {
        $this->model->isBack($id);
        header('Location: /admin');
    }

    public function update(int $id)
    {
        $errors = [];
        $medias = $this->model->getById($id);

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $medias = array_map('trim', $_POST);

            // Validate data
            $errors = $this->validate($medias);

            // Update the recipe
            if (empty($errors)) {
                $this->model->update($medias, $id);
                header('Location: /show?id=' . $id);
            }
        }

        // Generate the web page
        require __DIR__ . '/../View/Admin/addNewMedia.html.twig';
    }
}
