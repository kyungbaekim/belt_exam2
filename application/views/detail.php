<?php
  // var_dump($this->session->all_userdata());
  // var_dump($quote_count);
  // var_dump($user_quotes);
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
    }
    td{
      padding: 2px 10px 0px 0px;
      /*border: 1px solid black;*/
      margin: 0px
    }
    th{
      background-color: lightgrey;
    }
    .menu{
      height: 40px;
      text-align: right;
    }
    h3{
      margin: 10px 0px;
    }
    .top{
      margin-bottom: 50px;
    }
    </style>
</head>
<body>
  <div class='wrapper'>
    <div class='menu'><a href='/quotes'>Dashboard</a>&emsp;<a href='/log_off'>Logout</a></div>
    <div class='body'>
      <div class='top'>
        <p>Posts by <?= $quote_count['alias'] ?></p>
        <p>Count: <?= $quote_count['count'] ?></p>
      </div>
      <div class='bottom'>
        <?php
        foreach ($user_quotes as $key => $value) {
          echo "<div class='quote'><p><font color='red'>".$value['quoted_by'].":</font> ".$value['quote'];
          echo "<br></div>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
