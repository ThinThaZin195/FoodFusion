window.onload = function () {
  if (!localStorage.getItem("cookieAccepted")) {
    document.getElementById("cookie-banner").style.display = "flex";
  }
};

function acceptCookies() {
  localStorage.setItem("cookieAccepted", "yes");
  document.getElementById("cookie-banner").style.display = "none";
}
