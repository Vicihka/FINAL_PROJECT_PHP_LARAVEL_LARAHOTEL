<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $categoryDescriptions = [
            'Single Room' => 'Best for solo travelers and short business stays.',
            'Double Room' => 'Comfortable rooms for couples or two adults sharing one large bed.',
            'Twin Room'   => 'Great for friends or colleagues who prefer separate beds.',
            'Family Room' => 'Larger rooms designed for small families or group stays.',
            'Suite'       => 'Premium rooms with extra space and upgraded comfort.',
        ];

        $roomTypes = [
            [
                'name'            => 'Standard Single Room',
                'category'        => 'Single Room',
                'bed_type'        => '1 Single Bed',
                'description'     => 'A smart, comfortable single room designed for one guest with all the essentials for a relaxing city stay.',
                'price_per_night' => 95.00,
                'max_guests'      => 1,
                'size_sqft'       => 220,
                'rating'          => 4.6,
                'image_url'       => 'images/room-standard.png',
                'rooms' => [
                    ['number' => '101', 'floor' => 1],
                    ['number' => '102', 'floor' => 1],
                    ['number' => '103', 'floor' => 1],
                    ['number' => '104', 'floor' => 1],
                    ['number' => '201', 'floor' => 2],
                    ['number' => '202', 'floor' => 2],
                    ['number' => '203', 'floor' => 2],
                    ['number' => '204', 'floor' => 2],
                ],
            ],
            [
                'name'            => 'Deluxe Single Room',
                'category'        => 'Single Room',
                'bed_type'        => '1 Single Bed',
                'description'     => 'A quieter and more spacious single room with upgraded finishes, ideal for solo travelers who want extra comfort.',
                'price_per_night' => 120.00,
                'max_guests'      => 1,
                'size_sqft'       => 260,
                'rating'          => 4.7,
                'image_url'       => 'images/room-deluxe.png',
                'rooms' => [
                    ['number' => '205', 'floor' => 2],
                    ['number' => '206', 'floor' => 2],
                    ['number' => '305', 'floor' => 3],
                    ['number' => '306', 'floor' => 3],
                ],
            ],
            [
                'name'            => 'Standard Double Room',
                'category'        => 'Double Room',
                'bed_type'        => '1 Double Bed',
                'description'     => 'A practical double room for couples or two adults, with a warm design and the hotel\'s everyday essentials.',
                'price_per_night' => 150.00,
                'max_guests'      => 2,
                'size_sqft'       => 320,
                'rating'          => 4.6,
                'image_url'       => 'images/room-1777190039.png',
                'rooms' => [
                    ['number' => '105', 'floor' => 1],
                    ['number' => '106', 'floor' => 1],
                    ['number' => '107', 'floor' => 1],
                    ['number' => '207', 'floor' => 2],
                    ['number' => '208', 'floor' => 2],
                    ['number' => '209', 'floor' => 2],
                ],
            ],
            [
                'name'            => 'Deluxe Double Room',
                'category'        => 'Double Room',
                'bed_type'        => '1 Double Bed',
                'description'     => 'A more spacious double room with upgraded decor and better lounging space for comfortable shared stays.',
                'price_per_night' => 185.00,
                'max_guests'      => 2,
                'size_sqft'       => 380,
                'rating'          => 4.8,
                'image_url'       => 'images/room-1777190086.png',
                'rooms' => [
                    ['number' => '307', 'floor' => 3],
                    ['number' => '308', 'floor' => 3],
                    ['number' => '407', 'floor' => 4],
                    ['number' => '408', 'floor' => 4],
                ],
            ],
            [
                'name'            => 'Superior Twin Room',
                'category'        => 'Twin Room',
                'bed_type'        => '2 Twin Beds',
                'description'     => 'A clean and functional twin room with two separate beds, ideal for friends, siblings, or business partners.',
                'price_per_night' => 170.00,
                'max_guests'      => 2,
                'size_sqft'       => 340,
                'rating'          => 4.7,
                'image_url'       => 'images/room-1777190125.png',
                'rooms' => [
                    ['number' => '309', 'floor' => 3],
                    ['number' => '310', 'floor' => 3],
                    ['number' => '409', 'floor' => 4],
                    ['number' => '410', 'floor' => 4],
                ],
            ],
            [
                'name'            => 'Family Room',
                'category'        => 'Family Room',
                'bed_type'        => '1 Double Bed + 2 Single Beds',
                'description'     => 'A family-friendly room with extra sleeping space, ideal for parents traveling with children in one room.',
                'price_per_night' => 240.00,
                'max_guests'      => 4,
                'size_sqft'       => 520,
                'rating'          => 4.8,
                'image_url'       => 'images/room-family.png',
                'rooms' => [
                    ['number' => '501', 'floor' => 5],
                    ['number' => '502', 'floor' => 5],
                    ['number' => '503', 'floor' => 5],
                ],
            ],
            [
                'name'            => 'Junior Suite',
                'category'        => 'Suite',
                'bed_type'        => '1 King Bed',
                'description'     => 'A stylish junior suite with a larger layout, premium bedding, and a more elevated stay experience.',
                'price_per_night' => 295.00,
                'max_guests'      => 2,
                'size_sqft'       => 560,
                'rating'          => 4.9,
                'image_url'       => 'images/room-suite.png',
                'rooms' => [
                    ['number' => '601', 'floor' => 6],
                    ['number' => '602', 'floor' => 6],
                    ['number' => '603', 'floor' => 6],
                ],
            ],
            [
                'name'            => 'Executive Penthouse',
                'category'        => 'Suite',
                'bed_type'        => '1 King Bed',
                'description'     => 'The most exclusive suite in the hotel, with expansive views, a separate lounge space, and premium in-room service.',
                'price_per_night' => 520.00,
                'max_guests'      => 4,
                'size_sqft'       => 960,
                'rating'          => 5.0,
                'image_url'       => 'images/room-presidential.png',
                'rooms' => [
                    ['number' => '701', 'floor' => 7],
                    ['number' => '702', 'floor' => 7],
                ],
            ],
        ];

        foreach ($roomTypes as $data) {
            $category = RoomCategory::firstOrCreate(
                ['name' => $data['category']],
                ['description' => $categoryDescriptions[$data['category']] ?? $data['category']]
            );

            $roomData = collect($data)->except('rooms')->merge(['room_category_id' => $category->id])->toArray();
            $roomType = RoomType::create($roomData);

            foreach ($data['rooms'] as $room) {
                Room::create([
                    'room_type_id' => $roomType->id,
                    'room_number'  => $room['number'],
                    'floor'        => $room['floor'],
                    'status'       => 'available',
                ]);
            }
        }
    }
}
