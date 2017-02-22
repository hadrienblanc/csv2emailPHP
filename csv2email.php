<?php
require_once('parse_csv.php');
require_once('my_smtp.php');

require_once('config.php');

if (PASSWORD == "xxx")
  {
    die("Please change the configuration in the config.php file.\n");
  }

if (!isset($argv[1]))
{
  echo("USAGE : php csv2email.php FILENAME\n");
  echo("FILENAME format (with Header) : email,content\n");
  die();
}
else
{
  $emails = parse_csv((file_get_contents($argv[1])));
}

$count = count($emails) - 1;

for ($i = 1; isset($emails[$i]) ; ++$i)
{
  if ($emails[$i][0] != "")
  {
    $content = $emails[$i][1] . $signature;
    $email_destination = $emails[$i][0];

    if (filter_var($email_destination, FILTER_VALIDATE_EMAIL))
    {
      echo "[$i / $count]";

      my_o365_send_email($content, $subject, $email_destination);
    }
    else
    {
      echo "[$i / $count] Error wrong email : $email_destination \n";
    }
  }
  else
  {
    echo "[$i / $count] empty email content\n";
  }
}
