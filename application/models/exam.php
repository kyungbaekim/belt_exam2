<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends CI_Model {

  function get_user_by_email($email){
    $query = "SELECT * FROM users WHERE email = '{$email}'";
    return $this->db->query($query)->row_array();
  }

  function get_user_by_id($id){
    $query = "SELECT * FROM users WHERE id = '{$id}'";
    return $this->db->query($query)->row_array();
  }

  function add_user($name, $alias, $email, $password, $birthday){
    $query = "INSERT INTO users (name, alias, email, password, birthday, created_at) VALUES ('{$name}', '{$alias}', '{$email}', '{$password}', '{$birthday}', NOW())";
    return $this->db->query($query);
  }

  function get_all_quotes($user_id){
    $query = "SELECT quotes.id, quotes.user_id, users.name, quotes.quoted_by, quotes.quote FROM quotes
            	LEFT JOIN users on quotes.user_id = users.id";
    return $this->db->query($query)->result_array();
  }

  function add_quote($user_id, $quoted_by, $message){
    $query = "INSERT INTO quotes (user_id, quoted_by, quote, created_at) VALUES ('{$user_id}', '{$quoted_by}', '{$message}', NOW())";
    return $this->db->query($query);
  }

  function add_favorite($user_id, $quote_id){
    $query = "INSERT INTO favorites (user_id, quote_id) VALUES ('{$user_id}', '{$quote_id}')";
    return $this->db->query($query);
  }

  function get_all_favorite_quotes($user_id){
    $query = "SELECT quotes.id, quotes.user_id, users.name, quotes.quoted_by, quotes.quote, favorites.user_id AS user_added_to_favorites FROM quotes
            	LEFT JOIN users on quotes.user_id = users.id
            	LEFT JOIN favorites on quotes.id = favorites.quote_id
            	LEFT JOIN users as users2 on favorites.user_id = users2.id
            	WHERE favorites.user_id = '{$user_id}'";
    return $this->db->query($query)->result_array();
  }

  function get_user_quotes($id){
    $query = "SELECT users.id AS user_id, users.name, quotes.id AS quotes_id, quotes.quoted_by, quotes.quote FROM users
              LEFT JOIN quotes
              ON users.id = quotes.user_id
              WHERE users.id = '{$id}'";
    return $this->db->query($query)->result_array();
  }

  function get_number_of_user_quote($id){
    $query = "SELECT users.id AS user_id, users.name, users.alias, count(quotes.id) AS count FROM users
              LEFT JOIN quotes
              ON users.id = quotes.user_id
              WHERE users.id = '{$id}'";
    return $this->db->query($query)->row_array();
  }

  function remove_favorite($user_id, $quote_id){
    $query = "DELETE FROM favorites WHERE quote_id = '{$quote_id}' AND user_id = '{$user_id}'";
    return $this->db->query($query);
  }
}
