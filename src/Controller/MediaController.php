<?php

namespace App\Controller;

use App\Model\MediaManager;

class MediaController extends AbstractController
{
    /**
     * List mediass
     */
    public function index(): string
    {
        $mediaManager = new MediaManager();
        $medias = $mediaManager->selectAll('titre');
        // return "toto";
        return $this->twig->render('Medias/home.html.twig', ['medias' => $medias]);
    }

    /**
     * Show informations for a specific medias
     */
    public function show(int $id): string
    {
        $mediaManager = new MediaManager();
        $media = $mediaManager->selectOneById($id);
        return $this->twig->render('Medias/show.html.twig', ['media' => $media]);
    }

    /** 
     * Edit a specific medias
     */
    public function edit(int $id): ?string
    {
        $mediaManager = new MediaManager();
        $medias = $mediaManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $medias = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $mediaManager->update($medias);

            header('Location: /medias/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('medias/edit.html.twig', [
            'medias' => $medias,
        ]);
    }

    /**
     * Add a new medias
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $medias = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $mediaManager = new MediaManager();
            $id = $mediaManager->insert($medias);

            header('Location:/medias/show?id=' . $id);
            return null;
        }

        return $this->twig->render('medias/add.html.twig');
    }

    /**
     * Delete a specific medias
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $mediaManager = new MediaManager();
            $mediaManager->delete((int)$id);

            header('Location:/medias');
        }
    }

    public function book(): string
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            var_dump($_POST);
        }
        //Sécuriser le formulaire
        //récupérer l'id de l'utilisateur depuis la session
        //faire une méthode dans le manager pour réserver le livre
        //Appeler cette méthode
        //Renvoyer soit une page, soit un header vers l'accueil
        return '';
    }
}
