<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $res = $this->post('/books', [
            'title' => 'Rich dad',
            'author' => 'Tommy'
        ]);

        $res->assertOk();
        
        $this->assertCount(1, Book::all());

    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $res = $this->post('/books', [
            'title' => '',
            'author' => 'Tommy'
        ]);
 
        $res->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_author_is_required()
    {
        // $this->withoutExceptionHandling();

        $res = $this->post('/books', [
            'title' => 'New Title',
            'author' => ''
        ]);
 
        $res->assertSessionHasErrors('author');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Silicon Valley',
            'author' => 'Tommy'
        ]);

        $book = Book::first();

        $res = $this->patch('/books/'. $book->id, [
            'title' => 'Chemical things',
            'author' => 'Fernando'
        ]);
 
        $this->assertEquals('Chemical things', Book::first()->title);
        $this->assertEquals('Fernando', Book::first()->author);
    }
}
