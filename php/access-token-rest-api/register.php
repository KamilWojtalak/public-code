<?php

declare(strict_types=1);

use App\Src\Database;
use App\Src\UserGateway;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    /** Databse connection */
    $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $dbc = $db->getConnection();

    /** Get user gateway */
    $user_gateway = new UserGateway($dbc);

    /** Get form data without validation */
    $name = $_POST['name'];
    $password = $_POST['password'];

    /** Password hash */
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    /** Staticly assigned username */
    $username = $name . ' username';

    /** Create random API KEY */
    $api_key_bytes = random_bytes(16);
    $api_key = bin2hex($api_key_bytes);

    /** Create user */
    $user_gateway->create($name, $username, $password_hash, $api_key);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <?php
        $bytes = random_bytes(2);
        $text = bin2hex($bytes);
        ?>
        <div class="">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $text; ?> name">
        </div>
        <div class="">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php echo $text; ?> password">
        </div>
        <div class="">
            <input type="submit" value="Submit">
        </div>
    </form>
    <?php if (isset($api_key)) : ?>
        <div class="">
            Successfully register a new user with an api key of: <b><?php echo $api_key; ?></b>
        </div>
    <?php endif; // if(isset($api_key)) : 
    ?>
</body>

</html>