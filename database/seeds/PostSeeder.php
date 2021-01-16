<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;
        $postIds = DatabaseSeeder::$postIds;

        Post::create([
            'id' => $postIds[0],
            'title' => 'This is testing post 1',
            'content' => '<p>Hi, this is my first testing post!</p>
            <p>I would like to see what it looks like if it contains several large images!</p>
            <p><img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/JEE1cuwi5pQYBEgiAVhS0pjl8hx9zFn5QX7IKcS9.jpeg" alt="" width="4256" height="2832" /></p>
            <p>&nbsp;</p>
            <p>testing my table here!</p>
            <table style="border-collapse: collapse; width: 103.455%; height: 168px;" border="1">
            <tbody>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">gdgs</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">gsdgs</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">dgdsgsdg</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">sdgdsg</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            <td style="width: 14.2857%; height: 21px;">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <p>dgdgsdsg</p>
            <p>2020-07-08</p>
            <hr />
            <p>testing emoji!&nbsp;</p>
            <p>😙🤠</p>
            <p>testing link!</p>
            <p><a title="this is testing link title!" href="https://www.lipsum.com/">this is a testing link!</a></p>',
            'slug' => 'this-is-testing-post-1',
            'thumbNail' => 'https://storage.googleapis.com/tutorspace-storage/user-profile-photos/JEE1cuwi5pQYBEgiAVhS0pjl8hx9zFn5QX7IKcS9.jpeg',
            'user_id' => $userIds[0],
            'post_type_id' => 1,
            'view_count' => 36,
            'created_at' => '2020-12-08 12:23:43'
        ]);

        Post::create([
            'id' => $postIds[1],
            'title' => 'This is another testing Note!',
            'content' => '<p><em><strong>I want to try some other styles and colors in this post!</strong></em></p>
            <p><span style="background-color: #ba372a;">fdgsgsdgdg</span></p>
            <h1><span style="background-color: #ba372a;">sfsgdgsdghldskghklsd</span></h1>
            <p style="text-align: right;"><span style="color: #169179;">dgdgsdgdsgdsgds</span></p>
            <pre class="language-php"><code>$test = "Hello, World!";
            echo $test;</code></pre>
            <ol>
            <li>dgdgdsgdsgds</li>
            <li>gdsgds</li>
            <li>dsgdsgdsg</li>
            <li>dsg</li>
            </ol>
            <ul>
            <li>dgsdgdsg</li>
            <li><span style="color: #f1c40f;">dsg</span></li>
            <li><span style="color: #f1c40f;">dsgdg</span></li>
            <li><span style="color: #f1c40f;">dsgdg</span></li>
            </ul>',
            'slug' => 'this-is-another-testing-note',
            'user_id' => $userIds[1],
            'post_type_id' => 2,
            'view_count' => 12,
            'created_at' => '2020-11-05 14:41:26'
        ]);

        Post::create([
            'id' => $postIds[2],
            'title' => 'Testing normal image size here!',
            'content' => '<p><img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png" alt="" width="150" height="200" /> THis is to test a small image!</p>
            <p>dgsgdskgdsl</p>
            <p>Some code here:</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'testing-normal-image-size-here',
            'thumbNail' => 'https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png',
            'user_id' => $userIds[2],
            'post_type_id' => 1,
            'view_count' => 48,
            'created_at' => '2020-12-08 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[3],
            'title' => 'random post 1',
            'content' => '<p>THis is to some random post!</p>
            <p>dgsgdskgdsl</p>
            <p>Some code here:</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-1',
            'user_id' => $userIds[3],
            'post_type_id' => 3,
            'view_count' => 48,
            'created_at' => '2020-12-09 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[4],
            'title' => 'random post 2',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-2',
            'user_id' => $userIds[4],
            'post_type_id' => 1,
            'view_count' => 4,
            'created_at' => '2020-12-11 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[5],
            'title' => 'random post 3',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-3',
            'user_id' => $userIds[5],
            'post_type_id' => 2,
            'view_count' => 40,
            'created_at' => '2020-11-13 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[6],
            'title' => 'random post 4',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-4',
            'user_id' => $userIds[6],
            'post_type_id' => 3,
            'view_count' => 10,
            'created_at' => '2020-12-14 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[7],
            'title' => 'random post 5',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-5',
            'user_id' => $userIds[7],
            'post_type_id' => 1,
            'view_count' => 10,
            'created_at' => '2020-12-15 14:55:30'
        ]);

        Post::create([
            'id' => $postIds[8],
            'title' => 'random post 7',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-7',
            'user_id' => $userIds[8],
            'post_type_id' => 2,
            'view_count' => 10,
            'created_at' => '2020-11-15 16:55:30'
        ]);

        Post::create([
            'id' => $postIds[9],
            'title' => 'random post 8',
            'content' => '<p>THis is to some random post!</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'random-post-8',
            'user_id' => $userIds[9],
            'post_type_id' => 3,
            'view_count' => 10,
            'created_at' => '2020-12-16 16:55:30'
        ]);


        $postTags = [
            [
                'post_id' => $postIds[0],
                'tag_id' => 2
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 20
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 200
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 250
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 360
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 780
            ],[
                'post_id' => $postIds[1],
                'tag_id' => 1700
            ],[
                'post_id' => $postIds[2],
                'tag_id' => 1600
            ],[
                'post_id' => $postIds[3],
                'tag_id' => 15
            ],[
                'post_id' => $postIds[4],
                'tag_id' => 14
            ],[
                'post_id' => $postIds[5],
                'tag_id' => 23
            ],[
                'post_id' => $postIds[6],
                'tag_id' => 28
            ],[
                'post_id' => $postIds[7],
                'tag_id' => 29
            ],[
                'post_id' => $postIds[8],
                'tag_id' => 31
            ],[
                'post_id' => $postIds[9],
                'tag_id' => 32
            ],[
                'post_id' => $postIds[0],
                'tag_id' => 34
            ],[
                'post_id' => $postIds[1],
                'tag_id' => 24
            ],[
                'post_id' => $postIds[3],
                'tag_id' => 45
            ],[
                'post_id' => $postIds[4],
                'tag_id' => 112
            ],[
                'post_id' => $postIds[2],
                'tag_id' => 190
            ],[
                'post_id' => $postIds[5],
                'tag_id' => 29
            ],[
                'post_id' => $postIds[6],
                'tag_id' => 5
            ]
        ];
        DB::table('post_tag')->insert($postTags);


    }
}
