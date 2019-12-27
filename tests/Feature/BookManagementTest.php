<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $res = $this->post('/books', [
            'title' => 'Rich dad',
            'author' => 'Tommy'
        ]);

        $book = Book::first();
        // $res->assertOk();
        
        $this->assertCount(1, Book::all());
        $res->assertRedirect($book->path());

    }

    /** @test */
    public function a_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $res = $this->post('/books', [
            'title' => '',
            'author' => 'Tommy'
        ]);
 
        $res->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        // $this->withoutExceptionHandling();

        $res = $this->post('/books', [
            'title' => 'New Title',
            'author' => ''
        ]);
 
        $res->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Silicon Valley',
            'author' => 'Tommy'
        ]);

        $book = Book::first();

        $res = $this->patch($book->path(), [
            'title' => 'Chemical things',
            'author' => 'Fernando'
        ]);
 
        $this->assertEquals('Chemical things', Book::first()->title);
        $this->assertEquals('Fernando', Book::first()->author);

        $res->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Silicon Valley',
            'author' => 'Tommy'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $res = $this->delete($book->path());
 
        $this->assertCount(0, Book::all());

        $res->assertRedirect('/books');
    }
}
