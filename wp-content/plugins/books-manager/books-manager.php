<?php
/**
 * Fichier principal du plugin Books Manager
 * 
 * Ce plugin permet de gérer une bibliothèque de livres dans WordPress en utilisant :
 * - Les Custom Post Types (CPT) pour la structure de données
 * - Advanced Custom Fields (ACF) pour les champs personnalisés
 * - Des shortcodes pour l'affichage
 * 
 * @package BooksManager
 * @version 1.0.0
 */

/**
 * Informations d'en-tête du plugin WordPress
 */
/**
 * Plugin Name: Books Manager
 * Description: Système de gestion de livres avec Custom Post Types et Shortcodes
 * Version: 1.0.0
 * Author: Yelmouss
 */

// Protection contre l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

// Inclusion des fichiers externes
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

/**
 * Classe principale du plugin
 * 
 * Cette classe centralise toutes les fonctionnalités du plugin
 * en utilisant la Programmation Orientée Objet (POO) pour une
 * meilleure organisation et maintenance du code
 */
class BooksManager
{

    /**
     * Constructeur : s'exécute à la création de l'objet
     * Ici on "accroche" nos fonctions aux actions WordPress
     */
    public function __construct()
    {
        // Hook 'init' : s'exécute quand WordPress initialise
        add_action('init', [$this, 'register_books_cpt']);

        // Hook 'acf/init' : s'exécute quand ACF est chargé
        add_action('acf/init', [$this, 'register_book_fields']);
    }

    /**
     * Crée un nouveau type de contenu personnalisé 'book'
     * Cette fonction est appelée pendant l'initialisation de WordPress
     */
    public function register_books_cpt()
    {
        register_post_type('book', [
            // Labels : textes affichés dans l'interface admin
            'labels' => [
                'name' => 'Livres',              // Nom au pluriel
                'singular_name' => 'Livre',      // Nom au singulier
                'add_new' => 'Ajouter un livre', // Bouton d'ajout
                'add_new_item' => 'Ajouter un nouveau livre', // Titre page d'ajout
                'edit_item' => 'Modifier le livre',    // Titre page d'édition
                'all_items' => 'Tous les livres'       // Menu tous les livres
            ],
            'public' => true,        // Visible sur le site et dans l'admin
            'has_archive' => true,   // Crée une page d'archive /books/
            'supports' => [          // Fonctionnalités activées
                'title',            // Champ titre
                'editor',           // Éditeur de texte riche
                'thumbnail',        // Image mise en avant
                'excerpt'           // Extrait du contenu
            ],
            'menu_icon' => 'dashicons-book-alt'  // Icône dans le menu admin
        ]);
    }

    /**
     * Crée les champs personnalisés avec ACF
     * Cette fonction est appelée quand ACF est initialisé
     */
    public function register_book_fields()
    {
        // Vérifie si ACF est installé et activé
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        // Configuration du groupe de champs ACF
        acf_add_local_field_group([
            'key' => 'group_books',         // Identifiant unique du groupe
            'title' => 'Détails du livre',  // Titre affiché dans l'admin
            'fields' => [
                // Champ Auteur
                [
                    'key' => 'field_author',     // ID unique du champ
                    'label' => 'Auteur',         // Label affiché
                    'name' => 'book_author',     // Nom utilisé pour récupérer la valeur
                    'type' => 'text',           // Type de champ (texte)
                    'required' => true,         // Champ obligatoire
                ],
                // Champ Année
                [
                    'key' => 'field_year',
                    'label' => 'Année de publication',
                    'name' => 'book_year',
                    'type' => 'number',         // Type de champ (nombre)
                    'required' => true,
                ],
                [
                    'key' => 'field_price',
                    'label' => 'Prix',
                    'name' => 'book_price',
                    'type' => 'number',
                    'required' => true,
                    'min' => 0,
                    'step' => '0.01', // Pour les centimes
                ],
                [
                    'key' => 'field_genre',
                    'label' => 'Genre',
                    'name' => 'book_genre',
                    'type' => 'select',
                    'choices' => [
                        'fiction' => 'Fiction',
                        'non-fiction' => 'Non-Fiction',
                        'mystery' => 'Mystère',
                        'sci-fi' => 'Science-Fiction'
                    ]
                ],
                [
                    'key' => 'field_rating',
                    'label' => 'Note',
                    'name' => 'book_rating',
                    'type' => 'number',
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ],
            // Où afficher ces champs
            'location' => [
                [
                    [
                        'param' => 'post_type',  // Condition : type de post
                        'operator' => '==',      // Opérateur de comparaison
                        'value' => 'book',       // Afficher sur le type 'book'
                    ]
                ]
            ]
        ]);
    }
}

// Crée une instance de notre classe pour démarrer le plugin
new BooksManager();
