<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class FeatureTodoTest extends TestCase
{
    public function testStoreDataActivity()
    {
        // 1. cek url yang diakses
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Enter an activity');
        
        // 2. user mengirim data ke server
        $data = [
            'name' => 'Testing',
        ];
        $storedata = $this->post(route('item.store'), $data);
        $storedata = $this->post(route('item.store'), $data);

        // 3. apakah data berhasil ditambahkan ke database
        $storedata->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('tasks', [
            'name' => 'Testing',
        ]);

        // 4. Redirect ke dashboard
        $storedata->assertRedirect(route('dashboard'));
    }

    public function testDeleteDataActivity()
    {
        // 1. cek url yang diakses
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Enter an activity');

        // 2. user mengirim data ke server
        $storedata = $this->delete(route('item.destroy', ['id' => 3]));

        // 3. Apakah data berhasil dihapus dari database
        $storedata->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseMissing('tasks', [
            'id' => 3,
        ]);

        // 4. Redirect ke dashboard
        $storedata->assertRedirect(route('dashboard'));
    }
}
