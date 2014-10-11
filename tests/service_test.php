<?php

class ServiceTest extends \Enhance\TestFixture
{

  public function instance_raises_exception_when_no_adapter_registered()
  {
    \Enhance\Assert::throws('PM\Service', 'instance', array());
  }
  
  public function instance_maintains_singleton()
  {
    \PM\Service::register_adapter(new \PM\Adapter\TestAdapter());
    \Enhance\Assert::areIdentical(
      \PM\Service::instance(), \PM\Service::instance());
  }

  public function register_adaper_rejects_invalid_adapters()
  {
    $adapter = new stdClass();
    \Enhance\Assert::throws('PM\Service', 
      'register_adapter', array($adapter));
  }

  public function register_adapter_accepts_valid_adapters()
  {
    $adapter = new \PM\Adapter\TestAdapter();
    \PM\Service::register_adapter($adapter);
    \Enhance\Assert::areIdentical($adapter, \PM\Service::adapter());
  }

  public function register_adapter_overwrites_any_previously_registered_adapter()
  {
    $a1 = new \PM\Adapter\TestAdapter();
    \PM\Service::register_adapter($a1);
    \Enhance\Assert::areIdentical($a1, \PM\Service::adapter());
    $a2 = new \PM\Adapter\TestAdapter();
    \PM\Service::register_adapter($a2);
    \Enhance\Assert::areNotIdentical($a1, \PM\Service::adapter());
    \Enhance\Assert::areIdentical($a2, \PM\Service::adapter());
  }
}
