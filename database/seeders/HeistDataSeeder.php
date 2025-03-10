<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HeistDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nejprve smažeme všechny existující příspěvky
        DB::table('posts')->truncate();

        // Definujeme uživatele, které chceme vytvořit
        $users = [
            [
                'email' => 'locksmith@heistmail.com',
                'name' => 'Burnout',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'mastermind@heistmail.com',
                'name' => 'ShadowFox',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'flyhigh@heistmail.com',
                'name' => 'SilentHawk',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'hacker@heistmail.com',
                'name' => 'Glitch',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'muscle@heistmail.com',
                'name' => 'Tank',
                'password' => Hash::make('12345678'),
            ],
        ];

        // Vytvoříme nebo aktualizujeme uživatele
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Definujeme příspěvky
        $posts = [
            [
                'email' => 'mastermind@heistmail.com',
                'nickname' => 'ShadowFox',
                'post' => 'Takže... někdo mi vysvětlí, proč máme růžové rukavice?!',
                'cas' => '2025-03-07 05:11:26',
            ],
            [
                'email' => 'muscle@heistmail.com',
                'nickname' => 'Tank',
                'post' => 'Protože byly nejlevnější. Neříkal jsi, že máme šetřit na vybavení?',
                'cas' => '2025-03-07 06:03:15',
            ],
            [
                'email' => 'hacker@heistmail.com',
                'nickname' => 'Glitch',
                'post' => 'Jo, ale ne na věcech, co nás mají chránit před vězením!',
                'cas' => '2025-03-07 08:28:33',
            ],
            [
                'email' => 'flyhigh@heistmail.com',
                'nickname' => 'SilentHawk',
                'post' => 'Představte si ty novinové titulky... \'Lupiče století prozradily růžové rukavice\'.',
                'cas' => '2025-03-07 10:00:05',
            ],
            [
                'email' => 'locksmith@heistmail.com',
                'nickname' => 'Burnout',
                'post' => 'Hele, když už řešíme oblečení, jaké budeme mít masky? Doufám, že žádné klauny.',
                'cas' => '2025-03-07 12:59:59',
            ],
            [
                'email' => 'mastermind@heistmail.com',
                'nickname' => 'ShadowFox',
                'post' => 'Navrhuju jednorožce nebo pandy.',
                'cas' => '2025-03-07 14:47:35',
            ],
            [
                'email' => 'muscle@heistmail.com',
                'nickname' => 'Tank',
                'post' => 'Takže půjdeme na banku v kostýmech plyšáků? Originální, to se musí nechat.',
                'cas' => '2025-03-07 17:13:22',
            ],
            [
                'email' => 'hacker@heistmail.com',
                'nickname' => 'Glitch',
                'post' => 'Ok, přestaňte řešit blbosti, máme problém. Bezpečnostní systém se restartuje každé 3 minuty.',
                'cas' => '2025-03-07 19:18:17',
            ],
            [
                'email' => 'muscle@heistmail.com',
                'nickname' => 'Tank',
                'post' => 'Super! To máme tři minuty na otevření sejfu?',
                'cas' => '2025-03-07 22:01:47',
            ],
            [
                'email' => 'locksmith@heistmail.com',
                'nickname' => 'Burnout',
                'post' => 'Počkej... kdo vlastně otevírá sejf? Doufám, že ne Tank hlavou.',
                'cas' => '2025-03-08 01:55:28',
            ],
            [
                'email' => 'muscle@heistmail.com',
                'nickname' => 'Tank',
                'post' => 'Hele, to bylo JEDNOU. A ty dveře byly tenké!',
                'cas' => '2025-03-08 02:31:07',
            ],
            [
                'email' => 'mastermind@heistmail.com',
                'nickname' => 'ShadowFox',
                'post' => 'Klid. Máme vybavení. A pokud ne, improvizace je klíčem ke každé loupeži.',
                'cas' => '2025-03-08 03:03:55',
            ],
            [
                'email' => 'hacker@heistmail.com',
                'nickname' => 'Glitch',
                'post' => 'No, pokud bude potřeba, můžu hacknout hlavní systém a otevřít ho elektronicky.',
                'cas' => '2025-03-08 07:41:00',
            ],
            [
                'email' => 'flyhigh@heistmail.com',
                'nickname' => 'SilentHawk',
                'post' => 'A co plán B? Co když Glitch zase omylem vypne pouliční osvětlení místo alarmu?',
                'cas' => '2025-03-08 09:46:13',
            ],
            [
                'email' => 'locksmith@heistmail.com',
                'nickname' => 'Burnout',
                'post' => 'Jo, nebo nám otevře trezor a zároveň pošle nouzový signál na policii. Stalo se to už dvakrát!',
                'cas' => '2025-03-08 11:14:49',
            ],
        ];

        // Vytvoříme příspěvky
        foreach ($posts as $postData) {
            $user = User::where('email', $postData['email'])->first();
            
            if ($user) {
                Post::create([
                    'user_id' => $user->id,
                    'content' => $postData['post'],
                    'title' => $postData['nickname'],
                    'created_at' => $postData['cas'],
                    'updated_at' => $postData['cas'],
                ]);
            }
        }
    }
}
