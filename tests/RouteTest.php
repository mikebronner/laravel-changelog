<?php

test('changelog index route exists', function () {
    $response = $this->get('/changelog');

    // Should not be 404 — the route exists even if the layout doesn't
    expect($response->getStatusCode())->not->toBe(404);
});

test('changelog minor version route exists', function () {
    $response = $this->get('/changelog/1.0');

    expect($response->getStatusCode())->not->toBe(404);
});

test('changelog minor version route rejects non-numeric segments', function () {
    $response = $this->get('/changelog/abc.def');

    expect($response->getStatusCode())->toBe(404);
});
