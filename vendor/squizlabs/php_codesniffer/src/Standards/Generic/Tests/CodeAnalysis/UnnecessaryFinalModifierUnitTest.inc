<?php

class Foo
{
    final public function fooBar()
    {
    }
    final protected function fool()
    {
    }
    final private function Bar()
    {
    }
}

final class Foo_Bar
{
    public $foobar;
    public final $FOOBAR = 23; // Parse error, but that's not the concern of this sniff, so report it.
    final public function fooBar()
    {
    }

    protected function foo()
    {
    }
    final protected function fool()
    {
    }

    private function Bar()
    {
    }
    final private function Bard()
    {
    }
}

final class Bar_Foo
{
    public $foobar;
    protected $foo;
    private $bar;

    public function fooBar()
    {
    }
    protected function foo()
    {
    }
    private function Bar()
    {
    }
}
