const scrollCheck = (() => {
  let isScrolled = false;
  let isScrollingUp = false;
  let lastScrollTop = 0;
  const $docElement = document.documentElement;

  // default offsetTrigger values
  let offsetTrigger = {
    mobile: 60,
    desktop: 60,
  };
  let windowWidthThreshold = 768; // Default value

  const update = () => {
    const scrollTop = Math.round(window.scrollY);
    const windowWidth = window.innerWidth;

    const offsetTriggerY = windowWidth >= windowWidthThreshold ? offsetTrigger.desktop : offsetTrigger.mobile;

    if (scrollTop > offsetTriggerY !== isScrolled) {
      isScrolled = !isScrolled;
      const actionClass = isScrolled ? 'is-scroll' : 'is-noScroll';
      const event = new Event(`scrollcheck/${actionClass}`);
      $docElement.classList.remove(isScrolled ? 'is-noScroll' : 'is-scroll');
      $docElement.classList.add(actionClass);
      $docElement.dispatchEvent(event);
    }

    if (scrollTop > lastScrollTop || scrollTop === 0 !== isScrollingUp) {
      isScrollingUp = !isScrollingUp;
      const actionClass = isScrollingUp ? 'is-scrollTop' : 'is-scrollDown';
      const event = new Event(`scrollcheck/${actionClass}`);
      $docElement.classList.remove(isScrollingUp ? 'is-scrollDown' : 'is-scrollTop');
      $docElement.dispatchEvent(event);
    }

    lastScrollTop = scrollTop;
  };

  const handleEvent = () => {
    window.requestAnimationFrame(update);
  };

  const initialize = (options = {}) => {
    $docElement.classList.add('is-noScroll');
    document.addEventListener('scroll', handleEvent, false);
    window.addEventListener('load', handleEvent, false);
    window.addEventListener('resize', handleEvent, false);
    window.addEventListener('orientationchange', handleEvent, false);

    if (options.offsetTrigger) {
      offsetTrigger = {
        ...offsetTrigger,
        ...options.offsetTrigger,
      };
    }

    if (options.windowWidthThreshold) {
      windowWidthThreshold = options.windowWidthThreshold;
    }
  };

  // Public API of the module (revealing module pattern).
  return {
    initialize,
  };
})();

export default scrollCheck;
