/*
dialog interaction

Usage:
<dialog id="dialog-id"></dialog>
<button class="js-dialog-trigger-open" data-dialog-id="dialog-id">open dialog</button>
<button class="js-dialog-trigger-close" data-dialog-id="dialog-id">close dialog</button>
*/

'use strict';

const dialog = (() => {

  const showDialog = (dialogId) => {

    // get dialog element
    const dialog = document.getElementById(dialogId);

    if( dialog === null ) {
      return;
    }

    dialog.showModal();
    dialog.focus();

    // close dialog on outside click
    dialog.addEventListener('click', clickOutsideDialog);
  };
  const closeDialog = (dialogId) => {

    const dialog = document.getElementById(dialogId);

    if( dialog === null ) {
      return;
    }

    dialog.removeEventListener('click', clickOutsideDialog);
    dialog.close();
  };

  const clickOutsideDialog = (e) => {

    const dialog = e.target.closest('dialog');
    const dialogId = dialog.id;

    if (e.target === dialog) {
      closeDialog(dialogId);
    }
  };

  const initialize = (checks) => {

    document.addEventListener('click', function (e) {

      const openTrigger = e.target.closest('.js-dialog-trigger-open');
      const closeTrigger = e.target.closest('.js-dialog-trigger-close');

      if (openTrigger) {

        e.preventDefault();

        const dialogId = openTrigger.dataset.dialogId;

        if( dialogId === undefined ) {
          return;
        }

        showDialog(dialogId);
      }

      if (closeTrigger) {
        e.preventDefault();

        const dialogId = closeTrigger.dataset.dialogId;

        if( dialogId === undefined ) {
          return;
        }

        closeDialog(dialogId);
      }

    });

  }

  return {
    initialize
  }
})();

export default dialog;
