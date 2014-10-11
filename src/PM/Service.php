<?php

namespace PM;

class Service
{
  private static $_instance;
  private static $_adapter;

  private function __construct()
  {
    // just for visibility control
  }

  public static function register_adapter($adapter)
  {
    if (!is_a($adapter, 'PM\Adapter'))
      throw new \Exception('PM\Service::register_adapter can only accept '.
        'subclass of PM\Adapter');
    self::$_adapter = $adapter; 
  }

  public static function adapter()
  {
    return self::$_adapter;
  }
  
  public static function instance()
  {
    if (!is_a(self::$_adapter, '\PM\Adapter'))
      throw new \Exception('No adapter registered with \PM\Service');
    return (is_object(self::$_instance)
      and get_class(self::$_instance) == 'PM\Service')
        ? self::$_instance
        : self::$_instance = new \PM\Service();
  }
}
