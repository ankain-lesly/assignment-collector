<?php

use Devlee\WakerORM\DB\Database;
use Devlee\WakerORM\Services\FileUpload;
use Devlee\WakerORM\Services\Library;

include_once "ass-partials/global.php";

include_once "ass-classes/config.php";
include_once "ass-classes/Database.php";
include_once "ass-classes/FileUpload.php";
include_once "ass-classes/Library.php";

$student = $_POST['data_label'] ?? false;
$document = $_FILES['document'] ?? false;

if ($student && $document) {
  if (!$onDate)
    exit(json_encode(['message' => false]));

  if ($submitted)
    exit(json_encode(['success' => false]));

  $uploader = new FileUpload();
  $conn = (new Database())->connect();

  $file_size = round($document['size'] / (1024 * 1024), 3) . " MB";

  $count = $conn->query('SELECT count(*) as count FROM documents');
  $count->execute();
  $count = $count->fetch()['count'];

  $filename = explode('.', $document['name']);

  $options = [
    "path" => __DIR__ . "/uploads/documents/",
    "filename" => strtoupper("Mob-DOC-0" . $count . "-" . $filename[0]),
    "accept" => ['.pdf'],
    "mode" => $uploader::MODE_SINGLE,
  ];

  $filename = $uploader->setup($options, $document);

  if ($uploader->errors()) {
    echo json_encode(['success' => false]);
    exit;
  }
  $uploader->upload();

  $sql = "INSERT INTO documents (document_id, document, file_size, student_name)";
  $sql .= "VALUES (:document_id,:document,:file_size,:student_name)";

  $stmt = $conn->prepare($sql);
  $stmt->bindValue(":document_id", strtoupper(Library::generateToken()));
  $stmt->bindValue(":document", $filename);
  $stmt->bindValue(":file_size", $file_size);
  $stmt->bindValue(":student_name", $student);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
    $_SESSION['submitted']  = time();
    exit;
  }

  unlink(__DIR__ . "/uploads/documents/" . $filename);
  echo json_encode(['success' => false]);
}
