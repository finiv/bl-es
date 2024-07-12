<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories =  [
            'Technology', 'Programming', 'Web Development', 'Mobile Development', 'Artificial Intelligence',
            'Machine Learning', 'Data Science', 'Cybersecurity', 'Blockchain', 'Cryptocurrency',
            'E-commerce', 'Education Technology', 'Software Development', 'Game Development', 'Cloud Computing',
            'DevOps', 'UI/UX Design', 'Digital Marketing', 'SEO', 'Content Marketing',
            'Social Media', 'Entrepreneurship', 'Startups', 'Business Strategy', 'Finance',
            'Investing', 'Personal Finance', 'Economics', 'Productivity', 'Project Management',
            'Leadership', 'Career Advice', 'Work-Life Balance', 'Remote Work', 'Health and Wellness',
            'Fitness', 'Nutrition', 'Mental Health', 'Travel', 'Lifestyle',
            'Fashion', 'Beauty', 'Photography', 'Art and Design', 'DIY',
            'Home Improvement', 'Gardening', 'Food and Cooking', 'Parenting', 'Relationships',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
