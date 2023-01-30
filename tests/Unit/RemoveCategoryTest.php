<?php

namespace Tests\Unit;

use Tests\TestCase;

class RemoveCategoryTest extends TestCase
{
    /**
     * Test country not found
     *
     * @return void
     */
    public function test_country_not_found()
    {
        $response = $this->delete('api/countries/XX/categories/food');

        $response->assertJson(['error' => 'Country not found']);
        $response->assertStatus(404);
    }

    /**
     * Test category not found
     *
     * @return void
     */
    public function test_category_not_found()
    {
        $response = $this->delete('api/countries/ca/categories/NonExistentCategory');

        $response->assertJson(['error' => 'Category not found']);
        $response->assertStatus(404);
    }

    /**
     * Test remove category from country success
     *
     * @return void
     */
    public function test_remove_category_from_country_success() {
        $response = $this->delete('api/countries/ca/categories/world');

        $response->assertJson(['message' => 'Category successfully removed from country']);
        $response->assertStatus(200);
    }

    /**
     * Test country does not have this category
     *
     * @return void
     */
    public function test_category_does_not_exist_in_country() {
        $response = $this->delete('api/countries/ca/categories/world');

        $response->assertJson(['error' => 'Country does not have this category']);
        $response->assertStatus(400);
    }

}
