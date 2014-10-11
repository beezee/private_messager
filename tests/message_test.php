<?php

class MessageTest extends \Enhance\TestFixture
{
  
  public function load_all_children_passes_self_to_adapter_and_memoizes()
  {
    $message = new \PM\Message();
    $messages = array('msg1', 'msg2');
    $adapter = \Enhance\MockFactory::createMock('\PM\Adapter\TestAdapter');
    $adapter->addExpectation(
      \Enhance\Expect::method('get_all_children_of_message')
        ->with($message)->returns($messages)->times(1));
    $message->set_adapter($adapter);
    \Enhance\Assert::areIdentical($messages, $message->load_all_children());
    \Enhance\Assert::areIdentical($messages, $message->load_all_children());
    $adapter->verifyExpectations();
  }

  public function load_discussion_thread_loads_children_and_builds_thread_tree()
  {
    $msg1 = new \PM\Message(array('id' => 1));
    $msg2 = new \PM\Message(array('id' => 2, 'parent_id' => 1));
    $msg3 = new \PM\Message(array('id' => 3, 'parent_id' => 2));
    $msg4 = new \PM\Message(array('id' => 4, 'parent_id' => 1));
    $adapter = \Enhance\MockFactory::createMock('\PM\Adapter\TestAdapter');
    $msg1->set_adapter($adapter);
    $adapter->addExpectation(
      \Enhance\Expect::method('get_all_children_of_message')
        ->with($msg1)->returns(array($msg2, $msg3, $msg4))->times(1));
    $msg1->load_discussion_thread();
    \Enhance\Assert::areIdentical(array($msg2, $msg4), $msg1->children());
    \Enhance\Assert::areIdentical($msg1, $msg2->parent());
    \Enhance\Assert::areIdentical($msg1, $msg4->parent());
    \Enhance\Assert::areIdentical(array($msg3), $msg2->children());
    \Enhance\Assert::areIdentical($msg2, $msg3->parent());
    $adapter->verifyExpectations();
  }

  public function link_as_child_to_creates_a_two_way_link_between_parent_and_child()
  {
    $msg1 = new \PM\Message();
    $msg2 = new \PM\Message();
    $msg3 = new \PM\Message();
    $msg2->link_as_child_of($msg1);
    \Enhance\Assert::areIdentical(array($msg2), $msg1->children());
    \Enhance\Assert::areIdentical($msg1, $msg2->parent());
    $msg3->link_as_child_of($msg1);
    \Enhance\Assert::areIdentical(array($msg2, $msg3), $msg1->children());
    \Enhance\Assert::areIdentical($msg1, $msg3->parent());
  }

  public function siblings_returns_all_children_of_parent_except_self()
  {
    $msg1 = new \PM\Message(array('id' => 1));
    $msg2 = new \PM\Message(array('id' => 2, 'parent_id' => 1));
    $msg3 = new \PM\Message(array('id' => 3, 'parent_id' => 1));
    $msg4 = new \PM\Message(array('id' => 4, 'parent_id' => 1));
    $adapter = \Enhance\MockFactory::createMock('\PM\Adapter\TestAdapter');
    $msg1->set_adapter($adapter);
    $adapter->addExpectation(
      \Enhance\Expect::method('get_all_children_of_message')
        ->with($msg1)->returns(array($msg2, $msg3, $msg4))->times(1));
    $msg1->load_discussion_thread();
    \Enhance\Assert::areIdentical(array($msg2, $msg3), $msg4->siblings());
    \Enhance\Assert::areIdentical(array($msg3, $msg4), $msg2->siblings());
    \Enhance\Assert::areIdentical(array($msg2, $msg4), $msg3->siblings());
    \Enhance\Assert::areIdentical(array(), $msg1->siblings());
  }
}
