<?php
include_once "partials/global.php";
include_once "partials/links.php";

// $submitted = 153334;
?>

<body>
  <div class="ank-lee">
    <!-- Header -->
    <header>
      <div class="container-x py-4 flex justify-end items-center absolute top-0 gap-2">
        <div class="font-krona text-warning mr-auto">HND-SWE</div>

        <div class="flex-center gap-4 bg-white-l">
          <label for="home-theme" class="hidden md:block">Theme</label>
          <button class="flex-center gap-4 detail text-lg detail-primary dark:detail-warning theme-btn cursor-pointer">
            <span class="hidden dark:block"><i class="far fa-moon"></i></span>
            <span class="block dark:hidden"><i class="fas fa-sun"></i></span>
            <span class="hidden dark:block">Dark</span>
            <span class="block dark:hidden">Light</span>
          </button>
        </div>
        <a class="text-dark" href="/admin.php?auth=no-auth">
          <i class="fas fa-user"></i>
        </a>
      </div>
    </header>

    <!-- Hero -->
    <section class="section-p bg-v-circular bg-no-repeat overflow-hidden">
      <div class="container-x relative">
        <div class="flex-center flex-col mt-20 text-center">
          <?php if ($submitted) : ?>
            <span class="text-success">Submitted Successfully</span>
          <?php endif; ?>
          <h2 class="font-krona max-w-xs md:max-w-full text-2xl leading-10 md:text-3xl mb-4">Assignment Collector</h2>
          <p class="mb-5">Submit a PDF Document of your assignment.</p>
          <p class="text-success font-bold mb-5">Course Title<br> Course Code</p>

          <button type="button" class="font-normal bg-dark px-8 py-4 rounded-full UploadMain_button">
            <span class="text-white flex-center gap-5"><b>Let's Go</b> <i class="fas fa-arrow-right"></i></span>
          </button>
        </div>
      </div>
      <div class="absolute top-0 w-full -z-10">
        <img class="max-w-xs" src="/static/images/card-bg.graphity.svg" alt="Hero art" class="">
      </div>
    </section>

    <!-- Main BG COver -->
    <section class="relative">
      <div class="absolute -top-16 w-full -z-10 flex-center">
        <img src="/static/images/bg.something-null.svg" alt="Section something-null">
      </div>
    </section>
    <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
    <?php if ($submitted) : ?>
      <!-- Success -->
      <section class="section-p relative">
        <div class="container-x relative">
          <div class="text-center">
            <h2 class="font-krona text-success text-2xl mb-3">Great Job</h2>
            <p>You have submitted your assignment. 👍</p>

            <div class="text-4xl text-center mt-10">
              <i class="fas fa-check-circle text-success animate-bounce"></i>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- Count Down -->
    <section class="section-p relative CountDown hidden">
      <div class="container-x">
        <div class="text-center">
          <h2 class="font-krona text-2xl mb-3">Time Left</h2>

          <div class="overflow-auto">
            <div class="TimerMain w-max flex-center my-4 mx-auto gap-2 pb-8">
              <!-- First -->
              <div class="bg-main-variant rounded-md py-1 px-2 border-b border-b-muted relative flex-center">
                <label class="font-major text-3xl font-bold sm:text-4xl text-light" id="TimerMain__D">00</label>
                <div class="absolute border-b-2 border-b-main w-full"></div>
                <div class="absolute w-3 h-5 -left-1.5 rounded-full border-2 border-main"></div>
                <div class="absolute w-3 h-5 -right-1.5 rounded-full border-2 border-main"></div>
                <h4 class="absolute text-xs -bottom-8">DAYS</h4>
              </div>
              <!-- First -->
              <div class="bg-main-variant rounded-md py-1 px-2 border-b border-b-muted relative flex-center">
                <label class="font-major text-3xl font-bold sm:text-4xl text-light" id="TimerMain__H">00</label>
                <div class="absolute border-b-2 border-b-main w-full"></div>
                <div class="absolute w-3 h-5 -left-1.5 rounded-full border-2 border-main"></div>
                <div class="absolute w-3 h-5 -right-1.5 rounded-full border-2 border-main"></div>
                <h4 class="absolute text-xs -bottom-8">HOURS</h4>
              </div>
              <!-- First -->
              <div class="bg-main-variant rounded-md py-1 px-2 border-b border-b-muted relative flex-center">
                <label class="font-major text-3xl font-bold sm:text-4xl text-light" id="TimerMain__M">00</label>
                <div class="absolute border-b-2 border-b-main w-full"></div>
                <div class="absolute w-3 h-5 -left-1.5 rounded-full border-2 border-main"></div>
                <div class="absolute w-3 h-5 -right-1.5 rounded-full border-2 border-main"></div>
                <h4 class="absolute text-xs -bottom-8">MINUTES</h4>
              </div>
              <!-- First -->
              <div class="bg-main-variant rounded-md py-1 px-2 border-b border-b-muted relative flex-center">
                <label class="font-major text-3xl font-bold sm:text-4xl text-light" id="TimerMain__S">00</label>
                <div class="absolute border-b-2 border-b-main w-full"></div>
                <div class="absolute w-3 h-5 -left-1.5 rounded-full border-2 border-main"></div>
                <div class="absolute w-3 h-5 -right-1.5 rounded-full border-2 border-main"></div>
                <h4 class="absolute text-xs -bottom-8">SECONDS</h4>
              </div>
            </div>
            <input type="hidden" class="hidden" value="<?= $deadline ?>" id="TargetMatrixTime">
            <div id="time"></div>
          </div>

          <div class="Timer__deadline">
            <h2 class="font-krona text-2xl my-3">DeadLine</h2>
            <p class="text-warning"><?= $deadline ?></p>
          </div>

          <div class="Timer__deadline-over hidden">
            <div class="text-danger font-bold font-major text-3xl md:text-4xl my-3">Time Expired</div>
            <p class="font-semibold mt-2"><?= $deadline ?></p>
          </div>

        </div>
      </div>
    </section>

    <!-- Status -->
    <section class="section-p StatusLoader">
      <div class="container-x relative">
        <div class="flex-center gap-3 text-center">
          <h2 class="font-major text-warning text-2xl leading-10 md:text-3xl">LOADING</h2>
          <div class="loader"></div>
        </div>
      </div>
    </section>

    <?php if ($submitted) : ?>
      <!-- Modal Main-->
      <main class="UploadModal fixed inset-0 w-screen h-screen z-50 hidden">
        <div class="animate-inOpacity translate-y-0"></div>
        <div class="absolute w-full h-full UploadModal__form flex-center">
          <div class="absolute w-full h-full UploadModal__overflow bg-primary/60 bg-filter-blur animate-pulse UploadModal__close">
          </div>
          <div class="max-w-sm w-[80%] rounded-xl border-b border-b-muted overflow-hidden opacity-0 -translate-y-16 transition-transform duration-300 UploadModal__form-box bg-white">
            <div class="bg-white p-4 flex justify-between items-center border-b border-b-muted">
              <p>Submit Entry</p>
              <button type="button" class="UploadModal__close"><i class="fas fa-times p-1"></i></button>
            </div>

            <div class="bg-white p-4 transition-all duration-300 text-center">
              <i class="fas fa-check text-success"></i>
              <div class="p-4">
                Hi, you have submitted the form already. <a href="?status=resubmit" class="text-success">Do you want to resubmit?</a>
              </div>
            </div>

            <div class="py-10 px-6 flex-center gap-4 bg-white-l">Assignment Form</div>
          </div>

        </div>
      </main>
    <?php elseif (!$onDate) : ?>
      <!-- Modal Main-->
      <main class="UploadModal fixed inset-0 w-screen h-screen z-50 hidden">
        <div class="animate-inOpacity translate-y-0"></div>
        <div class="absolute w-full h-full UploadModal__form flex-center">
          <div class="absolute w-full h-full UploadModal__overflow bg-primary/60 bg-filter-blur animate-pulse UploadModal__close">
          </div>
          <div class="max-w-sm w-[80%] rounded-xl border-b border-b-muted overflow-hidden opacity-0 -translate-y-16 transition-transform duration-300 UploadModal__form-box bg-white">
            <div class="bg-white p-4 flex justify-between items-center border-b border-b-muted">
              <p>Submit Entry</p>
              <button type="button" class="UploadModal__close"><i class="fas fa-times p-1"></i></button>
            </div>

            <div class="bg-white p-4 transition-all duration-300 text-center">
              <i class="fas fa-times text-danger"></i>
              <div class="p-4">
                Hi, You can no longer submit your assignment. Time over
              </div>
            </div>

            <div class="py-10 px-6 flex-center gap-4 bg-white-l">Assignment Form</div>
          </div>
        </div>
      </main>
    <?php else : ?>
      <!-- Modal Submitted -->
      <main class="UploadModal fixed inset-0 w-screen h-screen z-50 hidden">
        <div class="animate-inOpacity translate-y-0"></div>
        <div class="absolute w-full h-full UploadModal__form flex-center">
          <div class="absolute w-full h-full UploadModal__overflow bg-primary/60 bg-filter-blur animate-pulse UploadModal__close">
          </div>
          <div class="max-w-sm w-[80%] rounded-xl border-b border-b-muted overflow-hidden opacity-0 -translate-y-16 transition-transform duration-300 UploadModal__form-box bg-white">
            <div class="bg-white p-4 flex justify-between items-center border-b border-b-muted">
              <p>Submit Entry</p>
              <button type="button" class="UploadModal__close"><i class="fas fa-times p-1"></i></button>
            </div>

            <label for="FileTarget">
              <div class="bg-white p-4 UploadModal__file-zone">
                <div class="border-warning hidden"></div>
                <div class="file-zone__area border-[3px] min-h-[186px] hover:border-warning group transition border-dotted border-muted border-spacing-8 px-10 py-5 rounded-xl flex-center flex-col gap-3 text-center" data-matrix="" title="Upload PDF document">
                  <span class="group-hover:text-warning transition fas fa-cloud-upload-alt text-4xl"></span>
                  <h3>Upload PDF </h3>
                  <p class="status-message">Drag and <span class="text-success">drop</span> your file or <span class="text-success">click</span>
                    to
                    upload</p>
                  <p class="file-zone__message text-danger hidden"></p>
                </div>
              </div>
            </label>

            <div class="bg-white p-4 UploadModal_input opacity-0 transition-all duration-300 hidden">
              <div class="form-group mb-8">
                <p class="file-zone__filename text-success font-semibold mb-3 show-ellipses"></p>

                <label for="form-data_label" class="block text-lg mb-2">Full name</label>
                <input type="text" data-type="name" id="form-data_label" placeholder="Enter your full name.." class="border-transparent focus:oubline-one focus:border-transparent_ focus-visible:outline-none outline-none focus:border-warning border-b-2 border-b-muted bg-transparent px-1 py-2 w-full">
                <p class="form-data_error text-danger text-sm show-ellipses hidden mt-1"></p>
              </div>

              <div class="form-group mb-4 flex justify-end">
                <button type="button" class="btn btn-main form-data_button flex-center gap-4 leading-6 relative">
                  <span class="leading-6">Submit</span>
                  <span class="loader w-7 h-7 border-2 leading-3 invisible absolute right-4"></span>
                  <i class="icon fas fa-arrow-right w-7 "></i>
                </button>
              </div>
            </div>

            <div class="py-10 px-6 flex-center gap-4 bg-white-l">Assignment Form</div>
            <input class="hidden" type="file" id="FileTarget" accept="application/pdf">
          </div>

        </div>
      </main>
    <?php endif; ?>

    <footer class="section-p sticky bg-white-l bottom-0 w-full">
      <div class="container-x text-center">
        <p class="text-muted">@DevLee</p>
      </div>
    </footer>
    <!-- Create Btn -->
    <div class="UploadMain fixed bottom-20 right-4 z-20">
      <div class="UploadMain_head w-[95px] h-[95px] bg-button-art bg-no-repeat bg-cover bg-center flex-center">
        <button type="button" class="relative w-12 h-12 shadow-bs bg-main-variant rounded-full text-light UploadMain_button" title="Upload file modal" style="display: inline-block;">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>

  </div>

  <script src="/static/scripts/jQuery.min.js"></script>
  <script src="/static/scripts/main-script.js"></script>
</body>

</html>