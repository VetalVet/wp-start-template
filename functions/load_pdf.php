<?php
add_action('wp_ajax_nopriv_form_cp', 'formCp');
add_action('wp_ajax_form_cp', 'formCp');

function formCp()
{
    if (!wp_verify_nonce($_POST['nonce'], 'formcp-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    if(!isset($_POST['product_ids'])){
        wp_die();
    }
    require('tfpdf/tfpdf.php');

    $pdf = new tFPDF('P', 'pt', 'A4');

    $pdf->AddFont('Arial400','','Arial400.ttf',true);
    $pdf->AddFont('KyivTypeSans-VarGX','','KyivTypeSans-VarGX.ttf',true);
    $pdf->AddFont('dmitry-rastvortsev-kyivtype-sans-black-webfont','','dmitry-rastvortsev-kyivtype-sans-black-webfont.ttf',true);
    
    $pdf->SetFont('Arial400','', 10);

    $header_photo = get_field( 'cp_title_img', 'options' );

    foreach(explode(',', $_POST['product_ids']) as $product){
        $data = get_fields($product);
        $pdf->SetMargins(0, 0, 0);
        $pdf->AddPage();
        $pdf->Cell(100, 200, $pdf->Image($header_photo, $pdf->GetX(), $pdf->GetY(), 600), 0, 0, 'L', false);

        $x = 25;
        $y = 145;
        // Данные менеджера
        if ($_POST['manager']) {
            $pdf->SetY($y);
            $pdf->SetX($x);
            $pdf->Cell(0, 0, $_POST['manager']);
            $y = $y + 13;
        }

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, 'Sales Manager');
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, 'at Evroprom LLC');
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, '+380 67 148 86 21 (viber, whatsapp)');
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, 'info@evroprom.com');
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, 'www.evroprom.com');


        // Данные клиента
        $x = 297;
        $y = 145;
        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, get_field('user_fio', 'user_' . $_POST['client_id']));
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, get_field('user_company', 'user_' . $_POST['client_id']));
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, get_field('user_country', 'user_' . $_POST['client_id']));
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, 'Phone: ' . get_field('user_phone', 'user_' . $_POST['client_id']));
        $y = $y + 13;

        $pdf->SetY($y);
        $pdf->SetX($x);
        $pdf->Cell(0, 0, get_field('user_email', 'user_' . $_POST['client_id']));
        $y = $y + 13;



        $y = 240;
        $x = 25;
        // Заголовок товара
        $pdf->SetY($y);
        $pdf->SetX($x);
        // $pdf->SetFont('KyivTypeSans-VarGX', '', 15);
        $pdf->SetFont('Arial400', '', 15);
        $pdf->Cell(0, 0, get_the_title($product));

        $y = $y + 23;
        // фотки товара
        $i = 1;
        foreach($data['prod_gallery'] as $photo){
            if($i < 4){
                if($photo['photo']){
                    $pdf->SetY($y);
                    $pdf->SetX($x);
                    $pdf->Cell( 100, 200, $pdf->Image($photo['photo']['url'], $pdf->GetX(), $pdf->GetY(), 130), 0, 0, 'L', false );
                    $x = $x + 133;
                    $i++;
                }
            }
        }
        $y = $y + 105;


        // Характеристики товара
        $pdf->SetFont('Arial400', '', 10);
        $x = 25;
        foreach($data['prod_chars'] as $chars){

            $pdf->SetY($y);
            $pdf->SetX($x);
            $pdf->MultiCell(0, 0, $chars['char']);
            $x = $x + 272;

            $pdf->SetY($y);
            $pdf->SetX($x);
            $pdf->MultiCell(0, 0, $chars['value']);
            $y = $y + 15;
            $x = 25;
        }
        $y = $y + 30;


        $x = 25;
        // Цена
        // $pdf->SetFont('Arial', 'B', 15);
        // $pdf->SetFont('KyivTypeSans-VarGX', '', 15);
        $pdf->SetFont('Arial400', '', 15);
        $pdf->SetY(630);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, pll__('PRICE'));
        $pdf->SetFillColor(251, 186, 2);

        $pdf->SetY(630);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, $data['prod_price'] . ' ' . pll__('EUR'));
        $pdf->SetFillColor(251, 186, 2);

        $pdf->SetY(650);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, pll__('PRICE WITH DISCOUNT'));
        $pdf->SetFillColor(251, 186, 2);

        $discount_price = $data['prod_price'] * ((100 - get_field('user_discount', 'user_' . $_POST['client_id'])) / 100);
        $pdf->SetY(650);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, $discount_price . ' ' . pll__('EUR'));
        $pdf->SetFillColor(251, 186, 2);
        // Цена


        // Доставка
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetY(680);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'Payment terms: 100% before loading');

        $pdf->SetY(693);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'Delivery terms: FCA 21-010 Leczna, ul. Zofiowka 84a, Poland');
        // Доставка

        // var_dump($pdf);


        // Контакты
        $pdf->SetY(730);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'Evroprom LLC');

        $pdf->SetY(743);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'Poland 20-234 Lublin');

        $pdf->SetY(756);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'ul. Melgiewska 74/200');

        $pdf->SetY(769);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'info@evroprom.com');

        $pdf->SetY(782);
        $pdf->SetX(25);
        $pdf->MultiCell(0, 0, 'www.evroprom.com');


        // Платёжные реквизиты
        $pdf->SetY(730);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, 'mBank, str. Spokojna 2, 20-074 Lublin, Poland');

        $pdf->SetY(743);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, 'IBAN PL42114010940000377001001002');

        $pdf->SetY(756);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, 'SWIFT/BIC BREXPLPWXXX');

        $pdf->SetY(769);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, 'NIP 7123332602');

        $pdf->SetY(782);
        $pdf->SetX(297);
        $pdf->MultiCell(0, 0, 'VAT EU PL7123332602');
    }

    $pdf->Output();
    exit;
}
