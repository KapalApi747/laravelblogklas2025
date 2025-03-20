<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// beforeEach(function () {
//    // Een testgebruiker aanmaken
//    $this->user = User::factory()->create();
//    $this->actingAs($this->user);
// });

it('kan een categorie aanmaken', function () {
    $data = ['name' => 'Test Category'];

    $response = $this->post(route('categories.store'), $data);

    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', $data);
});

it('kan een categorie updaten', function () {
    $category = Category::factory()->create();

    $data = ['name' => 'Updated Category'];

    $response = $this->put(route('categories.update', $category), $data);

    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', $data);
});

it('kan een categorie soft deleten', function () {
    $category = Category::factory()->create();

    $response = $this->delete(route('categories.destroy', $category));

    $response->assertRedirect();
    $this->assertSoftDeleted('categories', ['id' => $category->id]);
});
