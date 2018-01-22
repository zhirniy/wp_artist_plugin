<?php 
//Фукция предосталения API
//Регистрируем маршруты all, parameters, delete, create, update на каждый маршрут регистрируем свою функцию обработчик.
add_action( 'rest_api_init', function () {
	register_rest_route( 'artistplugin/v1', '/artist/parameters', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func',
	) );
		register_rest_route( 'artistplugin/v1', '/artist/all', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func_all',
	) );
		register_rest_route( 'artistplugin/v1', '/artist/delete', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func_delete',
	) );
	   register_rest_route( 'artistplugin/v1', '/artist/create', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func_create',
	) );
	
	
		 register_rest_route( 'artistplugin/v1', '/artist/update', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func_update',
	) );
	
	
	
} );

//Предоставление списка всех артистов
function my_awesome_func_all() {
   global $wpdb;
   $table_name = $wpdb->prefix . "artist";
   $rows = $wpdb->get_results("SELECT * from $table_name");
	return $rows;
}
//Предоставление списка всех артистов по параметрам
function my_awesome_func(WP_REST_Request $request) {
$min_id = $request['min_id'] ? $request['min_id'] : 1;
$max_id = $request['max_id'] ? $request['max_id'] : 1000;
$min_age = $request['min_age'] ? $request['min_age'] : 1;
$max_age = $request['max_age'] ? $request['max_age'] : 250;
$gender = $request['gender'] ? $request['gender'] : 0;
$full_name = $request['full_name'] ? $request['full_name'] : '%';

   global $wpdb;
   $table_name = $wpdb->prefix . "artist";
   $rows = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE id >=".$min_id." AND id <=".$max_id.
                               " AND age>= ".$min_age ." AND age<= ".$max_age." AND gender <>"
                              .$gender." AND full_name LIKE '".$full_name."'"." ORDER BY id DESC");
                                    
                                    
    return $rows;                                
                                        
}

//Удаления артистов

function my_awesome_func_delete(WP_REST_Request $request) {
   $id = $request['id']; 
   if($id){
       global $wpdb;
       $table_name = $wpdb->prefix . "artist";
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
        $string = "Entry ".$id." deleted or does not exist";
    	return  $string;
     }
     else{
        return "Incorrect parameters from delete";
     }
 
}

//Создание артистов
function my_awesome_func_create(WP_REST_Request $request) {
   $full_name = $request['full_name']; 
   $age = $request['age'];
   $gender = $request['gender'];
   $foto = $request['foto'];
   if($full_name && $age && gender && foto){
         global $wpdb;
        $table_name = $wpdb->prefix . "artist";
        $wpdb->insert(
                $table_name, //table
                array( 
                'full_name' => $full_name,
                'foto' => $foto,
                'gender' => $gender,
                'age' => $age,
                ), //data
                array('%s', '%s') //data format			
        );
    	return  "Entry created";
     }
     else{
        return "Incorrect parameters from create";
     }
 
}

//Обновления артистов
function my_awesome_func_update(WP_REST_Request $request) {
   $id = $request['id'];
   $full_name = $request['full_name']; 
   $age = $request['age'];
   $gender = $request['gender'];
   $foto = $request['foto'];
   if($id && $full_name && $age && gender && foto){
         global $wpdb;
        $table_name = $wpdb->prefix . "artist";
        $wpdb->update(
                $table_name, //table
                array('full_name' => $full_name,
                'foto' => $foto,
                'gender'=> $gender,
                'age' => $age
                ), //data
                array('ID' => $id), //where
                array('%s'), //data format
                array('%d') //where format
        );
    	return  "Entry updated";
     }
     else{
        return "Incorrect parameters from update";
     }
 
}






?>