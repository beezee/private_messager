<?php

namespace PM;

class Base
{

  private $_adapter;

  public function adapter()
  {
    return $this->_adapter ?: \PM\Service::adapter();
  }

  public function set_adapter($adapter)
  {
    $this->_adapter = $adapter;
  }

  public function __toString()
  {
    return get_class($this);
  }
}
