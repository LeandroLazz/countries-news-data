<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{
    Country,
    Category
};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test adding a category to a country
     *
     * @return void
     */
    public function test_country_not_found()
    {
        $response = $this->post('api/countries/XX/categories/food');

        $response->assertJson(['error' => 'Country not found']);
        $response->assertStatus(404);
    }

}
