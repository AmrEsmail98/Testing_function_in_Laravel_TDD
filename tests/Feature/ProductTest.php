<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\Void_;
use Tests\TestCase;

class ProductTest extends TestCase
{
    Use RefreshDatabase;

    protected $product;

    protected function setUp():Void
    {
        parent::setUp();
        //to insert product

        $this->product=Product::create([
            'name'=>'car',
            'price'=>200
        ]);
    }

    public function test_user_can_insert_product()
    {


        //handel error
        $this->withoutExceptionHandling();
        $response = $this->get('/products');


        $response->assertStatus(200)
        ->assertSee('car');

    }

    public function test_user_see_product_details(){
        $response= $this->get('/products/' . $this->product->id);
        $response->assertStatus(200)
        ->assertSee('car')
        ->assertSee('200');
    }


    public function test_product_brlongs_to_category()
    {
        
        $product=Product::all();
        $category=Category::all();
        $this->assertDatabaseMissing('products',[
            'id'=>$product->id,
            'category_id'=>$category->id,
        ]);
        $product->category()->associate($category)->save();
        $this->assertDatabaseHas('products',[
            'id'=>$product->id,
            'category_id'=>$category->id,
        ]);
    }

}
