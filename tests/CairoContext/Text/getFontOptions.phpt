--TEST--
CairoContext->getFontOptions() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new CairoImageSurface(CairoFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new CairoContext($surface);
var_dump($context);

var_dump($orig_options = $context->getFontOptions());

$options = new CairoFontOptions();
var_dump($orig_options === $options);

$context->setFontOptions($options);
var_dump($options1 = $context->getFontOptions());
var_dump($options1 === $options);
var_dump($orig_options === $options1);

try {
    $context->getFontOptions('foo');
    trigger_error('getFontOptions requires no args');
} catch (CairoException $e) {
    echo $e->getMessage(), PHP_EOL;
}

die; // DO NOT REMOVE THIS - fixes issue in 5.3 with GC giving bogus memleak reports
?>
--EXPECTF--
object(CairoImageSurface)#%d (0) {
}
object(CairoContext)#%d (0) {
}
object(CairoFontOptions)#%d (0) {
}
bool(false)
object(CairoFontOptions)#%d (0) {
}
bool(true)
bool(false)
CairoContext::getFontOptions() expects exactly 0 parameters, 1 given