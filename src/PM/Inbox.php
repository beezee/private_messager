<?php

namespace PM;

class Inbox extends \PM\Base
{

  private $_user;

  public $page=1;
  public $page_size=10;

  private function __construct($user)
  {
    $this->_user = $user;
  }
  
  public static function for_user($user)
  {
    return new \PM\Inbox($user);
  }

  public function messages($options=array())
  {
    return $this->adapter()->get_messages_for_inbox($this, $options);
  }

  public function user()
  {
    return $this->_user;
  }
}
