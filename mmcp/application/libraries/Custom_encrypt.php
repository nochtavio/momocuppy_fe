<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Custom_encrypt {

  public function encrypt_string($string) {
    $secret_key = "momocuppy123";
    $encrypted_string = sha1($secret_key . $string);

    return $encrypted_string;
  }
}
