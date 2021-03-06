--TEST--
cairo_transform() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = cairo_image_surface_create(CAIRO_FORMAT_ARGB32, 50, 50);
var_dump($surface);

$context = cairo_create($surface);
var_dump($context);

$matrix = cairo_matrix_init(1, 0, 0, 1);
var_dump($matrix);

cairo_transform($context, $matrix);

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept 2
cairo_transform();
cairo_transform($context);
cairo_transform($context, $matrix, 1);

// check arg types, should be context object, matrix object
cairo_transform(1, $matrix);
cairo_transform($context, 1);
?>
--EXPECTF--
object(CairoImageSurface)#%d (0) {
}
object(CairoContext)#%d (0) {
}
object(CairoMatrix)#%d (0) {
}

Warning: cairo_transform() expects exactly 2 parameters, 0 given in %s on line %d

Warning: cairo_transform() expects exactly 2 parameters, 1 given in %s on line %d

Warning: cairo_transform() expects exactly 2 parameters, 3 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_transform() must be an instance of CairoContext, integer given

Warning: cairo_transform() expects parameter 1 to be CairoContext, integer given in %s on line %d
CAUGHT ERROR: Argument 2 passed to cairo_transform() must be an instance of CairoMatrix, integer given

Warning: cairo_transform() expects parameter 2 to be CairoMatrix, integer given in %s on line %d