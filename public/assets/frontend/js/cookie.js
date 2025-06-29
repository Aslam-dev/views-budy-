$(document).ready(function () {

    "use strict";

    const getCookie = (name) => {
        const value = " " + document.cookie;
        //console.log("value", `==${value}==`);
        const parts = value.split(" " + name + "=");
        return parts.length < 2 ? undefined : parts.pop().split(";").shift();
      };

      const setCookie = function (name, value, expiryDays, domain, path, secure) {
        const exdate = new Date();
        exdate.setHours(
          exdate.getHours() +
            (typeof expiryDays !== "number" ? 365 : expiryDays) * 24
        );
        document.cookie =
          name +
          "=" +
          value +
          ";expires=" +
          exdate.toUTCString() +
          ";path=" +
          (path || "/") +
          (domain ? ";domain=" + domain : "") +
          (secure ? ";secure" : "");
      };

      const $cookiesBanner = document.getElementById("cookiePopup");
      const $cookiesBannerButton = document.getElementById("acceptCookie");
      const cookieName = "ApexForum";
      const hasCookie = getCookie(cookieName);

      if (!hasCookie) {
        $cookiesBanner.classList.remove("hiden");
      }

      $cookiesBannerButton.addEventListener("click", () => {
        setCookie(cookieName, "closed");
        $cookiesBanner.remove();
      });

});
