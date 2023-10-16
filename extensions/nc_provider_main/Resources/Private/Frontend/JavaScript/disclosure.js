/*
Disclosure widget for dropdowns, accordions, tabs, etc.

articles:
https://www.scottohara.me/blog/2017/10/25/accordion-release.html
https://adrianroselli.com/2020/05/disclosure-widgets.html

 */
'use strict';

const disclosure = (() => {
  const toggleDisclosure = (trigger, ariaControls) => {
    const panel = document.getElementById(ariaControls);
    if (panel) {
      if (panel.getAttribute('aria-hidden') === 'true') {
        openDisclosure(panel);
      } else {
        closeDisclosure(panel);
      }
    }
  }

  const openDisclosure = (panel) => {

    // get all trigger with panel id aria-controls
    const triggers = document.querySelectorAll(`.js-disclosure-trigger[aria-controls="${panel.id}"]`);
    triggers.forEach((trigger) => {
      trigger.classList.add('is-open');
      trigger.setAttribute('aria-expanded', 'true');
    });

    // open panel
    panel.setAttribute('aria-hidden', 'false');
    panel.classList.add('is-open');

    // check for multiexpand and close other panels
    const disclosureList = panel.closest('.js-disclosure-list');
    if (disclosureList) {
      // get data attribute data-disclosure-multiexpand from disclosureList
      const multiExpand= disclosureList.dataset.disclosureMultiexpand || 'true';

      if( multiExpand === 'false' ) {
        // get all panels from disclosureList
        const panels = disclosureList.querySelectorAll('.js-disclosure-panel');
        panels.forEach((groupPanel) => {
          if( groupPanel.id !== panel.id ) {
            closeDisclosure(groupPanel);
          }
        });
      }
    }
  }

  const closeDisclosure = (panel) => {
    // get all trigger with panel id aria-controls
    const triggers = document.querySelectorAll(`.js-disclosure-trigger[aria-controls="${panel.id}"]`);
    triggers.forEach((trigger) => {
      trigger.classList.remove('is-open');
      trigger.setAttribute('aria-expanded', 'false');
    });

    panel.setAttribute('aria-hidden', 'true');
    panel.classList.remove('is-open');
  }

  // check if disclosure panels should be disabled
  const updatePanelsDisableCheck = () => {
    const panels = document.querySelectorAll('.js-disclosure-panel[data-disclosure-disable-at]');

    if (panels.length) {

      panels.forEach(function (panel) {
        const disableAtMq = panel.getAttribute('data-disclosure-disable-at');

        if (window.matchMedia(disableAtMq).matches) {
          openDisclosure(panel);
        } else {
          closeDisclosure(panel);
        }
      });
    }
  }

  const initialize = () => {
    document.addEventListener('click', (e) => {

      const trigger = e.target.closest('.js-disclosure-trigger');

      if (trigger) {
        e.preventDefault();
        // const trigger = e.target;
        const ariaControls = trigger.getAttribute('aria-controls');
        toggleDisclosure(trigger, ariaControls);
      }
    });

    // initial open Disclosure from anchor link
    if (window.location.hash) {
      const hash = window.location.hash.replace(/[!"!$&='()*+,./:;<=>?@\[\\\]^`{|}~]/g, '-');
      const element = document.querySelector(hash);

      if (element && element.classList.contains('js-disclosure-panel')) {
        openDisclosure(element);
      }
    }

    // Update Panels Disable Check on window resize/orientationchange/load events
    ['orientationchange', 'resize', 'load'].forEach(eventType => {
      window.addEventListener(eventType, updatePanelsDisableCheck);
    });

    updatePanelsDisableCheck();

  }

  return {
    initialize
  }
})();

export default disclosure;
