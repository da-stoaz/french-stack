<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Initial Assessment',
                'description' => 'Comprehensive first consultation with movement screening and a tailored treatment plan.',
                'duration_minutes' => 60,
                'price' => 95.00,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sports Massage',
                'description' => 'Deep tissue and recovery-focused massage for athletic performance and injury prevention.',
                'duration_minutes' => 45,
                'price' => 80.00,
                'sort_order' => 2,
            ],
            [
                'name' => 'Manual Therapy',
                'description' => 'Hands-on mobilisation techniques to restore range of motion and reduce pain.',
                'duration_minutes' => 45,
                'price' => 85.00,
                'sort_order' => 3,
            ],
            [
                'name' => 'Dry Needling',
                'description' => 'Targeted trigger-point therapy to release muscle tension and improve function.',
                'duration_minutes' => 30,
                'price' => 70.00,
                'sort_order' => 4,
            ],
            [
                'name' => 'Posture Analysis',
                'description' => 'Detailed postural and ergonomic assessment with practical correction guidance.',
                'duration_minutes' => 40,
                'price' => 75.00,
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->create([
                ...$service,
                'is_active' => true,
            ]);
        }

        $slotTimes = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        for ($i = 0; $i < 30; $i++) {
            $date = CarbonImmutable::today()->addDays($i);

            if ($date->isWeekend()) {
                continue;
            }

            foreach ($slotTimes as $startsAt) {
                $start = CarbonImmutable::parse($date->format('Y-m-d').' '.$startsAt);

                TimeSlot::query()->create([
                    'date' => $date->format('Y-m-d'),
                    'starts_at' => $start->format('H:i:s'),
                    'ends_at' => $start->addHour()->format('H:i:s'),
                    'is_available' => true,
                ]);
            }
        }

        $testimonials = [
            ['author_name' => 'Sophie K.', 'body' => 'After three sessions my shoulder pain finally eased and I can train again.', 'rating' => 5, 'sort_order' => 1],
            ['author_name' => 'Markus L.', 'body' => 'Clear explanations, precise treatment, and a very calming atmosphere.', 'rating' => 5, 'sort_order' => 2],
            ['author_name' => 'Julia W.', 'body' => 'The posture plan changed my workday comfort in less than two weeks.', 'rating' => 5, 'sort_order' => 3],
            ['author_name' => 'Thomas R.', 'body' => 'Professional and friendly from booking to treatment follow-up.', 'rating' => 4, 'sort_order' => 4],
            ['author_name' => 'Nina B.', 'body' => 'I appreciated the practical exercises I could use at home immediately.', 'rating' => 5, 'sort_order' => 5],
            ['author_name' => 'Daniel M.', 'body' => 'Sports massage sessions helped me recover faster between races.', 'rating' => 5, 'sort_order' => 6],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::query()->create([
                ...$testimonial,
                'is_visible' => true,
            ]);
        }

        $adminEmail = 'admin@'.Str::after((string) config('brand.email'), '@');

        User::query()->updateOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => config('brand.name').' Admin',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
