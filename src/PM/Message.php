<?php

namespace PM;

class Message extends \PM\Base
{
  private $_recipients;

  private $_children = array();
  private $_parent;

  public $cached_thread;

  public $id;
  public $thread_parent_id;
  public $parent_id;

  public $inbox;
  public $subject;
  public $message;

  public function __construct($settings=array())
  {
    foreach($settings as $k => $v)
      $this->$k = $v;
  }

  public function load_all_children()
  {
    if ($this->cached_thread)
      return $this->cached_thread;
    return $this->cached_thread = 
      $this->adapter()->get_all_children_of_message($this);
  }

  public function load_discussion_thread()
  {
    $by_id = array();
    foreach($this->load_all_children() as $child)
      $by_id[$child->id] = $child;
    $by_id[$this->id] = $this;
    foreach($this->load_all_children() as $child)
      if ($parent = $by_id[$child->parent_id])
        $child->link_as_child_of($parent); 
  }

  public function link_as_child_of($parent)
  {
    $parent->add_child($this);
    $this->set_parent($parent);
  }

  protected function add_child($child)
  {
    $this->_children[] = $child;
  }

  public function children()
  {
    return $this->_children;
  }

  protected function set_parent($parent)
  {
    $this->_parent = $parent;
  }

  public function parent()
  {
    return $this->_parent;
  }

  public function siblings()
  {
    $self = $this;
    $parents_children = ($parent = $this->parent())
      ? $parent->children() : array();
    return array_values(array_filter($parents_children,
      function($c) use($self) { return $self !== $c; }));
  }

  public function __toString()
  {
    return parent::__toString().": $this->id";
  }
}
