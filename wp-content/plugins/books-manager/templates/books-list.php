<?php
/**
 * Template pour l'affichage de la liste des livres
 * 
 * Ce fichier est utilisé par le shortcode [books_list] pour afficher
 * tous les livres de la base de données dans une grille responsive
 */

// Protection contre l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

// Récupération de tous les livres depuis les Custom Post Types
$args = array(
    'post_type' => 'book',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);

// Exécution de la requête WordPress
$query = new WP_Query($args);
$books = $query->posts;

// Début du conteneur principal
?>
<div class="books-manager-list">
    <?php if ($books && count($books) > 0) : // Vérifie si des livres existent ?>
        <div class="books-grid">
            <?php foreach ($books as $book) : // Boucle sur chaque livre ?>
                <div class="book-card">
                    <!-- Titre du livre avec échappement HTML pour la sécurité -->
                    <h3 class="book-title"><?php echo esc_html(get_the_title($book)); ?></h3>
                    <div class="book-meta">
                        <!-- Informations sur l'auteur -->
                        <p class="book-author">
                            <strong>Auteur:</strong> 
                            <?php echo esc_html(get_field('book_author', $book->ID)); ?>
                        </p>
                        <!-- Année de publication -->
                        <p class="book-year">
                            <strong>Année:</strong> 
                            <?php echo esc_html(get_field('book_year', $book->ID)); ?>
                        </p>
                        <?php if (get_field('book_genre', $book->ID)) : ?>
                            <p class="book-genre">
                                <strong>Genre:</strong> 
                                <?php echo esc_html(get_field('book_genre', $book->ID)); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (get_the_excerpt($book)) : // Affiche l'extrait si il existe ?>
                            <p class="book-description">
                                <?php echo esc_html(get_the_excerpt($book)); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : // Message si aucun livre n'est trouvé ?>
        <p class="no-books">Aucun livre n'a été trouvé.</p>
    <?php endif; ?>
</div>

<!-- Styles CSS pour la mise en page -->
<style>
/* Conteneur principal avec espacement vertical */
.books-manager-list {
    padding: 20px 0;
}

/* Grille responsive pour les cartes de livres 
   - auto-fill : remplit automatiquement la grille
   - minmax(300px, 1fr) : largeur minimum de 300px, maximum 1fr */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px; /* Espacement entre les cartes */
}

/* Style de chaque carte de livre */
.book-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px; /* Coins arrondis */
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Ombre légère */
}

/* Style du titre du livre */
.book-title {
    margin: 0 0 10px 0;
    color: #333;
}

/* Style des paragraphes dans la section meta */
.book-meta p {
    margin: 5px 0;
}

/* Style de la description du livre */
.book-description {
    margin-top: 10px;
    font-style: italic;
}

/* Style du message "aucun livre trouvé" */
.no-books {
    text-align: center;
    padding: 20px;
    background: #f5f5f5;
    border-radius: 5px;
}
</style>