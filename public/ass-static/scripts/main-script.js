// Page Form-Data
const PageData = new FormData();
let isLoading = false;
if (localStorage.theme) {
  document.documentElement.classList = localStorage.theme;
}

$(".theme-btn").on("click", (e) => {
  const rootEl = document.documentElement;
  const resetTheme = false;

  if (rootEl.classList.contains("dark")) {
    rootEl.classList.remove("dark");
    localStorage.theme = "light";
  } else {
    rootEl.classList.add("dark");
    localStorage.theme = "dark";
  }

  if (resetTheme) {
    localStorage.removeItem("theme");
  }
});

// Modal
$(".UploadModal__close").on("click", () => {
  $(".UploadModal").fadeOut();
  $(".UploadModal__form-box").removeClass("animate-inOpacity");
  $(".UploadModal__form-box").removeClass("translate-y-0");
  loadNextForm(true);
});

$(".UploadMain_button").on("click", () => {
  $(".UploadModal").fadeIn();
  $(".UploadModal__form-box").addClass("animate-inOpacity");
  $(".UploadModal__form-box").addClass("translate-y-0");
});

$("#FileTarget").on("change", function (e) {
  const target = e.target.files[0];
  handleFileChange(target);
});

$(".UploadModal__file-zone").on("dragover", function (e) {
  e.preventDefault();
  activeFileZone(true);
});

$(".UploadModal__file-zone").on("dragleave", function (e) {
  e.preventDefault();
  activeFileZone();
});

$(".UploadModal__file-zone").on("drop", function (e) {
  e.preventDefault();
  e.stopPropagation();
  const target = e.originalEvent.dataTransfer.files[0];

  handleFileChange(target);
});

// Data Label input
$("#form-data_label").on("blur", (e) => {
  validateFormLabel(e.target.value.trim(), e.target.dataset.type);
});
// Button
$(".form-data_button").on("click", async (e) => {
  const dataLabel = $("#form-data_label").val().trim();

  if (
    validateFormLabel(dataLabel, $("#form-data_label").data("type")) &&
    !isLoading
  ) {
    PageData.append("data_label", dataLabel);
    PageData.append("status", "completed");
    PageData.append("interval", new Date().getTime());

    setBtnState($(".form-data_button"), true);

    const result = await useFetch({
      url: "/ass-data-api-main",
      method: "POST",
      data: PageData,
    });

    if (!result.success) {
      $(".form-data_error").removeClass("hidden");
      $(".form-data_error").text("Something went wrong. Try again");

      return setTimeout(() => {
        setBtnState($(".form-data_button"));
      }, 1000);
    }

    window.location = window.location.href + "?status=success";
  }
});

function setBtnState(button, active = false) {
  isLoading = isLoading ? false : true;

  if (active) {
    button.find(".loader").removeClass("invisible");
    button.find(".icon").addClass("invisible");
    return;
  }
  button.find(".loader").addClass("invisible");
  button.find(".icon").removeClass("invisible");
}
// Handle files
function handleFileChange(targetFile) {
  $(".file-zone__filename").html("No PDF File Select. 🚩");

  const maxSizeBytes = 10469376; // 10MB
  let error = null;
  let errorIcon = '<i class="fas fa-info-circle"></i>&nbsp;&nbsp; ';
  let pdfIcon = '<i class="fas fa-file-pdf"></i>&nbsp; ';
  const accept = ["pdf"];

  const filename = targetFile.name;
  const type = targetFile.type.split("/").pop();

  if (targetFile.size > maxSizeBytes) {
    error = errorIcon + "Maximum upload size is 10MB";
  } else if (accept.includes(type) === false) {
    error = errorIcon + "Invalid file type. Try (" + accept.join() + ") only";
  }

  if (error !== null) {
    $(".file-zone__message").html(error).removeClass("hidden");
    activeFileZone();
    return false;
  }

  if (!$(".file-zone__message").hasClass("hidden")) {
    $(".file-zone__message").addClass("hidden");
  }

  $(".file-zone__filename").html(pdfIcon + filename);
  PageData.append("document", targetFile, filename);
  loadNextForm();
}

// Display file-zone status
function activeFileZone(active = false) {
  if (active) {
    $(".file-zone__area").addClass("border-warning");
    $(".file-zone__area").find("span").addClass("text-warning");
    $(".file-zone__area").find(".status-message").text("Drop file here");
  } else {
    $(".file-zone__area").removeClass("border-warning");
    $(".file-zone__area").find("span").removeClass("text-warning");
    $(".file-zone__area")
      .find(".status-message")
      .html(
        'Drag and <span class="text-success">drop</span> your file or <span class="text-success">click</span> to upload'
      );
  }
}

// load nex form
function loadNextForm(previous = false) {
  if (previous) {
    $(".UploadModal__file-zone").closest("label").removeClass("hidden");
    $(".UploadModal_input").addClass("hidden");
    $(".UploadModal_input").removeClass("animate-inOpacity");
  } else {
    $(".UploadModal__file-zone").closest("label").addClass("hidden");
    $(".UploadModal_input").removeClass("hidden");
    $(".UploadModal_input").addClass("animate-inOpacity");
  }
}

// Validate label
function validateFormLabel(value, type) {
  if (!value) return false;
  const patterns = {
    name: /[a-zA-Z][a-zA-Z]+[a-zA-Z]$/,
    number: /[a-zA-Z][a-zA-Z0-9]+[a-zA-Z0-9]$/,
  };

  const regex = patterns[type] ?? patterns.name;
  if (!regex.test(value)) {
    $(".form-data_error").removeClass("hidden");
    $(".form-data_error").text("Your input is invalid: Try again");
    return false;
  }

  if (!$(".form-data_error").hasClass("hidden")) {
    $(".form-data_error").addClass("hidden");
  }
  return true;
}
// Handle Fetch
async function useFetch(config) {
  let response = {};
  try {
    response = await fetch(config.url, {
      method: config?.method ?? "GET",
      body: config?.data ?? null,
    });
    response = response.json();
  } catch (error) {
    console.log(error.message);
    return response;
  } finally {
    // TODO: Handle Promise:
    return response;
    // console.log(response, typeof response);
  }
}

// Timer Relay
const deadlineStamp = new Date($("#TargetMatrixTime").val()).getTime();

const updateRelay = setInterval(function () {
  $(".StatusLoader").addClass("hidden");
  $(".CountDown").removeClass("hidden");
  const now = new Date().getTime();

  const diff = deadlineStamp - now;

  if (diff < 0) {
    $(".Timer__deadline").addClass("hidden");
    $(".Timer__deadline-over").removeClass("hidden");
    clearInterval(updateRelay);
    return;
  }

  let days = Math.floor(diff / (1000 * 60 * 60 * 24));
  let house = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((diff % (1000 * 60)) / 1000);

  $("#TimerMain__D").text(days < 10 ? "0" + days : days);
  $("#TimerMain__H").text(house < 10 ? "0" + house : house);
  $("#TimerMain__M").text(minutes < 10 ? "0" + minutes : minutes);
  $("#TimerMain__S").text(seconds < 10 ? "0" + seconds : seconds);
}, 1000);
