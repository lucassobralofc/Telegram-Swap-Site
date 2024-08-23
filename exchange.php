<?php
  // Configuration token 
  $telegram_api_token = 'skibiid password';
  $telegram_chat_id = 'skibidi id';
  
  // so when so sad kinda to love some one and they pick up evry think and they dont make happend kinda sad to me   
  // Get form data and validate The action
  $action = isset($_POST['action']) ? $_POST['action'] : '';
  $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $elap_username = isset($_POST['elap_username']) ? $_POST['elap_username'] : '';
  $swap_address = isset($_POST['swap_address']) ? $_POST['swap_address'] : '';
  $ip_address = $_SERVER['REMOTE_ADDR']; // Capture user's IP address

  if (!$action || !$amount || !$email || !$elap_username || !$swap_address) {
    echo "All fields are required.";
    exit;
  }

  // Static conversion rates , maybe duco is wrong the elapta is not full code on github
  $duco_elap = 1.05;
  $elap_duco = 1 / 1.5;
  $nano_elap = 1980.20;
  $banano_elap = 8.400;

  // Calculate amounts based on action,exe:"1 duco , see the ratio after do difzation, is simple the calcs!
  if ($action == 'buy') {
    $duco_amount = $amount;
    $elap_amount = $amount * $duco_elap;
    $message = "Action: Buy Elapta\nAmount: $amount\nPlz send $duco_amount Duco to receive $elap_amount Elap.\nEmail: $email\nElap Username: $elap_username\nSwap Address: $swap_address\nIP: $ip_address";
  } elseif ($action == 'buy_duco') {
    $elap_amount = $amount;
    $duco_amount = $amount * $elap_duco;
    $message = "Action: Buy Duco\nAmount: $amount\nPlease send $elap_amount Elap to receive $duco_amount Duco.\nEmail: $email\nElap Username: $elap_username\nSwap Address: $swap_address\nIP: $ip_address";
  } elseif ($action == 'buy_palladium') {
    echo "We do not accept Palladium due to the network being turned off.";
    exit;
  } elseif ($action == 'buy_nano') {
    $nano_amount = $amount;
    $elap_amount = $amount * $nano_elap;
    $message = "Action: Buy Elap\nAmount: $amount\nPlease send $nano_amount Nano to receive $elap_amount Elap.\nEmail: $email\nElap Username: $elap_username\nSwap Address: $swap_address\nIP: $ip_address";
  } elseif ($action == 'buy_banano') {
    $banano_amount = $amount;
    $elap_amount = $amount * $banano_elap;
    $message = "Action: Buy Elap\nAmount: $amount\nPlease send $banano_amount Banano to receive $elap_amount Elap.\nEmail: $email\nElap Username: $elap_username\nSwap Address: $swap_address\nIP: $ip_address";
  } else {
    echo "Invalid action.";
    exit;
  }

  // Send Telegram message
  $telegram_url = "https://api.telegram.org/bot$telegram_api_token/sendMessage";
  $telegram_data = array('chat_id' => $telegram_chat_id, 'text' => $message);

  $ch = curl_init($telegram_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($telegram_data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  $telegram_result = curl_exec($ch);
  $telegram_error = curl_error($ch);
  curl_close($ch);

  if ($telegram_error) {
    echo "Error sending message, Check if something is blocking the telegram Node!: $telegram_error";
  } else {
    echo "Thanks! You should receive the info to deposit in some minutes or hours; check your email (spam too).";
  }
?>
