<?php


use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should block request if email is not jeremias@pinguim.academy', function () {
    $jeremias = User::factory()->create(['email' => 'jeremias@pinguim.academy']);
    $otherUser = User::factory()->create();

    actingAs($otherUser);

    get(route('secure-route'))->assertForbidden();

    actingAs($jeremias);

    get(route('secure-route'))->assertOk();
});
