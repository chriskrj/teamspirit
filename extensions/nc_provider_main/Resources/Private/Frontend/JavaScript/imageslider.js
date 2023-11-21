/*
Image Slider prev and next Button control
 */
'use strict';

const imageSlider = (() => {

  const initialize = () => {

    const sliderContainers = document.querySelectorAll('.js-imageslider');

    if (sliderContainers) {
      sliderContainers.forEach(container => {
        const prevButton = container.querySelector('.js-imageslider-trigger-prev');
        const nextButton = container.querySelector('.js-imageslider-trigger-next');
        const imageList = container.querySelector('.js-imageslider-list');

        const updateButtonStates = () => {
          prevButton.disabled = imageList.scrollLeft === 0;
          nextButton.disabled = imageList.scrollLeft >= imageList.scrollWidth - imageList.clientWidth;
        };

        const scrollPrevious = () => {
          imageList.scrollBy({
            left: -imageList.clientWidth,
            behavior: 'smooth',
          });
        };

        const scrollNext = () => {
          imageList.scrollBy({
            left: imageList.clientWidth,
            behavior: 'smooth',
          });
        };

        updateButtonStates();

        prevButton.addEventListener('click', scrollPrevious);
        nextButton.addEventListener('click', scrollNext);
        imageList.addEventListener('scroll', updateButtonStates);
      });
    }
  };

  return {
    initialize
  };
})();

export default imageSlider;
