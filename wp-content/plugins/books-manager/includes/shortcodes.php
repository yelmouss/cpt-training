<?php
/**
 * Fichier de gestion des shortcodes pour le plugin Books Manager
 * 
 * Ce fichier contient toutes les fonctions liées aux shortcodes du plugin,
 * permettant d'afficher les livres dans les pages et articles WordPress.
 */

// Protection contre l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit; // On sort si on tente d'accéder directement au fichier
}

/**
 * Enregistre tous les shortcodes du plugin
 * 
 * Cette fonction est appelée au moment de l'initialisation de WordPress (hook 'init')
 * Elle déclare notre shortcode [books_list] et le lie à la fonction qui gère son affichage
 */
function books_manager_register_shortcodes() {
    // Enregistre le shortcode [books_list] et le lie à la fonction books_manager_list_shortcode
    add_shortcode('books_list', 'books_manager_list_shortcode');
}
// Accroche notre fonction d'enregistrement des shortcodes à l'action 'init' de WordPress
add_action('init', 'books_manager_register_shortcodes');

/**
 * Fonction de rappel pour le shortcode [books_list]
 * 
 * Cette fonction est appelée chaque fois que WordPress rencontre le shortcode [books_list]
 * dans le contenu d'une page ou d'un article.
 * 
 * @param array $atts Les attributs passés au shortcode (non utilisés pour le moment)
 * @return string Le HTML généré pour afficher la liste des livres
 */
function books_manager_list_shortcode($atts) {
    // Démarre la mise en tampon de la sortie
    // Cela permet de capturer tout le HTML généré au lieu de l'afficher directement
    ob_start();

    // Inclut le template qui contient le code HTML pour afficher les livres
    // __DIR__ est le dossier du fichier actuel, on remonte d'un niveau avec dirname
    require_once plugin_dir_path(__DIR__) . 'templates/books-list.php';

    // Récupère tout le contenu mis en tampon et vide le tampon
    $output = ob_get_clean();

    // Retourne le HTML généré
    return $output;
}
