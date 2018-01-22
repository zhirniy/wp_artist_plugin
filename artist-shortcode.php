<?php
//Функция создания shortcode. Регистрируем shortcode и определяем параметры вывода записей
//Подробнее в файле README
add_shortcode( 'artist', 'artist_func' );


function artist_func( $atts ){
 global $wpdb;
        $table_name = $wpdb->prefix . "artist";

        $atts = shortcode_atts(
		array(
			'min_id' => '1',
			'max_id' => '1000',
			'min_age' => '1',
			'max_age' => '250',
			'gender' => '0',
			'full_name'=>'%',
		), $atts, 'artist' );

       
       
       $rows = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE id >=".$atts['min_id']." AND id <=".$atts['max_id'].
                                          " AND age>= ".$atts['min_age']." AND age<= ".$atts['max_age']." AND gender <>"
                                          .$atts['gender']." AND full_name LIKE '".$atts['full_name']."'"." ORDER BY id DESC");
       if($rows!=null){
        ob_start();?>
                <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">Номер</th>
                <th class="manage-column ss-list-width">ФИО</th></th>
                <th class="manage-column ss-list-width">Фото</th></th>
                <th class="manage-column ss-list-width">Пол</th></th>
                <th class="manage-column ss-list-width">Возраст</th></th>
                                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->full_name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo '<img width="100" height="100"  src="http://p96278i3.beget.tech/WordPress/wp-content/uploads/2018/01/'.$row->foto .'"/>'; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->gender; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->age; ?></td>
                </tr>
            <?php } ?>
        </table>
        <?php
        $output = ob_get_clean(); // set the buffer data to variable and clean the buffer
       return $output;
       }
       else{
           return "Нет таких артистов";
       }
     
 
}



?>