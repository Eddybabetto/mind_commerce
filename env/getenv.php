<?php 
function getenvterm($term){
  $env = parse_ini_file(".env");
  return $env[$term];
}