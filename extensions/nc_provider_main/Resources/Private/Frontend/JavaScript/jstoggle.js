'use strict';

// Encapsulate your code in an IIFE (Immediately Invoked Function Expression) to avoid polluting the global scope.
const jsToggle = (() => {
  const initialize = () => {
    document.documentElement.classList.remove('no-js');
    document.documentElement.classList.add('js');
  };

  // Public API of the module (revealing module pattern).
  return {
    initialize
  };
})();

// Export the module for use in other parts of your application if necessary.
export default jsToggle;
