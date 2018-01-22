<?php
/*
Plugin Name: Артисты
Description:
Version: 1
Author: Denis Zhyrnyi
Author URI: http://p96278i3.beget.tech/
*/
// Функция создания таблицы в базе данных					
function artist_options_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . "artist";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `id` int(50) NOT NULL AUTO_INCREMENT,
             `full_name` varchar(50) CHARACTER SET utf8 NOT NULL,
            `foto` varchar(50) CHARACTER SET utf8 NOT NULL,
            `gender` enum('мужской','женский') NOT NULL,
            `age` int(50) NOT NULL,
            PRIMARY KEY (`id`)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// регистрация функции
register_activation_hook(__FILE__, 'artist_options_install');

//добавление действия
add_action('admin_menu','artist_modifymenu');
function artist_modifymenu() {
	
	//Добавление поля в основное меню
	add_menu_page('Артисты', //page title
	'Артисты', //menu title
	'manage_options', //capabilities
	'artist_list', //menu slug
	'artist_list' //function
	);


	//добавление в подменю поля обновить/удалить 
	add_submenu_page('artist_list', //parent slug
	'Обновить/Удалить', //page title
	'Обновить/Удалить', //menu title
	'manage_options', //capability
	'artist_all', //menu slug
	'artist_all'); //function
	

	//добавление в подменю поля создания записи
	add_submenu_page('artist_list', //parent slug
	'Добавить артиста', //page title
	'Добавить артиста', //menu title
	'manage_options', //capability
	'artist_create', //menu slug
	'artist_create'); //function
	
	//страница обновление/удаления вызываемая с подменю обновление/удаления
	add_submenu_page(null, //parent slug
	'Обновить/Удалить', //page title
	'Обновить/Удалить', //menu title
	'manage_options', //capability
	'artist_update', //menu slug
	'artist_update'); //function

}


//Подключаем файлы с функциями отображения страниц, shortcode, API

define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'artist-all.php');
require_once(ROOTDIR . 'artist-list.php');
require_once(ROOTDIR . 'artist-create.php');
require_once(ROOTDIR . 'artist-update.php');
require_once(ROOTDIR . 'artist-shortcode.php');
require_once(ROOTDIR . 'artist-api.php');
