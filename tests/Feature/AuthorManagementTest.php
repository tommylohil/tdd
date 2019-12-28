<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors', $this->data());

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2019-12-15', $author->first()->dob->format('Y-m-d'));

    }

    /** @test */
    public function a_name_is_required()
    {
        $res = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $res->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_dob_is_required()
    {
        $res = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $res->assertSessionHasErrors('dob');
    }

    public function data()
    {
        return [
            'name' => 'Author Name',
            'dob' => '15-12-2019',
        ];
    }
}
