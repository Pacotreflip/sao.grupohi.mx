<?php

Breadcrumbs::register('index', function ($b) {
    $b->push('INICIO', route('index'));
});
