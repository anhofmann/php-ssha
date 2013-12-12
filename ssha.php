<?php

/***
*
* Original code is found at http://coding.debuntu.org/php-how-calculate-ssha-value-string
* but was buggy (giving the pack function everything delimited with "," instead of "."
* 
***/
 
function make_ssha_password($password){
  mt_srand((double)microtime()*1000000);
  $salt = pack("CCCC". mt_rand(). mt_rand(). mt_rand(). mt_rand());
  $hash = "{SSHA}" . base64_encode(pack("H*", sha1($password . $salt)) . $salt);
  return $hash;
}
 
function ssha_password_verify($hash, $password){
  // Verify SSHA hash
  $ohash = base64_decode(substr($hash, 6));
  $osalt = substr($ohash, 20);
  $ohash = substr($ohash, 0, 20);
  $nhash = pack("H*", sha1($password . $osalt));
  if ($ohash == $nhash) {
    return True;
  } else {
    return False;
  }
}
 
$encpass = make_ssha_password($argv[1]);
print("Encoded password is: $encpass\n");
 
if(ssha_password_verify($encpass, $argv[1])){
  print("Password could be verified\n");
}else{
  print("Password could  not be verified\n");
}
