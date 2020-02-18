const url = 'http://www.reforma.com/rss/portada.xml';

function getNews (addNews) {
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('get', `php-functions/getNews.php?url=${url}`, true);
  xmlhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      addNews(JSON.parse(this.responseText));
    }
  };
  xmlhttp.send();
}

window.addEventListener('DOMContentLoaded', () => {
  getNews(news => {
    const link = document.getElementById('title');
    link.innerText = news.title;
    link.href = news.link;
    document.getElementById('author').innerText = news.author;
    document.getElementById('date').innerText = news.date;
    document.getElementById('description').innerText = news.description;
    document.getElementById('content').innerText = news.content;
  });
});