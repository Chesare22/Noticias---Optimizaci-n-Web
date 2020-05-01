/* global $ */
const backendUrl = 'http://localhost/Noticias/php-functions/PageController.php';

function autoGrow (element) {
  element.style.height = '30px';
  element.style.height = `${element.scrollHeight - 4}px`;
}

window.onload = () => {
  $('#urls').on('input', function () {
    autoGrow(this);
  });

  $('#refresh-db').on('click', function () {
    $(this).addClass('loading')
    const selectedUrl = $('#urls').val();
    $.ajax(`${backendUrl}?url=${selectedUrl}`, {
      success (response) {
        console.log(response);
      },
      error (error) {
        console.log(error);
      },
      complete: () => {
        $(this).removeClass('loading')
      }
    });
  });

  $('#consult').on('click', function () {
    const word = $('#search').val();
    $(this).addClass('loading')
    $.ajax(`${backendUrl}?word=${word}`, {
      success (response) {
        console.log(response);
      },
      error (error) {
        console.log(error);
      },
      complete: () => {
        $(this).removeClass('loading');
      }
    });
  });
};