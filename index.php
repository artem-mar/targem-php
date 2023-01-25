<?php
include './db/db.php';

mysqli_query(
  $connection,
  "CREATE TABLE IF NOT EXISTS players
    (
      nickname VARCHAR(25) not null,
      email VARCHAR(25) not null,
      registrationDate INT(255) not null,
      status VARCHAR(10) not null,
      PRIMARY KEY (nickname)
    )"
);

$filepath = './players.csv';

if (($file = fopen($filepath, 'r')) !== false) {
  while (($row = fgetcsv($file, 500, ';')) !== false) {
    $nickname = trim($row[0]);
    $email = trim($row[1]);
    $registrationDate = trim($row[2]);
    $status = trim($row[3]);


    if (strlen($status) < 5) {
      $date = date_create_from_format('d.m.Y G:i', $registrationDate);
      $timestamp = date_timestamp_get($date);

      mysqli_query(
        $connection,
        "REPLACE INTO players
        (nickname, email, registrationDate, status)
        VALUES ('{$nickname}', '{$email}', '{$timestamp}', '{$status}')",
      );
    }
  }
  fclose($file);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>targem php</title>
</head>
<body>
  <div class="container">
    <table class="table mt-5">
      <caption>Игроки в онлайне</caption>
      <thead>
        <tr>
          <th>Ник</th>
          <th>Емейл</th>
          <th>Зарегистрирован</th>
          <th>Статус</th>
        </tr>
      </thead>

      <tbody>
        <?php
          $query = mysqli_query(
            $connection,
            "SELECT * FROM players WHERE status = 'On' ORDER BY registrationDate ASC",
          );

          while ($user = mysqli_fetch_assoc($query)) {
            [
              'nickname' => $nickname,
              'email' => $email,
              'registrationDate' => $timeStamp,
              'status' => $status,
            ] = $user;
            $regDate = date('d.m.Y H:i', $timeStamp);
            ?>

              <tr>
                <td><?php echo $nickname ?></td>
                <td><?php echo $email ?></td>
                <td><?php echo $regDate ?></td>
                <td><?php echo $status ?></td>
              </tr>

            <?php
          }

        ?>
      </tbody>
    </table>
  </div>
</body>
</html>