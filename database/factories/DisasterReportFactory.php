<?php

namespace Database\Factories;

use App\Models\DisasterReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisasterReport>
 */
class DisasterReportFactory extends Factory
{
    protected $model = DisasterReport::class;

    public function definition(): array
    {
        $types = ['Gempa Bumi', 'Banjir', 'Tanah Longsor', 'Gunung Meletus', 'Tsunami', 'Kebakaran Hutan', 'Puting Beliung', 'Kekeringan'];
        $statuses = ['Terpantau', 'Tanggap Darurat', 'Selesai'];

        return [
            'title' => $this->faker->sentence(4),
            'type' => $this->faker->randomElement($types),
            'location' => $this->faker->city() . ', Indonesia',
            'occurred_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'severity' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement($statuses),
            'description' => $this->faker->paragraph(2),
            'casualties' => $this->faker->optional()->numberBetween(0, 200),
            'latitude' => $this->faker->optional()->latitude(-10, 6),
            'longitude' => $this->faker->optional()->longitude(95, 141),
            'source_url' => $this->faker->optional()->url(),
        ];
    }
}
