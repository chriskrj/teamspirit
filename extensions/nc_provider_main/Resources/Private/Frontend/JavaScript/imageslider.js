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
            behavior: "smooth",
          });
        };

        const scrollNext = () => {
          imageList.scrollBy({
            left: imageList.clientWidth,
            behavior: "smooth",
          });
        };

        updateButtonStates();

        prevButton.addEventListener("click", scrollPrevious);
        nextButton.addEventListener("click", scrollNext);
        imageList.addEventListener("scroll", updateButtonStates);
      });
    }


    // document.body.addEventListener('click', function (e) {
    //
    //   const trigger = e.target.closest('.js-imageslider-trigger');
    //
    //   if (trigger) {
    //
    //     e.preventDefault();
    //     // const trigger = e.target;
    //     const slider = document.getElementById(trigger.getAttribute('aria-controls'));
    //     const direction = trigger.getAttribute('data-direction');
    //     const currentIndex = parseInt(slider.getAttribute('data-current'), 10) || 0;
    //     const slideItems = slider.querySelectorAll('.js-imageslider-item');
    //
    //     let targetIndex = currentIndex;
    //
    //     if (direction === 'prev') {
    //       if (currentIndex > 0) {
    //         targetIndex = currentIndex - 1;
    //       }
    //     }
    //
    //     if (direction === 'next') {
    //       if (currentIndex < slideItems.length - 1) {
    //         targetIndex = currentIndex + 1;
    //       }
    //     }
    //
    //     const scrollTarget = slideItems[targetIndex];
    //
    //     if (scrollTarget) {
    //       scrollTarget.scrollIntoView({inline: 'center', block: 'nearest'});
    //     }
    //
    //     // Update aria-disabled attribute for the buttons
    //     const triggerButtons = document.body.querySelectorAll('[aria-controls="' + trigger.getAttribute('aria-controls') + '"]');
    //     triggerButtons.forEach(triggerButton => {
    //       const direction = triggerButton.getAttribute("data-direction");
    //
    //       if ((direction === "prev" && targetIndex === 0) || (direction === "next" && targetIndex === slideItems.length - 1)) {
    //         triggerButton.setAttribute("aria-disabled", "true");
    //       } else {
    //         triggerButton.setAttribute("aria-disabled", "false");
    //       }
    //     });
    //
    //     slider.setAttribute('data-current', targetIndex);
    //   }
    //
    // });

  };

  return {
    initialize
  };
})();

export default imageSlider;
