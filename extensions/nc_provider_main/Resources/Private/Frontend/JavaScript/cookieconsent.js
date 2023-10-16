/*
cookieconsent dialog

articles:
https://github.com/GoogleChrome/dialog-polyfill
https://www.scottohara.me/blog/2019/03/05/open-dialog.html
https://www.scottohara.me/blog/2018/05/05/focus-traps.html

// example listen to cookieconsent/update event
document.addEventListener('cookieconsent/update', event => {
  if (event.detail.matomo) {
    addTrackingCode();
  } else {
    removeTrackingCode();
  }
});


*/

'use strict';

const cookieConsent = (() => {

  const cookieBarDialog = document.getElementById('cookieconsentdialog');
  const cookieBar = document.getElementById('cookieconsentbar');
  const cookieName = 'cookieconsent';
  let checkList = [];

  const setCookie = (value, days) => {

    var expires = '';
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toUTCString();
    }
    document.cookie = cookieName + '=' + (value || '') + expires + '; path=/;SameSite=Lax';
  }
  const getCookie = () => {
    var nameEQ = cookieName + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

  const getCookieData = () => {
    const cookieString = getCookie();
    if (cookieString === null) {
      let cookieData = {};
      checkList.forEach((check) => {
        cookieData[check] = 0;
      });
      return cookieData;
    } else {
      return JSON.parse(cookieString);
    }
  }

  const dispatchCookieConsentEvent = () => {
    document.dispatchEvent(new CustomEvent('cookieconsent/update', {detail: getCookieData()}));
  }

  const showCookieDialog = () => {

    // iterate through checksList and set checkbox state from cookie
    const cookieData = getCookieData();

    checkList.forEach((check) => {
      const checkBox = document.getElementById('cookieconsent-check-' + check);

      if (checkBox !== null) {
        checkBox.checked = cookieData[check] === 1
      } else {
        console.warn('cookieconsent checkbox not found: ' + check);
      }
    });

    cookieBarDialog.showModal();
    cookieBarDialog.focus();
  }
  const closeCookieDialog = () => {
    cookieBarDialog.close();
  }

  const saveCookieSettings = () => {

    let cookieData = {};

    checkList.forEach((check) => {
      const checkBox = document.getElementById('cookieconsent-check-' + check);
      if (checkBox !== null) {
        cookieData[check] = checkBox.checked ? 1 : 0
      } else {
        console.warn('cookieconsent checkbox not found: ' + check);
      }
    });

    const cookieString = JSON.stringify(cookieData);

    setCookie(cookieString, 365);
    closeCookieDialog();
    hideCookieBar();

    dispatchCookieConsentEvent();
  }

  const acceptAllCookies = () => {

    let cookieData = {};
    checkList.forEach((check) => {
      cookieData[check] = 1
    });
    const cookieString = JSON.stringify(cookieData);

    setCookie(cookieString, 365);
    closeCookieDialog();
    hideCookieBar();
    dispatchCookieConsentEvent();
  }

  const declineAllCookies = () => {

    let cookieData = {};
    checkList.forEach((check) => {
      cookieData[check] = 0;
    });
    const cookieString = JSON.stringify(cookieData);

    setCookie(cookieString, 365);
    closeCookieDialog();
    hideCookieBar();
    dispatchCookieConsentEvent();
  }

  const hideCookieBar = () => {
    cookieBar.classList.remove('is-open');
  }

  const showCookieBar = () => {
    cookieBar.classList.add('is-open');
  }

  const initialize = (checks) => {

    checkList = checks;

    if (cookieBar === null || cookieBarDialog === null) {
      console.error('cookieconsent not found');
      return;
    }

    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('js-cookieconsent-trigger-open-dialog')) {
        e.preventDefault();
        showCookieDialog();
      }

      if (e.target.classList.contains('js-cookieconsent-trigger-close-dialog')) {
        e.preventDefault();
        closeCookieDialog();
      }

      if (e.target.classList.contains('js-cookieconsent-trigger-save')) {
        saveCookieSettings();
      }

      if (e.target.classList.contains('js-cookieconsent-trigger-decline')) {
        declineAllCookies();
      }

      if (e.target.classList.contains('js-cookieconsent-trigger-accept')) {
        acceptAllCookies();
      }
    });

    // close dialog on outside click
    cookieBarDialog.addEventListener('click', (e) => {
      if (e.target === cookieBarDialog) {
        closeCookieDialog();
      }
    });
  }

// intially check if cookieconsent cookie is set
  const checkCookieConsent = () => {

    const cookieString = getCookie();

    // if no cookie consent is set, show cookieconsent
    if (cookieString === null) {
      showCookieBar();
    }

    dispatchCookieConsentEvent();
  }

  return {
    initialize,
    checkCookieConsent
  }
})();

export default cookieConsent;
