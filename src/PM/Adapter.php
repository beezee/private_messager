<?php

namespace PM;

abstract class Adapter
{
  public abstract function get_messages_for_inbox($inbox);
}
