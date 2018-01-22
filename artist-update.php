<?php
//функция обновления записи. Получаем в форму текущую запись из базы. Обновляем её и отправляем с формы запрос на обновление записи в базе данных
function artist_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "artist";
    $id = $_GET["id"];
    $full_name = $_POST["full_name"];
    $foto = $_FILES['my_image_upload'];
    $foto = $foto['name'];
    //$foto = $_POST["foto"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
//update
    if (isset($_POST['update'])) {
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
         $attachment_id = media_handle_upload( 'my_image_upload', $_POST['foto_id'] );
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
    } else {//selecting value to update	
        $artist = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%d", $id));
        foreach ($artist as $s) {
            $full_name = $s->full_name;
            $foto = $s->foto;
            $gender = $s->gender;
            $age = $s->age;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/artist/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Артисты</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Артист удалён</p></div>
            <a href="<?php echo admin_url('admin.php?page=artist_list') ?>">&laquo; Вернуться к списку артистов</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Данные артиста обновлены</p></div>
            <a href="<?php echo admin_url('admin.php?page=artist_list') ?>">&laquo; Вернуться к списку артистов</a>

        <?php } else { ?>
            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>ФИО</th><td><input type="text" name="full_name" value="<?php echo $full_name; ?>"/></td></tr>
                    <tr><th>Фото</th>
                       <!-- <input type="text" name="foto" value="<?php //echo $foto; ?>"/> -->
                        <td><input type="file" name="my_image_upload" id="my_image_upload" multiple="false"/>
                	<input type="hidden" name="foto_id" value="0" /></td>
                        </tr>
                    <tr><th>Пол</th>
                     <td><select name="gender" required>
            	   	<option  value="мужской" <?php if ('мужской' == $gender) { ?> selected <?php } ?> >мужской</option>
                    <option  value="женский" <?php if ('женский' == $gender) { ?> selected <?php } ?> >женский</option>
                	</select></td>
                        </tr>
                    <tr><th>Возраст</th><td><input type="text" name="age" value="<?php echo $age; ?>"/></td></tr>
                </table>
                <input type='submit' name="update" value='Обновить' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Удалить' class='button' onclick="return confirm('Удалить артиста?')">
            </form>
        <?php } ?>

    </div>
    <?php
}