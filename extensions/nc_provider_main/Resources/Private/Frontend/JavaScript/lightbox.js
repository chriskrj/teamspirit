/*global GLightbox */
'use strict';

const lightbox = (() => {
  const initialize = () => {
    const lightbox = GLightbox({
      selector: '.js-lightbox',
      touchNavigation: true,
      loop: true,
      // autoplayVideos: true
    });

    const lightboxTeaser = GLightbox({
      selector: '.js-lightbox-teaser',
      skin: 'maxWidth',
      touchNavigation: true,
      loop: true,
      // autoplayVideos: true
    });

    const lightboxInline = GLightbox({
      selector: '.js-lightbox-inline',
      width: '1100px',
      height: 'auto',
      // closeButton: false,
      touchNavigation: false,
      draggable: false
      // keyboardNavigation: false,
      // autoplayVideos: true
    });

    lightboxInline.on('open', function () {
      const currentSlide = document.querySelector('.gslide.loaded.current');
      const focusableElements = currentSlide.querySelectorAll('input:not(:disabled), textarea:not(:disabled), a:not(:disabled), button:not(:disabled), select:not(:disabled)');
      if (focusableElements.length > 0) {
        focusableElements[0].focus();
      }
    });

    document.addEventListener('click', function (event) {
      const target = event.target;
      if (target.matches('.js-lightbox-close')) {
        lightboxTeaser.close();
      }
    });

    document.addEventListener('click', function (event) {
      const target = event.target;
      if (target.matches('.js-lightbox-close')) {
        lightbox.close();
      }
    });
  };
  return {
    initialize
  };
})();

export default lightbox;
