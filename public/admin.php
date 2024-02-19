<?php

use App\Main\CompoundClass;
use Devlee\WakerORM\DB\Database;

include_once "ass-partials/global.php";
include_once "ass-classes/config.php";
include_once "ass-classes/Database.php";
include_once "ass-classes/FileUpload.php";
include_once "ass-classes/Library.php";
include_once "ass-classes/CompoundClass.php";
include_once "ass-classes/pclzip.lib.php";

$conn = (new Database)->connect();
$app = new CompoundClass();


$auth = $_GET['auth'] ?? null;
if ($auth === 'no-auth') {
  $_SESSION['auth_user'] = 'no-auth';
  header("Location: /admin");
} elseif ($auth === 'auth') {
  unset($_SESSION['auth_user']);
  header("Location: /admin");
}


if ($user === 'admin') {
  if (isset($_GET['state'])) {
    $app->updateStatus($_GET['state'], $_GET['key']);
    header("Location: /admin");
  }
  if (isset($_GET['delete'])) {
    $app->deleteDoc($_GET['delete']);
    header("Location: /admin");
  }
}

$token = $_POST['auth_token'] ?? false;
if ($token && $token === "asdf@") {
  $_SESSION['auth_user'] = 'admin';
  header("Location: /admin");
}

$docs = $app->getDocs($_GET['filter'] ?? 'id');
$total = count($docs);

$generate = $_GET['generate'] ?? false;
if ($generate === 'log') {
  $logFile = $app->generateZipLog($docs, "submit-logs");
  header("Location: /uploads/submit-logs.txt");
}

$canGenerate = false;
$canGenerateMsg = '';

if (isset($_POST['generate_user'])) {
  $generate_user = $_POST['generate_user'];
  if ($generate_user === 'shola') {
    $canGenerateMsg = '';
    $canGenerate = true;
  } else {
    $canGenerateMsg = "Incorrect code. Try again";
  }
}


if (($generate === 'zip' && $user === "admin") || $canGenerate) {
  $logFile = $app->generateZipLog($docs, "submit-logs");

  $app->setZipFilename('SWES3116-Assignment-Nov-13-2023');

  $documentsDir = "uploads/";
  $app->createFile('');
  $app->addFile($documentsDir . $logFile, null, $documentsDir);

  if ($docs) {
    $documentsDir = $documentsDir . 'documents/';
    foreach ($docs as $doc) {
      $file = $doc['document'];      # code...
      if ($doc['status'] !== 'none') continue;
      $app->addFile($documentsDir . $file, strtoupper($doc['student_name']), $documentsDir);
    }
  }

  $app->generateZip();
}

include_once "ass-partials/links.php";
?>

