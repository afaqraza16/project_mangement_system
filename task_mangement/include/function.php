<?php

function isLogin()
{
  return (isset($_SESSION['isLogin']) && $_SESSION['isLogin']);
}
