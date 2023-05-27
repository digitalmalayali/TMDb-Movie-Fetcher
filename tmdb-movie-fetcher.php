<?php
/*
Plugin Name: TMDb Movie Fetcher
Description: Fetches movie data from TMDb API.
Version: 1.0
Author: Chat GPT
*/

// Replace 'your-tmdb-api-key' with your actual TMDb API key
define('TMDB_API_KEY', 'paste_your_api_from_tmdb');

// Register shortcodes
add_shortcode('tmdb_movie_title', 'tmdb_movie_title_shortcode');
add_shortcode('tmdb_movie_release_date', 'tmdb_movie_release_date_shortcode');
add_shortcode('tmdb_movie_overview', 'tmdb_movie_overview_shortcode');
add_shortcode('tmdb_movie_cast_and_crew', 'tmdb_movie_cast_and_crew_shortcode');
add_shortcode('tmdb_movie_trailer', 'tmdb_movie_trailer_shortcode');
add_shortcode('tmdb_movie_where_to_watch', 'tmdb_movie_where_to_watch_shortcode');
add_shortcode('tmdb_movie_poster', 'tmdb_movie_poster_shortcode');
add_shortcode('tmdb_movie_genres', 'tmdb_movie_genres_shortcode');

// Movie poster shortcode
function tmdb_movie_poster_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_poster');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $movie_data = fetch_movie_data($movie_id);

    if ($movie_data) {
        $poster_path = $movie_data['poster_path'];
        $poster_url = "https://image.tmdb.org/t/p/w500{$poster_path}";
        return '<img src="' . $poster_url . '" alt="' . $movie_data['title'] . '">';
    } else {
        return 'Error: Could not fetch movie data.';
    }
}

// Movie genres shortcode
function tmdb_movie_genres_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_genres');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $movie_data = fetch_movie_data($movie_id);

    if ($movie_data) {
        $genres = $movie_data['genres'];
        $genre_names = array_map(function($genre) {
            return $genre['name'];
        }, $genres);
        return implode(', ', $genre_names);
    } else {
        return 'Error: Could not fetch movie data.';
    }
}


// Movie title shortcode
function tmdb_movie_title_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_title');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $movie_data = fetch_movie_data($movie_id);

    if ($movie_data) {
        return $movie_data['title'];
    } else {
        return 'Error: Could not fetch movie data.';
    }
}

// Movie release date shortcode
function tmdb_movie_release_date_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_release_date');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $movie_data = fetch_movie_data($movie_id);

    if ($movie_data) {
        return $movie_data['release_date'];
    } else {
        return 'Error: Could not fetch movie data.';
    }
}

// Movie overview shortcode
function tmdb_movie_overview_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_overview');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $movie_data = fetch_movie_data($movie_id);

    if ($movie_data) {
        return $movie_data['overview'];
    } else {
        return 'Error: Could not fetch movie data.';
    }
}

// Movie cast and crew shortcode
function tmdb_movie_cast_and_crew_shortcode($atts) {
    // This function is a placeholder, as the trailer data is not available in the basic movie data.
    // You will need to fetch the videos data separately using the TMDb API.
    return 'Movie cast and crew data is not available in this version of the plugin.';
}
// Movie trailer shortcode
function tmdb_movie_trailer_shortcode($atts) {
    // This function is a placeholder, as the trailer data is not available in the basic movie data.
    // You will need to fetch the videos data separately using the TMDb API.
    return 'Trailer data is not available in this version of the plugin.';
}

// Movie where to watch shortcode
function tmdb_movie_where_to_watch_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'tmdb_movie_where_to_watch');
    $movie_id = $atts['id'];

    if (empty($movie_id)) {
        return 'Error: No movie ID provided.';
    }

    $watch_providers_data = fetch_watch_providers_data($movie_id);

    if ($watch_providers_data) {
        $providers = $watch_providers_data['results']['US']['flatrate'] ?? []; // Change 'US' to the desired country code
        $provider_names = array_map(function($provider) {
            return $provider['provider_name'];
        }, $providers);
        $providers_list = implode(', ', $provider_names);

        return !empty($providers_list) ? 'Where to watch: ' . $providers_list : 'No streaming providers found.';
    } else {
        return 'Error: Could not fetch where to watch data.';
    }
}


// Fetch movie data
function fetch_movie_data($movie_id) {
    $api_url = "https://api.themoviedb.org/3/movie/{$movie_id}?api_key=" . TMDB_API_KEY;

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        error_log('TMDb Movie Fetcher: ' . $response->get_error_message());
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['status_code']) && isset($data['status_message'])) {
        error_log('TMDb Movie Fetcher: ' . $data['status_message']);
        return false;
    }

    return $data;
}

// where to watch funtion
function fetch_watch_providers_data($movie_id) {
    $api_url = "https://api.themoviedb.org/3/movie/{$movie_id}/watch/providers?api_key=" . TMDB_API_KEY;

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        error_log('TMDb Movie Fetcher: ' . $response->get_error_message());
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['status_code']) && isset($data['status_message'])) {
        error_log('TMDb Movie Fetcher: ' . $data['status_message']);
        return false;
    }

    return $data;
}