<body>
  <?php if (!$user) : ?>
    <!-- Auth -->
    <div class="ank-lee">
      <main class="section-p">
        <div class="container-x flex flex-col md:flex-row">
          <form method="post" class="m-auto">
            <input type="text" name="auth_token" class="f-input-fill">
            <button class="w-full btn btn-primary mt-4">Authenticate Now</button>
          </form>
        </div>
      </main>
    </div>
  <?php elseif (isset($_GET['will'])) : ?>
    <!-- Auth -->
    <div class="ank-lee">
      <main class="section-p">
        <div class="container-x flex flex-col md:flex-row">
          <form method="post" class="m-auto">
            <label class="block">Enter code to download files</label>
            <input type="text" name="generate_user" class="f-input-fill">
            <p class="text-danger"><?= $canGenerateMsg ?></p>
            <button class="w-full btn btn-primary mt-4">Generate Now</button>
            <br><br>
            <a href="/admin" class="btn">Go Back</a>
          </form>
        </div>
      </main>
    </div>
  <?php elseif ($user === "admin") : ?>
    <div class="ank-lee">
      <header>
        <div class="container-x text-center text-warning py-2">
          <h2 class="text-2xl font-major">ADMIN</h2>
        </div>
      </header>

      <!-- Main -->
      <main class="section-p">
        <div class="container-x flex flex-col md:flex-row gap-4">
          <nav class="w-full md:max-w-[270px]">
            <div class="border-2 border-muted p-4 rounded-2xl">
              <a href="/admin" class="p-2 block hover:text-warning">Assignments</a>
              <a href="?generate=zip" class="p-2 block hover:text-warning">Generate ZIP</a>
              <a href="?generate=log" class="p-2 block hover:text-warning">Generate Logs</a>
              <a href="#" class="p-2 block hover:text-warning">Option Cava</a>
              <a href="/assignments" class="p-2 block hover:text-warning">Back >>></a>
            </div>

            <div class="border-2 border-warning/50 bg-white mt-4 p-4 rounded-2xl">
              <div class="flex-center gap-4">
                <h4>Submitted</h4>
                <div class="detail detail-warning font-extrabold text-2xl font-krona">0<?= $total ?></div>
              </div>
            </div>
          </nav>
          <section class="w-full px-4 overflow-auto flex-1">
            <!-- Delivery History -->
            <div class="">
              <div class="py-2 border-b text-lg font-semibold mb-6">
                <h3 class="text-xl">Assignments</h3>
              </div>
              <div class="flex justify-end">
                <form>
                  <div class="flex gap-2 mb-4">
                    <select name="filter" class="bg-main text-light border-transparent border-b-2 border-b-muted" required>
                      <option value="student_name">Name</option>
                      <option value="id">ID</option>
                      <option value="document">Document</option>
                    </select>
                    <button class="btn btn-white"><i class="fas fa-arrow-right"></i></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-4 min-w-max">#</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Student</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Document</th>
                    <th scope="col" class="px-6 py-4 min-w-max">File Size</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Date</th>
                    <th scope="col" class="px-6 py-4 min-w-max">status</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $counter = 0;
                  foreach ($docs as $doc) {
                    $counter++; ?>
                    <tr class="border-b bg-white group dark:bg-gray-900 dark:border-gray-700 even:bg-gray-50 even:dark:bg-gray-800 even:dark:border-gray-700">
                      <td class="px-6 py-4"><?= $counter ?> <p class="text-warning mt-2">0<?= $doc['id'] ?></p>
                      </td>
                      <td class="px-6 py-4"><?= $doc['student_name'] ?></td>
                      <td class="px-6 py-4 max-w-[220px] show-ellipses"><?= $doc['document'] ?></td>
                      <td class="px-6 py-4"><?= $doc['file_size'] ?></td>
                      <td class="px-6 py-4"><?= $doc['submitted_on'] ?></td>
                      <td class="px-6 py-4 <?= $doc['status'] === 'none' ? 'text-muted' : 'text-danger' ?> uppercase"><?= $doc['status'] ?></td>
                      <td class="px-6 py-4 flex-center_ _gap-3 sticky right-0">
                        <div class="bg-white dark:bg-gray-900 group-even:bg-gray-50 group-even:dark:bg-gray-800 flex flex-col gap-1">
                          <a onclick="return confirm('Mark document as REMOVED')" href="?state=removed&key=<?= $doc['id'] ?>" class="text-warning">Remove</a>
                          <a onclick="return confirm('Un mark document set NONE')" href="?state=none&key=<?= $doc['id'] ?>" class="text-success">Undo</a>
                          <a onclick="return confirm('Delete this document')" href="?delete=<?= $doc['id'] ?>" class="text-danger">Delete</a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </main>
    </div>
  <?php elseif ($user === "no-auth") : ?>
    <div class="ank-lee">
      <header>
        <div class="container-x text-center text-warning py-2">
          <h2 class="text-2xl font-major">ADMIN</h2>
        </div>
      </header>

      <!-- Main -->
      <main class="section-p">
        <div class="container-x flex flex-col md:flex-row gap-4">
          <nav class="w-full md:max-w-[270px]">
            <div class="border-2 border-muted p-4 rounded-2xl">
              <a href="?will=can-generate" class="p-2 block hover:text-warning">Generate ZIP</a>
              <a href="?generate=log" class="p-2 block hover:text-warning">Generate Logs</a>
              <a href="#" class="p-2 block hover:text-warning">Option One</a>
              <a href="/assignments" class="p-2 block hover:text-warning">Back >>></a>
            </div>

            <div class="border-2 border-warning/50 bg-white mt-4 p-4 rounded-2xl">
              <div class="flex-center gap-4">
                <h4>Submitted</h4>
                <div class="detail detail-warning font-extrabold text-2xl font-krona">0<?= $total ?></div>
              </div>
            </div>
          </nav>
          <section class="w-full px-4 overflow-auto flex-1">
            <!-- Delivery History -->
            <div class="">
              <div class="py-2 border-b text-lg font-semibold mb-6">
                <h3 class="text-xl">Assignments</h3>
              </div>
              <div class="flex justify-end">
                <form>
                  <div class="flex-center gap-2 mb-4">
                    <label for="filter">Filter</label>
                    <select id="filter" name="filter" class="f-input" required>
                      <option value="student_name">Name</option>
                      <option value="id">ID</option>
                      <option value="document">Document</option>
                    </select>
                    <button class="btn btn-white"><i class="fas fa-arrow-right"></i></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-4 min-w-max">#</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Student</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Document</th>
                    <th scope="col" class="px-6 py-4 min-w-max">File Size</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Date</th>
                    <th scope="col" class="px-6 py-4 min-w-max">status</th>
                    <th scope="col" class="px-6 py-4 min-w-max">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $counter = 0;
                  foreach ($docs as $doc) {
                    $counter++; ?>
                    <tr class="border-b bg-white group dark:bg-gray-900 dark:border-gray-700 even:bg-gray-50 even:dark:bg-gray-800 even:dark:border-gray-700">
                      <td class="px-6 py-4"><?= $counter ?></td>
                      <td class="px-6 py-4"><?= $doc['student_name'] ?></td>
                      <td class="px-6 py-4 max-w-[220px] show-ellipses"><?= $doc['document'] ?></td>
                      <td class="px-6 py-4"><?= $doc['file_size'] ?></td>
                      <td class="px-6 py-4"><?= $doc['submitted_on'] ?></td>
                      <td class="px-6 py-4 <?= $doc['status'] === 'none' ? 'text-muted' : 'text-danger' ?> uppercase"><?= $doc['status'] ?></td>
                      <td class="px-6 py-4 flex-center_ _gap-3">
                        <div class="bg-white dark:bg-gray-900 group-even:bg-gray-50 group-even:dark:bg-gray-800 flex flex-col gap-1">
                          <span class="text-warning">None</span>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </main>
    </div>
  <?php else : ?>
    <div class="ank-lee">
      <main class="section-p">
        <div class="container-x flex flex-col md:flex-row">
          <div>Hmm, Nothing to show here..</div>
        </div>
      </main>
    </div>
  <?php endif; ?>
  <script src="/ass-static/scripts/jQuery.min.js"></script>
  <script src="/ass-static/scripts/main-script.js"></script>
</body>

</html>