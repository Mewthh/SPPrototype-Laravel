<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title
 * @property string $introduction
 * @property string $council_heading
 * @property array<int, array{name: string, institution: string, role: string}> $officers
 * @property array<int, array{name: string, institution: string}> $councilors
 * @property string $address
 * @property string $email
 * @property string|null $image
 * @property-read string|null $image_url
 */
#[Fillable(['title', 'introduction', 'council_heading', 'officers', 'councilors', 'address', 'email', 'image'])]
class AboutPage extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = ['image_url'];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'officers' => 'array',
            'councilors' => 'array',
        ];
    }

    /**
     * Get the public URL for the page image.
     *
     * @return Attribute<string|null, void>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image === null || $this->image === '') {
                    return null;
                }

                if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                    return $this->image;
                }

                $disk = config('filesystems.default', 'public');
                $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';

                return Storage::disk($diskName)->url($this->image);
            },
        );
    }

    /**
     * Provide the official details shown until an administrator updates them.
     *
     * @return array<string, mixed>
     */
    public static function defaultAttributes(): array
    {
        return [
            'title' => 'About SPP',
            'introduction' => 'The Samahang Pisika ng Pilipinas (SPP) is a professional organization of physicists and physics educators in the Philippines. SPP was established in 1979 with the aim of promoting research and setting a collegial venue where researchers in various fields of physics can find opportunities for creative scientific work and a productive exchange of ideas.',
            'council_heading' => 'National Council 2026',
            'officers' => [
                ['name' => 'Darwin Putungan, Ph.D.', 'institution' => 'Institute of Physics, University of the Philippines Los Baños', 'role' => 'President'],
                ['name' => 'Ranzivelle Marianne Roxas-Villanueva, Ph.D.', 'institution' => 'Institute of Physics, University of the Philippines Los Baños', 'role' => 'First Vice President'],
                ['name' => 'Carlos Baldo III, Ph.D.', 'institution' => 'Department of Physics, Mapúa University', 'role' => 'Second Vice President'],
                ['name' => 'Chrysline Margus Piñol, Ph.D.', 'institution' => 'Institute of Physics, University of the Philippines Los Baños', 'role' => 'Secretary General'],
                ['name' => 'Phoebe Nicole Perez, Ph.D.', 'institution' => 'Philippine Council for Health Research and Development, Department of Science and Technology', 'role' => 'Treasurer'],
            ],
            'councilors' => [
                ['name' => 'Roel Baybayon', 'institution' => 'University of the Philippines Diliman'],
                ['name' => 'John Paul Besagas, Ph.D.', 'institution' => 'Polytechnic University of the Philippines'],
                ['name' => 'Jayson Cosme, Ph.D.', 'institution' => 'University of the Philippines Diliman'],
                ['name' => 'Jessa Jayne Miranda, Ph.D.', 'institution' => 'University of the Philippines Diliman'],
                ['name' => 'Dean Alvin Pablico, Ph.D.', 'institution' => 'University of Northern Philippines'],
                ['name' => 'Leo Mendel Rosario, Ph.D.', 'institution' => 'University of the Philippines Open University'],
                ['name' => 'Michelle Marie Villamayor, Ph.D.', 'institution' => 'Central Mindanao University'],
                ['name' => 'Myles Allen Zosa, Ph.D.', 'institution' => 'University of the Philippines Diliman'],
            ],
            'address' => '3/F National Institute of Physics Building, University of the Philippines Diliman, Quezon City 1101, Philippines',
            'email' => 'hq@spp-online.org',
        ];
    }
}
