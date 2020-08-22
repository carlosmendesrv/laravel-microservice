<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testList()
    {
        Category::create(['name' => 'Test']);

        $categories = Category::all();
        self::assertCount(1, $categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKey
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'Test',
            'description' => null
        ]);
        $category->refresh();

        $this->assertEquals('Test', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);
    }

    public function testUpdate()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false
        ]);

        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description',
            'is_active' => true
        ];

        $category->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDeleted()
    {
        $category = factory(Category::class)->create();
        $category->delete();
        $categoriesCount = Category::count();

        $this->assertEquals(0, $categoriesCount);
    }

    public function testUuid()
    {
        factory(Category::class)->create();
        $category = Category::first();
        $this->assertEquals(36,strlen($category->id));
        $this->assertStringContainsString('-',$category->id);
    }
}
