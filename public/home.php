<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/home.css">

    <title>Document</title>
</head>

<body>
    <nav>
        <img src="./assets/images/logo.png" alt="logo image" class="logoImg">
        <img src="./assets/images/profile.png" alt="profile icone" class="profileIcone">
    </nav>
    <header class="header">
        <img src="./assets/images/header.png" alt="header image" class="headerImg">
    </header>

    <div class="container">
        <div class="searchBar">
            <input type="text" placeholder="Search for a media..." class="searchInput" />
            <button class="searchBtn">
                <img src="./assets/images/search.png" alt="search button" class="searchIcon" />
            </button>
        </div>
        <div class="booksContainer">
            <div class="booksGrid">
                <?php
                $books = array(
                    array('title' => "Harry Potter et le Prison...", 'author' => "J.K Rowling", 'image' => "https://thumbs.coleka.com/media/item/201703/20/livres-harry-potter-harry-potter-et-le-prisonnier-d-azkaban.webp"),
                    array('title' => "La vie est un roman", 'author' => "Guillaume Musso", 'image' => "https://www.guillaumemusso.com/sites/default/files/images/livres/couv/9782702165546-001-T.jpeg"),
                    array('title' => "Les Misérables", 'author' => "Victor Hugo", 'image' => "https://m.media-amazon.com/images/I/510ypkdwIYL.jpg"),
                    array('title' => "Le Monde de Narnia", 'author' => "C.S Lewis", 'image' => "https://m.media-amazon.com/images/I/91u4fEsre2L._AC_UF1000,1000_QL80_.jpg"),
                );
                
                foreach ($books as $book) {
                    echo '<div class="book">
                    <img src="' . $book['image'] . '" alt=' . $book['title'] . '" class=" . bookCover . ">
                    <h1 class=" . bookTitle . ">' . $book['title'] . ' </h1>
                    <h2 class=" . bookAuthor . ">' . $book['author'] . ' </h2>
                  
                    </div>';
                }
                ?>
            </div>
        </div>
        <footer>
            <span>© 2023 Book Your Medias. All rights reserved</span>
            <div class="socialMedias">
                <img src="./assets/images/instagram.png" alt="instagram" class="media">
                <img src="./assets/images/twitter.png" alt="twitter" class="media">
                <img src="./assets/images/facebook.png" alt="facebook" class="media">
            </div>
        </footer>
</body>

</html>