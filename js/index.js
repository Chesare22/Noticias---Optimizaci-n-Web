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
      success (pages) {
        const dateFormatter = new Intl.DateTimeFormat('es-MX', { year: 'numeric', month: 'long', day: 'numeric' });
        const elements = pages.map(page => {
          const linkAndDescription = document.createElement('div');
          linkAndDescription.className = 'link-and-description';

          const link = document.createElement('h3');
          $(link).append(
            $(document.createElement('a'))
              .attr('href',page.URL)
              .attr('target','_blank')
              .text(page.Title)
          );
          linkAndDescription.appendChild(link);

          const date = document.createElement('div');
          date.className = 'date';
          date.innerText = dateFormatter.format(new Date(page.Date));
          linkAndDescription.appendChild(date);

          const description = document.createElement('div');
          description.className = 'description';
          description.innerText = page.Text;
          linkAndDescription.appendChild(description);

          return linkAndDescription;
        })

        $('#results')
          .empty()
          .append(...elements)
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