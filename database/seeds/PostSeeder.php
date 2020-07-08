<?php

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
        DB::table('posts')->insert([
            'title' => 'This is testing post 1',
            'content' => '<p>Hi, this is my first testing post!</p>
            <p><img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/lqNTPcNq44URzgJskKHcDuZE62FqbWzbljTSyTmf.jpeg" alt="" width="1536" height="2048" /></p>
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
            'user_id' => 1,
            'post_type_id' => 1,
            'created_at' => '2020-07-08 12:23:43'
        ]);

        DB::table('posts')->insert([
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
            'user_id' => 2,
            'post_type_id' => 2,
            'created_at' => '2020-07-08 14:41:26'
        ]);

        DB::table('posts')->insert([
            'title' => 'Testing normal image size here!',
            'content' => '<p><img src="https://storage.googleapis.com/tutorspace-storage/user-profile-photos/4IZ41ITmkNX5Sf1kaEJsIGmYh5YwFHQEaNQQ1rP0.png" alt="" width="150" height="200" /> THis is to test a small image!</p>
            <p>dgsgdskgdsl</p>
            <p>Some code here:</p>
            <pre class="language-python"><code>str = "Hello, World!"
            print(str)</code></pre>',
            'slug' => 'testing-normal-image-size-here',
            'user_id' => 1,
            'post_type_id' => 1,
            'created_at' => '2020-07-08 14:55:30'
        ]);
    }
}
