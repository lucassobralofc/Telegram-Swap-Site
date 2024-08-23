<?php
  // Get form data
  $action = isset($_POST['action']) ? $_POST['action'] : '';
  $amount = isset($_POST['amount']) ? $_POST['amount'] : '';

  if (!$action || !$amount) {
    echo json_encode(["error" => "All fields are required."]);
    exit;
  }

  // Static conversion rates
  $duco_elap = 1.5;
  $elap_duco = 1 / 1.5;
  $nano_elap = 1980.20;
  $banano_elap = 8.456;

  // Calculate amounts based on action
  $result = 0;
  $token = '';

  switch ($action) {
    case 'buy':
      $result = $amount * $duco_elap;
      $token = 'Elap';
      break;
    case 'buy_duco':
      $result = $amount * $elap_duco;
      $token = 'Duco';
      break;
    case 'buy_nano':
      $result = $amount * $nano_elap;
      $token = 'Elap';
      break;
    case 'buy_banano':
      $result = $amount * $banano_elap;
      $token = 'Elap';
      break;
    case 'buy_palladium':
      echo json_encode(["error" => "We do not accept Palladium due to the network being turned off."]);
      exit;
    default:
      echo json_encode(["error" => "Invalid action."]);
      exit;
  }

  echo json_encode(["result" => $result, "token" => $token]);
?>
