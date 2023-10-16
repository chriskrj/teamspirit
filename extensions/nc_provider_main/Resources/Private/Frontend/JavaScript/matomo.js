'use strict';

const matomoTracking = (() => {
  let _mtm = window._mtm = window._mtm || [];
  let trackingCodeAdded = false;
  const addTrackingCode = () => {

    if (!trackingCodeAdded) {
      trackingCodeAdded = true;
      console.log('add matomo tracking code here');

      // _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
      // var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      // g.async=true; g.src='https://matomo.example.com/js/container_RaTSOlmR.js'; s.parentNode.insertBefore(g,s);
    }
  }

  const removeTrackingCode = () => {

    if (trackingCodeAdded) {
      if (typeof window._paq != 'undefined') {
        // console.log('opt out');
        // _paq.push(['optUserOut']);
        window._paq.push(['disableCookies']);
      }
      trackingCodeAdded = false;
      console.log('remove matomo tracking code here');
    }
  }

  const initialize = () => {
    document.addEventListener('cookieconsent/update', event => {
      if (event.detail.matomo) {
        addTrackingCode();
      } else {
        removeTrackingCode();
      }
    });
  }

  return {
    initialize
  }
})();

export default matomoTracking;
