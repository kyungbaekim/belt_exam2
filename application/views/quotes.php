<?php
  // var_dump($this->session->all_userdata());
  // var_dump($all_quotes);
  // var_dump($favorites);
  function isFound($arr, $value){
    $i = 0;
    while($i < count($arr)){
      if($arr[$i] == $value){
        return true;
      }
      $i++;
    }
    return false;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Quotes</title>
  <style>
    .wrapper{
      width: 800px;
      margin: 20px auto;
      /*border: 1px solid grey;*/
    }
    .menu{
      height: 40px;
      text-align: right;
    }
    h3{
      margin: 10px 0px;
    }
    .quotes, .favorites{
      display: inline-block;
      width: 385px;
      /*border: 1px solid silver;*/
      vertical-align: top;
    }
    .favorites{
      margin-left: 20px;
    }
    .notice, .error{
      color: red;
      font-size: 12px;
    }
    .quote_list, .favorite_list{
      overflow-y: scroll;
    }
    .quote_list{
      height: 800px;
    }
    .favorite_list{
      height: 450px;
    }
    .add_quote{
      margin-top: 110px;
      margin-left: 30px;
    }
    .quote{
      border: 1px solid silver;
      margin: 5px;
      padding: 10px;
    }
    form{
      margin: 0px;
    }
    </style>
</head>
<body>
  <div class='wrapper'>
    <div class='menu'><a href='/log_off'>Logout</a></div>
    <div class='header'><h1>Hello, <?= $this->session->userdata['user_alias'] ?>!</h1></div>
    <div class='body'>
      <div class='quotes'>
        <h3>Quotable Quotes</h3>
        <div class='quote_list'>
          <?php
            $temp = [];
            for($i=0; $i<count($favorites); $i++){
              $temp[] = $favorites[$i]['id'];
            }
            // var_dump($temp);
            foreach ($all_quotes as $key => $value) {
              if(!isFound($temp, $value['id'])){
                echo "<div class='quote'>";
                echo "<form action='/add_favorite/".$value['id']."' methods='post'>";
                echo "<table><tr><td colspan=2>";
                echo "<p>".$value['quoted_by'].": ".$value['quote']."</p><br></td></tr>";
                echo "<tr><td><font size='2'>Posted by <a href='/users/".$value['user_id']."'>".$value['name']."</a></font></td>";
                echo "<td align=right><input type='submit' value='Add to My List'></td></tr>";
                echo "</table></form></div>";
              }
            }
          ?>
        </div>
      </div>
      <div class='favorites'>
        <h3>Your Favorites</h3>
        <div class='favorite_list'>
          <?php
            foreach ($favorites as $key => $value) {
              echo "<div class='quote'>";
              echo "<form action='/remove_favorite/".$value['id']."' methods='post'>";
              echo "<table><tr><td colspan=2>";
              echo "<p>".$value['quoted_by'].": ".$value['quote']."</p><br></td></tr>";
              echo "<tr><td><font size='2'>Posted by <a href='/users/".$value['user_id']."'>".$value['name']."</a></font></td>";
              echo "<td align=right><input type='submit' value='Remove From My List'></td></tr>";
              echo "</table></form></div>";
            }
          ?>
        </div>
        <div class='add_quote'>
          <h3>Contribute a Quote</h3>
          <?php
            if(isset($add_errors)){
              echo $add_errors;
              echo "<br>";
            }
          ?>
          <form action='/add_quote' method='post'>
            <table>
              <tr><td>Quoted By: </td><td><input type='text' name='quoted_by'></td></tr>
              <tr><td valign=top>Mesasge: </td><td><textarea cols=30 rows=10 name='message'></textarea></td></tr>
              <tr><td colspan=2 align=right><input type='submit' value='Submit'></td></tr>
            </table>
          </form>
        </div>
      </div>
    </div>
    </div>
    </div>
  </div>
</body>
</html>
