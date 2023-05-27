## Overview
The TMDb Movie Fetcher plugin is a WordPress plugin that fetches movie data from the TMDb (The Movie Database) API. It allows users to display movie information such as title, release date, overview, genres, poster, and where to watch information on their WordPress websites using shortcodes.

## Plugin Details
- **Plugin Name:** TMDb Movie Fetcher
- **Description:** Fetches movie data from TMDb API.
- **Version:** 1.0
- **Author:** Chat GPT, Prompts by Digital Malayali 😏

## Installation
1. Download the plugin ZIP file.
2. Log in to your WordPress admin panel.
3. Go to "Plugins" and click on "Add New."
4. Click on the "Upload Plugin" button.
5. Choose the plugin ZIP file and click "Install Now."
6. After installation, click on "Activate" to activate the plugin.

## Configuration
1. Obtain a TMDb API key:
   - Visit the [TMDb website](https://www.themoviedb.org/) and create an account if you don't have one.
   - Go to your account settings and navigate to the API section.
   - Generate an API key for your application.
2. Update the plugin code with your TMDb API key:
   - Open the plugin file (tmdb-movie-fetcher.php) in a text editor.
   - Locate the line `define('TMDB_API_KEY', 'paste_your_api_from_tmdb');`.
   - Replace `'paste_your_api_from_tmdb'` with your actual TMDb API key.
   - Save the changes.

## Shortcodes
The TMDb Movie Fetcher plugin provides the following shortcodes to display movie information:

- `[tmdb_movie_title]`: Displays the movie title.
- `[tmdb_movie_release_date]`: Displays the movie release date.
- `[tmdb_movie_overview]`: Displays the movie overview.
- `[tmdb_movie_cast_and_crew]`: Displays the movie cast and crew data (not available in this version).
- `[tmdb_movie_trailer]`: Displays the movie trailer data (not available in this version).
- `[tmdb_movie_where_to_watch]`: Displays the streaming providers where the movie is available.
- `[tmdb_movie_poster]`: Displays the movie poster image.
- `[tmdb_movie_genres]`: Displays the movie genres.

## Usage
To use the shortcodes, insert them into the desired location (e.g., post content, page content, widget, etc.) within your WordPress website.

Examples:
- To display the movie title: `[tmdb_movie_title id="12345"]`
Replace `12345` with the ID of the movie you want to fetch.
- To display the movie release date:
`[tmdb_movie_release_date id="12345"]`
- To display the movie overview:
`[tmdb_movie_overview id="12345"]`
- To display the movie genres:
`[tmdb_movie_genres id="12345"]`
- To display the movie poster:
`[tmdb_movie_poster id="12345"]`
- To display the streaming providers where the movie is available:
`[tmdb_movie_where_to_watch id="12345"]`
Note: Replace `12345` with the ID of the movie you want to fetch.

## Limitations
- The plugin may encounter errors if the TMDb API key is not provided or is invalid.
- The movie cast and crew data and movie trailer data
