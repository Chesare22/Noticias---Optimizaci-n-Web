/* global $ */

function autoGrow (element) {
  element.style.height = '30px';
  element.style.height = `${element.scrollHeight - 4}px`;
}

window.onload = () => {
  $('#urls').on('input', function () {
    autoGrow(this);
  });
};