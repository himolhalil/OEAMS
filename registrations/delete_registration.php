<?php
    header("Content-Type: application/json");
    include('../utilities/db.php'); // تأكد من صحة مسار ملف قاعدة البيانات

    // استقبال البيانات بصيغة JSON
    $raw = file_get_contents("php://input");
    $body = json_decode($raw, true);

    if (isset($body['registration_id'])) {
        $id = (int)$body['registration_id'];

        // تجهيز استعلام الحذف
        $sql_delete = $conn->prepare("DELETE FROM REGISTRATION WHERE REGISTRATION_ID = ?");
        $sql_delete->bind_param("i", $id);

        if($sql_delete->execute()) {
            echo json_encode(["message" => "تم الحذف بنجاح", "code" => 200]);
        } else {
            echo json_encode(["message" => "فشل في الحذف من قاعدة البيانات", "code" => 500]);
        }
    } else {
        echo json_encode(["message" => "لم يتم استلام معرف السجل", "code" => 400]);
    }
?>