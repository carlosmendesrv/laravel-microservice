<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class)->create();

        $genres = Genre::all();
        self::assertCount(1, $genres);
        $genresKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genresKey
        );
    }

    public function testCreate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'Test',
        ]);
        $genre->refresh();

        $this->assertEquals('Test', $genre->name);
        $this->assertTrue((bool)$genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create(
            [
                'name' => 'Test Create',
                'is_active' => false
            ]);

        $data = [
            'name' => 'Test',
            'is_active' => true
        ];

        $genre->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDeleted()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $genreCount = Genre::count();

        $this->assertEquals(0, $genreCount);
    }

    public function testUuid()
    {
        factory(Genre::class)->create();
        $genre = Genre::first();
        $this->assertEquals(36,strlen($genre->id));
        $this->assertStringContainsString('-',$genre->id);
    }
}
