# Subtitler Mini API

BASEURL: `https://subtlr.herokuapp.com`

| Operation | Action | Route |
|---|---|---|
| Home | GET | `/home.php` |
| Search | GET | `/search.php?q=[search query]` |
| Movie Subtitles | GET | `/movie.php?lang=[INT, Language]&url=[subtitle url]` |
| Downloadable Links | GET | `/links.php&url=[subtitle url]` |
| Download Subtitle File | GET | `/download.php?mac=[subtitle mac]` |