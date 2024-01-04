<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $credentials = array_map('trim', $_POST);
            if (
                $credentials['adresse_email'] === ''
                || !filter_var($credentials['adresse_email'], FILTER_VALIDATE_EMAIL)
            ) {
                $errors[] = 'veuillez saisir une adresse email valide';
            }
            $email = htmlentities($credentials['adresse_email']);
            $password = $credentials['mot_de_passe'];
            if ($password === '') {
                $errors[] = 'Veuillez saisir un mot de passe';
            }
            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($email);
                if ($user && password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role'];
                    header('location: /');
                    exit();
                } else {
                    $errors[] = "L'utilisateur n'existe pas.";
                }
            }
        }
        return $this->twig->render('Item/Connexion/page_connexion.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        header('location: /');
    }

    public function register(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $credentials = array_map('trim', $_POST);
            if (!$this->validateEntry($credentials, 'adresse_email')) {
                $errors[] = 'Veuillez remplir votre email';
            }
            if (!$this->validateEntry($credentials, 'pseudo')) {
                $errors[] = 'Veuillez remplir votre pseudo';
            }
            if (!$this->validateEntry($credentials, 'mot_de_passe')) {
                $errors[] = 'Veuillez remplir votre mot de passe';
            }
            if (empty($errors)) {
                $credentials['adresse_email'] = htmlspecialchars($credentials['adresse_email']);
                $credentials['pseudo'] = htmlspecialchars($credentials['pseudo']);
                $userManager = new UserManager();
                if ($userManager->insert($credentials)) {
                    return $this->login();
                }
            }
        }
        return $this->twig->render('Item/Inscription/page_inscription.html.twig');
    }

    private function validateEntry(array $credentials, string $field): bool
    {
        return !empty($credentials[$field]) && $credentials[$field] !== '';
    }
}
