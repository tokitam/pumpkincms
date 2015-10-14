<?php

require_once 'Parsedown.php';

$Parsedown = new Parsedown();

$text = <<< EOM

# test a
hoge
hoge

hoge

hoge

 hoge
 hoge

  hoge
  hoge

## test b

a
b
 dd
 dd

### test c

test
test
test

 test
 test

  test
  test

- test1
- test2
- test3
----
test4
----
```
class Foo {
    public function Foo()
    {
    }
}
```

EOM;

echo $Parsedown->text($text); 



