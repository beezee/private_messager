<?php

class InboxTest extends \Enhance\TestFixture
{

  public function for_user_returns_instance_with_user_attached()
  {
    $user = new stdClass();
    $inbox = \PM\Inbox::for_user($user);
    \Enhance\Assert::areIdentical('PM\Inbox',
      get_class($inbox));
    \Enhance\Assert::areIdentical($user, $inbox->user());
  }

  public function get_messages_passes_self_and_default_options_to_adapter()
  {
    $inbox = \PM\Inbox::for_user(null);
    $messages = array('msg1', 'msg2');
    $adapter = \Enhance\MockFactory::createMock('\PM\Adapter\TestAdapter');
    $adapter->addExpectation(
      \Enhance\Expect::method('get_messages_for_inbox')
        ->with($inbox, array())->returns($messages)->times(1));
    $inbox->set_adapter($adapter);
    \Enhance\Assert::areIdentical($messages, $inbox->messages());
    $adapter->verifyExpectations();
  }

  public function get_messages_passes_self_and_provided_options_to_adapter()
  {
    $inbox = \PM\Inbox::for_user(null);
    $messages = array('msg1', 'msg2');
    $options = array('status' => 'unread');
    $adapter = \Enhance\MockFactory::createMock('\PM\Adapter\TestAdapter');
    $adapter->addExpectation(
      \Enhance\Expect::method('get_messages_for_inbox')
        ->with($inbox, $options)->returns($messages)->times(1));
    $inbox->set_adapter($adapter);
    \Enhance\Assert::areIdentical($messages, $inbox->messages($options));
    $adapter->verifyExpectations();
  }
}
