<?php

namespace PM;

abstract class Adapter
{
  public abstract function get_messages_for_inbox($inbox);
  public abstract function get_all_children_of_message($inbox);
}
