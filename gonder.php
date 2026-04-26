<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $isim = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mesaj = htmlspecialchars(strip_tags(trim($_POST['message'])));

   
    if (empty($isim) || empty($email) || empty($mesaj)) {
        echo json_encode(["status" => "error", "message" => "Lütfen tüm alanları doldurun."]);
        exit;
    }

    // ---> KENDİ E-POSTA ADRESİNİ BURAYA YAZ <---
    $alici = "onuraydogan1978@gmail.com"; 
    $konu = "Portfolyo Sitenizden Yeni Mesaj: $isim";

    // E-posta İçeriği
    $icerik = "Gönderen: $isim\n";
    $icerik .= "E-posta: $email\n\n";
    $icerik .= "Mesaj:\n$mesaj\n";

    // E-posta Başlıkları (Kimden geldiğini gösterir)
    $basliklar = "From: " . $email . "\r\n" .
                 "Reply-To: " . $email . "\r\n" .
                 "X-Mailer: PHP/" . phpversion();

    // Maili Gönder
    if (mail($alici, $konu, $icerik, $basliklar)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Sunucu kaynaklı bir sorun oluştu."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Geçersiz istek."]);
}
?>
