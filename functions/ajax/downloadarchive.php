<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_downloadaction', 'makeArchive');
add_action('wp_ajax_downloadaction', 'makeArchive');



function makeArchive()
{
    if (!wp_verify_nonce($_POST['nonce'], 'downloadnonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    print_r($_POST['files']);

    $error = "";
    if (isset($_POST['files'])) {
        $post = $_POST;
        
        print_r($post['files']);

        if (extension_loaded('zip')) {

            if (isset($post['files']) && count($post['files']) > 0) {

                // проверяем выбранные файлы
                $zip = new ZipArchive(); // подгружаем библиотеку zip

                $zip_name = time() . ".zip"; // имя файла

                if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
                    echo  "* Sorry ZIP creation failed at this time";
                }

                foreach ($post['files'] as $file) {
                    # download file
                    $download_file = file_get_contents($file);

                    // $zip->addFile($file_folder . $file); // добавляем файлы в zip архив
                    $zip->addFromString(basename($file), $download_file); // добавляем файлы в zip архив
                }

                $zip->close();

                print_r($zip);
                print_r($zip_name);

                if (file_exists($zip_name)) {
                    // отдаём файл на скачивание
                    header('Content-type: application/zip');
                    header('Content-Disposition: attachment; filename="' . basename($zip_name) . '"');

                    readfile($zip_name);

                    unlink($zip_name);
                }
            } else
                $error .= "* Please select file to zip ";
        } else
            $error .= "* You dont have ZIP extension";
    }

    wp_die();
}
