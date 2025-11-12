<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['name'=>'Amit Singhal', 'email'=>'amit@example.com', 'phone'=>'9876543210', 'membership_number' => 'MEM001', 'status' => 'active', 'joined_date' => '2024-01-15'],
            ['name' => 'Neha Gupta', 'email' => 'neha@example.com', 'phone' => '9876543211', 'membership_number' => 'MEM002', 'status' => 'suspended', 'joined_date' => '2024-02-10'],
            ['name' => 'Rahul Mehta', 'email' => 'rahul@example.com', 'phone' => '9876543212', 'membership_number' => 'MEM003', 'status' => 'active', 'joined_date' => '2024-03-05'],
            ['name' => 'Sneha Kapoor', 'email' => 'sneha@example.com', 'phone' => '9876543213', 'membership_number' => 'MEM004', 'status' => 'active', 'joined_date' => '2024-04-22'],
            ['name' => 'Vikas Verma', 'email' => 'vikas@example.com', 'phone' => '9876543214', 'membership_number' => 'MEM005', 'status' => 'suspended', 'joined_date' => '2024-05-18'],
            ['name' => 'Ritu Jain', 'email' => 'ritu@example.com', 'phone' => '9876543215', 'membership_number' => 'MEM006', 'status' => 'active', 'joined_date' => '2024-06-03'],
            ['name' => 'Manish Singh', 'email' => 'manish@example.com', 'phone' => '9876543216', 'membership_number' => 'MEM007', 'status' => 'active', 'joined_date' => '2024-07-11'],
            ['name' => 'Priya Das', 'email' => 'priya@example.com', 'phone' => '9876543217', 'membership_number' => 'MEM008', 'status' => 'suspended', 'joined_date' => '2024-08-08'],
            ['name' => 'Kunal Tiwari', 'email' => 'kunal@example.com', 'phone' => '9876543218', 'membership_number' => 'MEM009', 'status' => 'active', 'joined_date' => '2024-09-01'],
            ['name' => 'Anjali Yadav', 'email' => 'anjali@example.com', 'phone' => '9876543219', 'membership_number' => 'MEM010', 'status' => 'active', 'joined_date' => '2024-09-15'],
        ];

        foreach($members as $member) {
            Member::create($member);
        }
    }
}
