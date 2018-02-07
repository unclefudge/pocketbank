<?php

function fieldErrorMessage($field, $errors)
{
if ($errors->has($field))
return '<span class="text-danger">' . $errors->first($field) . '</span>';
}

function fieldHasError($field, $errors)
{
if ($errors->has($field))
return 'text-danger';
}
