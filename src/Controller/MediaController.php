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
        return $this->twig->render('Medias/home.html.twig', ['medias' => $medias]);
    }

    public function show(int $id): string
    {
        $mediaManager = new MediaManager();
        $media = $mediaManager->selectOneById($id);
        return $this->twig->render('Medias/show.html.twig', ['media' => $media]);
    }

    public function edit(int $id): ?string
    {
        $mediaManager = new MediaManager();
        $medias = $mediaManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medias = array_map('trim', $_POST);
            $mediaManager->update($medias);
            header('Location: /medias/show?id=' . $id);
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

            header('Location: /medias');
        }
    }

    public function book()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval(trim($_POST['id']));
            // filter_var($id, FILTER_VALIDATE_INT);
            if (empty($_SESSION['user_id'])) {
                header('Location: /login');
                die();
            }
            $user = $_SESSION['user_id'];
            $mediaManager = new MediaManager();
            $mediaManager->book($id, $user);
        }
        header('Location: /home/media/confirm-reserve');

        return '';
    }

    public function confirmReservation(): string
    {
        return $this->twig->render('Medias/confirmation_reservation.html.twig');
    }
}
