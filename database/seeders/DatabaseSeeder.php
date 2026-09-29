<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'    => 'Admin',
            'email'   => 'admin@greennest.com',
            'password'=> Hash::make('Admin@123'),
            'role'    => 'admin',
            'phone'   => '9800000000',
            'address' => 'Kathmandu, Nepal',
        ]);

        // Demo customer
        User::create([
            'name'    => 'Pawan Pokharel',
            'email'   => 'pawan@example.com',
            'password'=> Hash::make('password'),
            'role'    => 'customer',
            'phone'   => '9806800001',
            'address' => 'Lalitpur, Nepal',
        ]);

        // Categories
        $categories = [
            ['name' => 'Air-Purifying',    'slug' => 'air-purifying',    'icon' => '🌬️'],
            ['name' => 'Succulent',         'slug' => 'succulent',         'icon' => '🌵'],
            ['name' => 'Large Foliage',     'slug' => 'large-foliage',     'icon' => '🌿'],
            ['name' => 'Flowering',         'slug' => 'flowering',         'icon' => '🌸'],
            ['name' => 'Trailing/Hanging',  'slug' => 'trailing-hanging',  'icon' => '🪴'],
            ['name' => 'Low Maintenance',   'slug' => 'low-maintenance',   'icon' => '🌱'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $airPurifying   = Category::where('slug', 'air-purifying')->first();
        $succulent      = Category::where('slug', 'succulent')->first();
        $largeFoliage   = Category::where('slug', 'large-foliage')->first();
        $flowering      = Category::where('slug', 'flowering')->first();
        $trailing       = Category::where('slug', 'trailing-hanging')->first();
        $lowMaintenance = Category::where('slug', 'low-maintenance')->first();

        // 30 products with high-quality images
        $products = [
            // Air Purifying
            ['name'=>'Money Plant (Golden Pothos)',  'category_id'=>$airPurifying->id,   'price'=>350,  'stock_quantity'=>40, 'description'=>'One of the most popular and easy-to-grow indoor plants. Thrives in low light and purifies the air.', 'is_featured'=>true,  'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=600&q=80'],
            ['name'=>'Snake Plant (Sansevieria)',     'category_id'=>$airPurifying->id,   'price'=>450,  'stock_quantity'=>35, 'description'=>'Nearly indestructible air-purifier. Perfect for bedrooms and offices.', 'is_featured'=>true,  'light'=>'Low to Bright', 'water'=>'Bi-weekly', 'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1572688484438-313a6e50c333?w=600&q=80'],
            ['name'=>'Spider Plant',                  'category_id'=>$airPurifying->id,   'price'=>300,  'stock_quantity'=>30, 'description'=>'Fast-growing air purifier with charming cascading leaves and baby plantlets.', 'is_featured'=>false, 'light'=>'Indirect',      'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1589999832541-d5e3e3a9e36e?w=600&q=80'],
            ['name'=>'Peace Lily',                    'category_id'=>$flowering->id,      'price'=>550,  'stock_quantity'=>20, 'description'=>'Elegant white blooms and deep-green leaves. Great for removing toxins from air.', 'is_featured'=>true,  'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=600&q=80'],
            // Succulent
            ['name'=>'Aloe Vera',                    'category_id'=>$succulent->id,      'price'=>250,  'stock_quantity'=>45, 'description'=>'A timeless succulent known for its soothing gel and minimal watering needs.', 'is_featured'=>false, 'light'=>'Bright',        'water'=>'Bi-weekly', 'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1596547609652-9cf5d8c10616?w=600&q=80'],
            ['name'=>'Jade Plant',                   'category_id'=>$succulent->id,      'price'=>300,  'stock_quantity'=>40, 'description'=>'Symbolizes good luck and prosperity. Thick, glossy green leaves and a tree-like form.', 'is_featured'=>false, 'light'=>'Bright',       'water'=>'Bi-weekly', 'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=600&q=80'],
            ['name'=>'Echeveria',                    'category_id'=>$succulent->id,      'price'=>250,  'stock_quantity'=>35, 'description'=>'A gorgeous rosette-shaped succulent in shades of green, pink, and purple.', 'is_featured'=>false, 'light'=>'Bright',        'water'=>'Bi-weekly', 'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1520302630591-fd1c66edc19d?w=600&q=80'],
            ['name'=>'Haworthia',                    'category_id'=>$succulent->id,      'price'=>250,  'stock_quantity'=>35, 'description'=>'A compact succulent that thrives in lower light than most succulents.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Bi-weekly', 'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1509587584298-0f3b3a3a1797?w=600&q=80'],
            ['name'=>'String of Pearls',             'category_id'=>$succulent->id,      'price'=>400,  'stock_quantity'=>20, 'description'=>'Trailing succulent with fascinating bead-like leaves. Perfect for hanging baskets.', 'is_featured'=>false, 'light'=>'Bright',       'water'=>'Bi-weekly', 'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1545239351-ef35f43d514b?w=600&q=80'],
            ['name'=>'Cactus Mix (Small, set of 3)', 'category_id'=>$succulent->id,      'price'=>450,  'stock_quantity'=>30, 'description'=>'A curated set of 3 small cacti — ideal for desks, windowsills, and gifting.', 'is_featured'=>false, 'light'=>'Bright',        'water'=>'Monthly',   'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1459183885421-5cc683b8dbba?w=600&q=80'],
            // Large Foliage
            ['name'=>'Areca Palm',                   'category_id'=>$largeFoliage->id,   'price'=>1200, 'stock_quantity'=>15, 'description'=>'Elegant tropical palm that adds height and a resort feel to your living room.', 'is_featured'=>true,  'light'=>'Bright Indirect','water'=>'Weekly',    'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80'],
            ['name'=>'Rubber Plant (Ficus Elastica)','category_id'=>$largeFoliage->id,   'price'=>800,  'stock_quantity'=>18, 'description'=>'Bold burgundy-green leaves on a striking upright form. A design statement.', 'is_featured'=>true,  'light'=>'Bright Indirect','water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=600&q=80'],
            ['name'=>'Fiddle Leaf Fig',              'category_id'=>$largeFoliage->id,   'price'=>1500, 'stock_quantity'=>10, 'description'=>'The most photographed plant in interior design. Large, dramatic violin-shaped leaves.', 'is_featured'=>true, 'light'=>'Bright Indirect','water'=>'Weekly',   'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1585314062604-1a357de8b000?w=600&q=80'],
            ['name'=>'Bamboo Palm',                  'category_id'=>$largeFoliage->id,   'price'=>900,  'stock_quantity'=>14, 'description'=>'Graceful multi-stemmed palm that thrives in lower light — great for corners.', 'is_featured'=>false, 'light'=>'Medium',         'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1509423350716-97f9360b4e09?w=600&q=80'],
            ['name'=>'Dracaena Marginata',           'category_id'=>$largeFoliage->id,   'price'=>850,  'stock_quantity'=>15, 'description'=>'Tall, architectural plant with slender red-edged leaves on a cane-like stem.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1484820540004-14229fe36ca4?w=600&q=80'],
            ['name'=>'Monstera Deliciosa',           'category_id'=>$largeFoliage->id,   'price'=>1400, 'stock_quantity'=>12, 'description'=>'The iconic Swiss cheese plant with dramatic split leaves. Instagram favorite.', 'is_featured'=>true,  'light'=>'Bright Indirect','water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=600&q=80&crop=entropy'],
            // Flowering
            ['name'=>'Anthurium',                    'category_id'=>$flowering->id,      'price'=>700,  'stock_quantity'=>15, 'description'=>'Glossy, heart-shaped blooms in red or pink that last for months. Long-lasting cut flower too.', 'is_featured'=>false, 'light'=>'Bright Indirect','water'=>'Weekly', 'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1603436326446-74c4b8c5e4d9?w=600&q=80'],
            ['name'=>'Kalanchoe (Flowering)',         'category_id'=>$flowering->id,      'price'=>350,  'stock_quantity'=>25, 'description'=>'Clusters of cheerful blooms in red, yellow, orange, and pink on a compact plant.', 'is_featured'=>false, 'light'=>'Bright',        'water'=>'Bi-weekly', 'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1490750967868-88df5691cc9f?w=600&q=80'],
            // Trailing/Hanging
            ['name'=>'Boston Fern',                  'category_id'=>$trailing->id,       'price'=>400,  'stock_quantity'=>22, 'description'=>'Lush, arching fronds that create a dramatic look in hanging baskets or tall shelves.', 'is_featured'=>false, 'light'=>'Indirect',     'water'=>'Twice weekly','difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=600&q=80'],
            ['name'=>'English Ivy',                  'category_id'=>$trailing->id,       'price'=>350,  'stock_quantity'=>25, 'description'=>'Classic trailing plant that drapes beautifully from shelves or hanging pots.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1466781783364-36c955e42a7f?w=600&q=80'],
            ['name'=>'Philodendron Brasil',          'category_id'=>$trailing->id,       'price'=>550,  'stock_quantity'=>20, 'description'=>'Fast-growing trailing Philodendron with stunning lime-green and dark-green variegated leaves.', 'is_featured'=>false,'light'=>'Medium',  'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1602923668104-8f9e03e77e62?w=600&q=80'],
            ['name'=>'Pothos Marble Queen',          'category_id'=>$trailing->id,       'price'=>400,  'stock_quantity'=>25, 'description'=>'Highly variegated pothos with creamy white and green marbled foliage. Easy to propagate.', 'is_featured'=>false,'light'=>'Low to Medium','water'=>'Weekly','difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1585116938581-6e565a1f9ef7?w=600&q=80'],
            // Low Maintenance
            ['name'=>'ZZ Plant (Zamioculcas)',       'category_id'=>$lowMaintenance->id, 'price'=>650,  'stock_quantity'=>25, 'description'=>'Virtually indestructible with glossy, waxy dark-green leaves. Thrives on neglect.', 'is_featured'=>true,  'light'=>'Low to Medium', 'water'=>'Monthly',   'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1632207691143-643e2a9a9361?w=600&q=80'],
            ['name'=>'Lucky Bamboo (2-Layer)',       'category_id'=>$lowMaintenance->id, 'price'=>500,  'stock_quantity'=>30, 'description'=>'Symbol of Feng Shui prosperity. Grows in water or soil and needs very little care.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80&sat=-100'],
            ['name'=>'Bird\'s Nest Fern',            'category_id'=>$lowMaintenance->id, 'price'=>450,  'stock_quantity'=>20, 'description'=>'Wavy, bright-green fronds radiating from a central rosette. Loves humidity.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1561322840-7b28da3ef988?w=600&q=80'],
            ['name'=>'Croton',                       'category_id'=>$lowMaintenance->id, 'price'=>500,  'stock_quantity'=>20, 'description'=>'Fiery leaves in red, orange, yellow, and green — essentially a living piece of art.', 'is_featured'=>false, 'light'=>'Bright',       'water'=>'Weekly',    'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1555955208-d5c5c2b8c8d9?w=600&q=80'],
            ['name'=>'Calathea Orbifolia',           'category_id'=>$lowMaintenance->id, 'price'=>900,  'stock_quantity'=>12, 'description'=>'Stunning round leaves striped in silver and green. Moves with light — called the "prayer plant."', 'is_featured'=>false,'light'=>'Medium',  'water'=>'Weekly',    'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1598880940671-c468a0655a42?w=600&q=80'],
            ['name'=>'Chinese Evergreen (Aglaonema)','category_id'=>$lowMaintenance->id, 'price'=>550,  'stock_quantity'=>22, 'description'=>'One of the most tolerant houseplants. Available in green, red, and pink varieties.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Very Easy', 'image_path'=>'https://images.unsplash.com/photo-1596547609652-9cf5d8c10616?w=600&q=80&hue=120'],
            ['name'=>'Parlor Palm (Chamaedorea)',    'category_id'=>$lowMaintenance->id, 'price'=>600,  'stock_quantity'=>18, 'description'=>'Compact, elegant palm that thrives indoors with minimal care. Perfect on desks.', 'is_featured'=>false, 'light'=>'Low to Medium', 'water'=>'Weekly',    'difficulty'=>'Easy',      'image_path'=>'https://images.unsplash.com/photo-1509423350716-97f9360b4e09?w=600&q=80&sat=50'],
            ['name'=>'Air Plant (Tillandsia) Set of 2','category_id'=>$lowMaintenance->id,'price'=>500, 'stock_quantity'=>25, 'description'=>'No soil needed — these live on air and moisture! Artistic conversation-starters.', 'is_featured'=>true,  'light'=>'Bright Indirect','water'=>'Mist daily', 'difficulty'=>'Medium',    'image_path'=>'https://images.unsplash.com/photo-1509587584298-0f3b3a3a1797?w=600&q=80&hue=60'],
        ];

        foreach ($products as $p) {
            $p['slug'] = \Illuminate\Support\Str::slug($p['name']);
            Product::create($p);
        }

        // Settings
        Setting::set('store_discount_percent', '0');
        Setting::set('hero_banner_image', '');
        Setting::set('store_name', 'GreenNest');
        Setting::set('hero_headline', 'Bring the Outdoors In');
        Setting::set('hero_subtext', 'Premium indoor plants delivered to your door in Kathmandu Valley.');
    }
}
