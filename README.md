<p align="center">
<img src="./public/assets/movlog.jpg" alt="Movlog"></img>
</p>

# Author
<p align="center">
<img src="https://github.com/fkbral.png" alt="Movlog" style="border-radius: 50%;" width="80"></img>
</p>

# About

Organize your movies! Built with PHP, MySQL, JavaScript and OMDB api.

# Features
- 🔍 Find movies or tv shows with detailed description straight from IMDb sources
- ✨ Save movies in watch lists:
  - ⏳ Plan to watch: organize your binge sessions
  - ✅ Watched: catalog your "collection"
- 📱 Mobile friendly interface

# Web app showcase
<p align="center">
  <img src="./_captures/movlog.gif">
</p>

# Run Locally
## Requisites
PHP, Apache server and MariaDB or MySQL installed

## Instructions
- Start your MariaDB/MySQL instance in port **3306**
- Open the project root folder in your terminal and run:
```bash
#migrations for database and tables creation
php -f ./src/database/migrations/index.php
```
- Generate a free api key for OMDB: https://omdbapi.com/apikey.aspx
- Create a credentials.json file in your project root just like the credentials.example.json with your newly generated omdb api key.