import '@scss/main.scss';
import disclosure from "@js/disclosure.js";
import scrollCheck from "@js/scrollcheck.js";
import jsToggle from "@js/jstoggle.js";
// import cookieConsent from '@js/cookieconsent.js';
// import matomoTracking from "@js/matomo.js";
// import youtubeInject from "@js/youtubeinject.js";
// import imageSlider from "@js/imageslider.js";

jsToggle.initialize();
disclosure.initialize();
scrollCheck.initialize({
  offsetTrigger: {
    mobile: 80,
    desktop: 120,
  },
  windowWidthThreshold: 1024,
});
// imageSlider.initialize();
// cookieConsent.initialize(['matomo', 'youtube']);
// matomoTracking.initialize();
// youtubeInject.initialize();
// cookieConsent.checkCookieConsent();
