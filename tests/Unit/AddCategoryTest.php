<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{
    Country,
    Category
};

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

}
