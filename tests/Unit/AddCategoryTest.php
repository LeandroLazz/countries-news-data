<?php

namespace Tests\Unit;

use Tests\TestCase;

class AddCategoryTest extends TestCase
{
    /**
     * Test country not found
     *
     * @return void
     */
    public function test_country_not_found()
    {
        $response = $this->post('api/countries/XX/categories/food');

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
        $response = $this->post('api/countries/ca/categories/NonExistentCategory');

        $response->assertJson(['error' => 'Category not found']);
        $response->assertStatus(404);
    }

    /**
     * Test add category to country success
     *
     * @return void
     */
    public function test_add_category_to_country_success() {
        $response = $this->post('api/countries/ca/categories/world');

        $response->assertJson(['message' => 'Category successfully added to country']);
        $response->assertStatus(201);
    }

    /**
     * Test category already exists in the country
     *
     * @return void
     */
    public function test_category_already_exists_in_country() {
        $response = $this->post('api/countries/ca/categories/world');

        $response->assertJson(['error' => 'Category already exists in the country']);
        $response->assertStatus(400);
    }

}
