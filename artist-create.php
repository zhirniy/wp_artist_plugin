<?php
//Страница создания записи
//Выводим форму и данные с нёё записываем в базу данных
function artist_create() {
   
    $full_name = $_POST["full_name"];
    $foto = $_FILES['my_image_upload'];
     $foto = $foto['name'];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    //insert
    if (isset($_POST['insert'])) {
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
        $message.="Артист добавлен";
     
        $attachment_id = media_handle_upload( 'my_image_upload', $_POST['foto_id'] );

	if ( is_wp_error( $attachment_id ) ) {
		$message.=" Без фото!";
	} else {
		$message. "Фото добавлено!";
	}

  
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/artist/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Добавить нового артиста</h2>

        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p></p>
            <table class='wp-list-table widefat fixed'>

                    <th class="ss-th-width">ФИО</th>
                    <td><input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" class="ss-field-width" required/></td>
                </tr>
                    <tr>
                   
                </tr>
                <tr>
                    <th class="ss-th-width">Фото</th>
                    <td><input type="file" name="my_image_upload" id="my_image_upload" multiple="false"/>
                	<input type="hidden" name="foto_id" value="0" /></td>
                	
                <!--	<td><input type="text" name="id_"  />-->
                	<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
                </tr>
                                    <tr>
                    <th class="ss-th-width">Пол</th>
                    
                    <td><select name="gender" required>
            	   	<option  value="мужской" <?php if ('мужской' == $gender) { ?> selected <?php } ?> >мужской</option>
                    <option  value="женский" <?php if ('женский' == $gender) { ?> selected <?php } ?> >женский</option>
                	</select></td>
                </tr>
                                    <th class="ss-th-width">Возраст</th>
                    <td><input type="text" name="age" value="<?php echo $age; ?>" class="ss-field-width" required/></td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Сохранить' class='button'>
        </form>
    </div>
    <?php
}