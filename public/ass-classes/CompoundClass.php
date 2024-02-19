<?php

/**
 * User: Dev_Lee
 * Date: 06/29/2023 - Time: 6:00 AM
 * Updated: 10/03/2023 - Time: 11:54 PM
 */

namespace App\Main;

use Devlee\WakerORM\DB\Database;
use PclZip;
use PDO;
// use ZipArchive;

/**
 * @author  Ankain Lesly <leeleslyank@gmail.com>
 * @package  Waker-ORM
 */

class CompoundClass
{
  public PDO $conn;
  private $ZipHandler;
  private $zipFile;

  public function __construct()
  {
    $this->conn = (new Database)->connect();
  }

  public function setZipFilename(string $zipFileName)
  {
    $this->zipFile = $zipFileName . '.zip';
    $this->ZipHandler = new PclZip($this->zipFile);
  }

  public function addFile(string $filepath, ?string $add_dir = null, ?string $remove_dir = null)
  {
    $list = $this->ZipHandler->add($filepath, $add_dir, $remove_dir);
    return $list;
  }

  public function createFile(string $filepath, ?string $add_dir = null, ?string $remove_dir = null)
  {
    $list = $this->ZipHandler->create($filepath, $add_dir, $remove_dir);
    return $list;
  }

  public function generateZip()
  {
    //Force download a file in php
    if (file_exists($this->zipFile)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . basename($this->zipFile) . '"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($this->zipFile));
      readfile($this->zipFile);
    }
  }

  public function generateZipLog(array $data, string $filename)
  {
    $block = "\t<<< Data Log >>>\n\n";
    $filename = $filename . ".txt";
    $fileDir = __DIR__ . "/../uploads/" . $filename;

    file_put_contents($fileDir, '');
    file_put_contents($fileDir, $block, FILE_APPEND);

    foreach ($data as $doc) {
      $date = $doc['submitted_on'];
      $name = $doc['student_name'];
      $id = $doc['document_id'];
      $document = $doc['document'];
      $status = $doc['status'];
      $size = $doc['file_size'];

      $block = <<<EOL
  {
      submitted_on  => $date,
      student_name  => $name,
      document_id   => $id,
      document      => $document,
      file_size     => $size,
      status        => $status
  },

EOL;

      file_put_contents($fileDir, $block, FILE_APPEND);
    }

    $block = "\n\n\t<<< @Ankain Lesly >>>";
    file_put_contents($fileDir, $block, FILE_APPEND);

    return $filename;
  }

  // SQL CLASSES
  public function getDocs(?string $state)
  {
    $order = "";
    if ($state === "id") {
      $order = "ORDER BY id DESC";
    } else {
      $order = "ORDER BY $state ASC";
    }
    $sql = 'SELECT * FROM documents ' . $order;
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    // Docs
    return $stmt->fetchAll() ?: [];
  }
  public function updateStatus(string $state, int $key)
  {
    $sql = "UPDATE documents SET documents.status = :status WHERE documents.id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":status", $state);
    $stmt->bindValue(":id", $key, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function deleteDoc(int $key)
  {
    $sqlGet = "SELECT document FROM documents WHERE documents.id = :id";
    $sqlDel = "DELETE FROM documents WHERE documents.id = :id";
    $stmt = $this->conn->prepare($sqlGet);
    $stmt->bindValue(":id", $key);
    $stmt->execute();

    $data = $stmt->fetch();
    if (!$data) return;

    $file = __DIR__ . "/../uploads/documents/" . $data['document'];
    if (file_exists($file)) {
      unlink($file);
    }
    $stmt = $this->conn->prepare($sqlDel);
    $stmt->bindValue(":id", $key);
    return $stmt->execute();
  }
}
